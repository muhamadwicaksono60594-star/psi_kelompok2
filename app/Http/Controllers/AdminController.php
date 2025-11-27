<?php

namespace App\Http\Controllers;
use App\Models\Lowongan;
use App\Models\Divisi;
use App\Models\Indent;
use App\Models\SuratBalasan;
use App\Models\Pendaftaran;
use App\Models\AlasanPenolakan;
use App\Mail\StatusPendaftaranMail;
use App\Mail\StatusIndentMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendaftarExport;
use App\Exports\InstansiExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class AdminController extends Controller
{
    public function index(Request $request){
    // Ambil filter tahun dan status dari request
    $tahun = $request->input('tahun');
    $status = $request->input('status');

    // === Query dasar untuk Pendaftaran ===
    $pendaftaranQuery = Pendaftaran::query();
    $indentQuery = Indent::query();

    if ($tahun) {
        $pendaftaranQuery->whereYear('created_at', $tahun);
        $indentQuery->whereYear('created_at', $tahun);
    }

    if ($status) {
        $pendaftaranQuery->where('status', $status);
        $indentQuery->where('status', $status);
    }

    // === A. Card Statistik (gabungan dua tabel) ===
    $totalPendaftar = $pendaftaranQuery->count() + $indentQuery->count();

    $pendaftarDiterima = (clone $pendaftaranQuery)->where('status', 'diterima')->count()
                        + (clone $indentQuery)->where('status', 'diterima')->count();

    $pendaftarDitolak = (clone $pendaftaranQuery)->where('status', 'ditolak')->count()
                        + (clone $indentQuery)->where('status', 'ditolak')->count();

    $pendaftarMenunggu = (clone $pendaftaranQuery)->where('status', 'menunggu')->count()
                        + (clone $indentQuery)->where('status', 'menunggu')->count();

    $pendaftarIndent = $indentQuery->count();
    $pendaftarLowongan = $pendaftaranQuery->count();

    $totalSuratBalasan = SuratBalasan::when($tahun, fn($q) => $q->whereYear('created_at', $tahun))->count();


    // === Mahasiswa & Siswa (gabungan dua tabel) ===
    $mahasiswa = (clone $pendaftaranQuery)->whereHas('user', fn($q) => $q->where('jenjang', 'Mahasiswa'))->count()
                + (clone $indentQuery)->whereHas('user', fn($q) => $q->where('jenjang', 'Mahasiswa'))->count();

    $siswa = (clone $pendaftaranQuery)->whereHas('user', fn($q) => $q->where('jenjang', 'Siswa'))->count()
                + (clone $indentQuery)->whereHas('user', fn($q) => $q->where('jenjang', 'Siswa'))->count();

    $pieData = [
        'labels' => ['Mahasiswa', 'Siswa'],
        'data' => [$mahasiswa, $siswa],
    ];

    // === B. Grafik Bulanan (gabungan dua tabel) ===
    $monthlyPendaftaran = (clone $pendaftaranQuery)
        ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as jumlah'))
        ->groupBy('bulan')->get();

    $monthlyIndent = (clone $indentQuery)
        ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as jumlah'))
        ->groupBy('bulan')->get();

    // Gabungkan hasil per bulan
    $monthlyData = [];
    for ($b = 1; $b <= 12; $b++) {
        $lowongan = $monthlyPendaftaran->firstWhere('bulan', $b)->jumlah ?? 0;
        $indent = $monthlyIndent->firstWhere('bulan', $b)->jumlah ?? 0;
        $monthlyData[$b] = $lowongan + $indent;
    }

    $bulanLabels = collect(range(1, 12))->map(fn($b) => date('F', mktime(0, 0, 0, $b, 1)));
    $jumlahPendaftar = collect($monthlyData)->values();
    $lineLabels = $bulanLabels;
    $lineData = $jumlahPendaftar;

    // === D. Ranking Asal Instansi (gabungan dua tabel) ===
    $instansiLowongan = (clone $pendaftaranQuery)
        ->select('asal_instansi', DB::raw('COUNT(*) as total'))
        ->groupBy('asal_instansi');

    $instansiGabungan = (clone $indentQuery)
        ->select('asal_instansi', DB::raw('COUNT(*) as total'))
        ->groupBy('asal_instansi')
        ->union($instansiLowongan)
        ->get()
        ->groupBy('asal_instansi')
        ->map(fn($items) => $items->sum('total'))
        ->sortDesc()
        ->take(10);

    $instansiLabels = $instansiGabungan->keys();
    $instansiTotal = $instansiGabungan->values();

    // === Daftar Tahun untuk Dropdown ===
    $tahunList = Pendaftaran::selectRaw('YEAR(created_at) as tahun')
        ->union(Indent::selectRaw('YEAR(created_at) as tahun'))
        ->distinct()
        ->orderByDesc('tahun')
        ->pluck('tahun');

    return view('admin.dashboard', compact(
        'tahun',
        'status',
        'tahunList',
        'totalPendaftar',
        'pendaftarDiterima',
        'pendaftarDitolak',
        'pendaftarMenunggu',
        'pendaftarIndent',
        'pendaftarLowongan',
        'mahasiswa',
        'siswa',
        'totalSuratBalasan',
        'pieData',
        'bulanLabels',
        'jumlahPendaftar',
        'lineLabels',
        'lineData',
        'instansiLabels',
        'instansiTotal'
    ));
    }

    public function cardDetail($jenis){
    switch ($jenis) {

        // === TOTAL (GABUNGAN) ===
        case 'total':
            $data = Pendaftaran::select('nama', 'asal_instansi', 'jurusan', 'status')
                ->get()
                ->concat(
                    Indent::select('nama', 'asal_instansi', 'jurusan', 'status')->get()
                )
                ->values();

            $title = "Total Semua Pendaftar";
            break;

        // === STATUS: DITERIMA ===
        case 'diterima':
            $data = Pendaftaran::select('nama', 'asal_instansi', 'jurusan', 'status')
                ->where('status', 'diterima')
                ->get()
                ->concat(
                    Indent::select('nama', 'asal_instansi', 'jurusan', 'status')
                        ->where('status', 'diterima')
                        ->get()
                )
                ->values();

            $title = "Pendaftar Diterima";
            break;

        // === STATUS: DITOLAK ===
        case 'ditolak':
            $data = Pendaftaran::select('nama', 'asal_instansi', 'jurusan', 'status')
                ->where('status', 'ditolak')
                ->get()
                ->concat(
                    Indent::select('nama', 'asal_instansi', 'jurusan', 'status')
                        ->where('status', 'ditolak')
                        ->get()
                )
                ->values();

            $title = "Pendaftar Ditolak";
            break;

        // === STATUS: MENUNGGU ===
        case 'menunggu':
            $data = Pendaftaran::select('nama', 'asal_instansi', 'jurusan', 'status')
                ->where('status', 'menunggu')
                ->get()
                ->concat(
                    Indent::select('nama', 'asal_instansi', 'jurusan', 'status')
                        ->where('status', 'menunggu')
                        ->get()
                )
                ->values();

            $title = "Pendaftar Menunggu";
            break;

        // === KHUSUS INDENT ===
        case 'indent':
            $data = Indent::select('nama', 'asal_instansi', 'jurusan', 'status')->get();
            $title = "Data Pendaftar Indent";
            break;

        // === KHUSUS LOWONGAN ===
        case 'lowongan':
            $data = Pendaftaran::select('nama', 'asal_instansi', 'jurusan', 'status')->get();
            $title = "Data Pendaftar Lowongan";
            break;

        default:
            abort(404);
    }

    return view('admin.card-detail', compact('data', 'title'));
    }


    public function lowonganIndex()
    {
        // ambil lowongan + relasi divisi
        $lowongan = Lowongan::with('divisi')->get();

        // ambil divisi untuk dropdown modal
        $divisi = Divisi::all();

        // kirim keduanya ke view
        return view('admin.lowongan.index', compact('lowongan', 'divisi'));
    }

    //fungsi lowongan
    public function lowonganCreate()
    {
        $divisi = Divisi::all();
        return view('admin.lowongan.create', compact('divisi'));
    }

    // 🔹 Simpan lowongan baru
    public function lowonganStore(Request $request)
    {
        $request->validate([
            'divisi_id' => 'required|exists:divisi,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kuota' => 'required|integer|min:1',
        ]);

        Lowongan::create($request->all());

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function lowonganEdit(Lowongan $lowongan)
    {
        $divisi = Divisi::all();
        return view('admin.lowongan.edit', compact('lowongan', 'divisi'));
    }

    public function lowonganUpdate(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'divisi_id' => 'required|exists:divisi,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kuota' => 'required|integer|min:1',
        ]);

        $lowongan->update($request->all());

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil diperbarui');
    }

    //  Hapus lowongan
    public function lowonganDestroy(Lowongan $lowongan)
    {
        $lowongan->delete();

        return redirect()->route('admin.lowongan.index')
                        ->with('success', 'Lowongan berhasil dihapus!');
    }

    public function indexPendaftar(Request $request)
    {
    $pendaftars = Pendaftaran::with('user')->get();
    $filter = $request->get('filter', 'lowongan');

    return view('admin.tabel', compact('pendaftars', 'filter'));
    }

    public function indexIndent(Request $request)
    {
    $indent = Indent::with('user')->get();
    $filter = $request->get('filter', 'lowongan');

    return view('admin.tabelindent', compact('indent', 'filter'));
    }

    public function detail($id)
    {
    
    $pendaftar = Pendaftaran::with('user')->findOrFail($id);
    return view('admin.verifikasi', compact('pendaftar'));
    }

    public function verifikasiIndent($id)
    {
        $indent = Indent::with(['user', 'berkas_indent'])->findOrFail($id);
        return view('admin.detailindent', compact('indent'));
    }

    public function terimaPendaftar($id)
    {
        try {
            $pendaftar = Pendaftaran::findOrFail($id);
            $pendaftar->status = 'diterima';
            $pendaftar->save();

            // Kirim email setelah status berhasil diperbarui
            if ($pendaftar->user && $pendaftar->user->email) {
                Mail::to($pendaftar->user->email)->send(
                    new StatusPendaftaranMail($pendaftar->nama, 'diterima')
                );
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function tolakPendaftar(Request $request, $id)
    {
        try {
            $pendaftaran = Pendaftaran::findOrFail($id);
            $pendaftaran->status = 'ditolak';
            $pendaftaran->save();

            // Simpan alasan ke tabel alasan_penolakan
            AlasanPenolakan::create([
                'pendaftar_id' => $id,
                'indent_id' => null,
                'alasan' => $request->alasan,
            ]);

            // Kirim email notifikasi penolakan
            if ($pendaftaran->user && $pendaftaran->user->email) {
                Mail::to($pendaftaran->user->email)->send(
                    new StatusPendaftaranMail($pendaftaran->nama, 'ditolak')
                );
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function terimaIndent($id)
    {
        try {
            $indent = Indent::findOrFail($id);
            $indent->update(['status' => 'diterima']);

            if ($indent->user && $indent->user->email) {
                Mail::to($indent->user->email)->send(
                    new StatusIndentMail($indent->nama, 'diterima')
                );
            }
            return response()->json([
                'success' => true,
                'message' => 'Indent berhasil diterima.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function tolakIndent(Request $request, $id)
    {
        try {
            $indent = Indent::findOrFail($id);
            $indent->status = 'Ditolak';
            $indent->save();

            // Simpan alasan ke tabel alasan_penolakan
            AlasanPenolakan::create([
                'indent_id' => $id,
                'pendaftar_id' => null,
                'alasan' => $request->alasan,
            ]);
            if ($indent->user && $indent->user->email) {
                Mail::to($indent->user->email)->send(
                    new StatusIndentMail($indent->nama, 'ditolak')
                );
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage()); // ✅ Sekarang Log sudah dikenali
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    
    }

    public function updateStatus(Request $request, $id)
    {
    $pendaftaran = Pendaftaran::findOrFail($id);

    // Update status di database
    $pendaftaran->status = $request->status;
    $pendaftaran->save();

    // Generate surat otomatis berdasarkan status
    if ($request->status == 'Diterima') {
        $this->buatSuratBalasan($pendaftaran, 'surat_diterima');
    } elseif ($request->status == 'Ditolak') {
        $this->buatSuratBalasan($pendaftaran, 'surat_ditolak');
    }

    return redirect()->back()->with('success', 'Status diperbarui dan surat otomatis dibuat!');
    }

    private function buatSuratBalasan($pendaftaran, $template)
    {
    // Load template Blade sesuai tipe surat
    $pdf = Pdf::loadView('surat.' . $template, compact('pendaftaran'));

    // Buat nama file otomatis
    $fileName = $template . '_' . $pendaftaran->id . '.pdf';

    // Simpan ke folder storage
    $path = 'public/surat_balasan/' . $fileName;
    Storage::put($path, $pdf->output());

    // (Opsional) Simpan path file ke kolom di tabel pendaftaran
    $pendaftaran->surat_balasan = 'storage/surat_balasan/' . $fileName;
    $pendaftaran->save();
    }

    public function tolakDenganAlasan(Request $request, $id)
    {
        try {
        $request->validate([
            'alasan' => 'required|string|max:255',
        ]);

        $pendaftar = Pendaftaran::findOrFail($id);
        $pendaftar->update(['status' => 'ditolak']);

        AlasanPenolakan::create([
            'pendaftaran_id' => $pendaftar->id,
            'alasan' => $request->alasan,
        ]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
    }

    public function cetakSuratBalasanIndent($id)
    {
    $indent = Indent::findOrFail($id);

    $view = $indent->status == 'diterima'
        ? 'pdf.surat_indent_diterima'
        : 'pdf.surat_indent_ditolak';

    $pdf = Pdf::loadView($view, compact('indent'));

    $fileName = 'surat_indent_' . $indent->id . '.pdf';
    $filePath = 'surat_indent/' . $fileName;

    // Simpan file ke storage
    Storage::disk('public')->put($filePath, $pdf->output());

    // Simpan ke tabel surat_balasan
    SuratBalasan::create([
        'indent_id' => $indent->id,
        'pendaftar_id' => null,
        'jenis' => 'indent',
        'status_surat' => $indent->status,
        'file_path' => $filePath,
    ]);

    return $pdf->stream($fileName);
    }

    public function cetakSuratBalasanPendaftar($id)
    {
    $pendaftar = Pendaftaran::with('alasanPenolakan')->findOrFail($id);

    $view = $pendaftar->status == 'diterima'
        ? 'pdf.surat_pendaftar_diterima'
        : 'pdf.surat_pendaftar_ditolak';

    $pdf = Pdf::loadView($view, compact('pendaftar'));

    $fileName = 'surat_pendaftar_' . $pendaftar->id . '.pdf';
    $filePath = 'surat_pendaftar/' . $fileName;

    Storage::disk('public')->put($filePath, $pdf->output());

    SuratBalasan::updateOrCreate(
        ['pendaftar_id' => $pendaftar->id],
        [
            'indent_id' => null,
            'jenis' => 'pendaftar',
            'status_surat' => $pendaftar->status,
            'file_path' => $filePath,
        ]
    );

    return $pdf->stream($fileName);
    }
    
    public function laporan(Request $request){
    $tahun = $request->input('tahun');
    $status = $request->input('status', 'semua');
    $jenis = $request->input('jenis', 'semua');

    $pendaftaranQuery = Pendaftaran::query();
    $indentQuery = Indent::query();

    if ($tahun) {
        $pendaftaranQuery->whereYear('created_at', $tahun);
        $indentQuery->whereYear('created_at', $tahun);
    }

    if ($status != 'semua') {
        $pendaftaranQuery->where('status', $status);
        $indentQuery->where('status', $status);
    }

    $pendaftaran = $pendaftaranQuery->get()->map(function ($item) {
        return [
            'nama' => $item->nama ?? '-',
            'asal' => $item->asal_instansi ?? '-',
            'jenis' => 'Lowongan',
            'status' => ucfirst($item->status),
            'tanggal' => $item->created_at ? $item->created_at->format('d-m-Y') : '-',
        ];
    });

    $indent = $indentQuery->get()->map(function ($item) {
        return [
            'nama' => $item->nama ?? '-',
            'asal' => $item->asal_instansi ?? '-',
            'jenis' => 'Indent',
            'status' => ucfirst($item->status),
            'tanggal' => $item->created_at ? $item->created_at->format('d-m-Y') : '-',
        ];
    });

    $data = collect();

    if ($jenis == 'lowongan') {
        $data = $pendaftaran;
    } elseif ($jenis == 'indent') {
        $data = $indent;
    } else {
        $data = $pendaftaran->merge($indent);
    }

    return view('admin.laporan', compact('data', 'tahun', 'status', 'jenis'));
    }

    public function exportPdf(Request $request){
    $tahun = $request->input('tahun');
    $status = $request->input('status');
    $jenis = $request->input('jenis');

    $pendaftaranQuery = Pendaftaran::query();
    $indentQuery = Indent::query();

    if ($tahun) {
        $pendaftaranQuery->whereYear('created_at', $tahun);
        $indentQuery->whereYear('created_at', $tahun);
    }

    if ($status && $status !== 'semua') {
        $pendaftaranQuery->where('status', $status);
        $indentQuery->where('status', $status);
    }

    if ($jenis === 'lowongan') {
        $data = $pendaftaranQuery->get();
    } elseif ($jenis === 'indent') {
        $data = $indentQuery->get();
    } else {
        $data = $pendaftaranQuery->get()->merge($indentQuery->get());
    }

    $pdf = Pdf::loadView('admin.laporan_pdf', compact('data', 'tahun', 'status', 'jenis'));
    return $pdf->download('laporan_pendaftar.pdf');
    }

    public function exportExcelView(Request $request){
    $tahun = $request->tahun;
    $status = $request->status ?? 'semua';
    $jenis = $request->jenis ?? 'semua';

    // === Ambil data berdasarkan filter ===
    $pendaftaranQuery = Pendaftaran::query();
    $indentQuery = Indent::query();

    if ($tahun && $tahun !== 'semua') {
        $pendaftaranQuery->whereYear('created_at', $tahun);
        $indentQuery->whereYear('created_at', $tahun);
    }

    if ($status !== 'semua') {
        $pendaftaranQuery->where('status', $status);
        $indentQuery->where('status', $status);
    }

    $data = collect();

    if ($jenis === 'semua' || $jenis === 'lowongan') {
        $data = $data->merge($pendaftaranQuery->get()->map(fn($p) => [
            'nama' => $p->nama ?? '-',
            'asal' => $p->asal_instansi ?? '-',
            'jenis' => 'Lowongan',
            'status' => ucfirst($p->status),
            'tanggal' => $p->created_at->format('d-m-Y'),
        ]));
    }

    if ($jenis === 'semua' || $jenis === 'indent') {
        $data = $data->merge($indentQuery->get()->map(fn($i) => [
            'nama' => $i->nama ?? '-',
            'asal' => $i->asal_instansi ?? '-',
            'jenis' => 'Indent',
            'status' => ucfirst($i->status),
            'tanggal' => $i->created_at->format('d-m-Y'),
        ]));
    }

    // === Render ke view ===
    $view = view('admin.laporan_excel', compact('data'))->render();

    // === Export ke Excel ===
    return Excel::download(new class($view) implements \Maatwebsite\Excel\Concerns\FromView {
        protected $view;
        public function __construct($view) { $this->view = $view; }
        public function view(): \Illuminate\Contracts\View\View { return $this->view; }
    }, 'laporan_pendaftar.xlsx');
    }

    public function exportPdfView(Request $request){
    $tahun = $request->tahun;
    $status = $request->status ?? 'semua';
    $jenis = $request->jenis ?? 'semua';

    $pendaftaranQuery = Pendaftaran::query();
    $indentQuery = Indent::query();

    if ($tahun && $tahun !== 'semua') {
        $pendaftaranQuery->whereYear('created_at', $tahun);
        $indentQuery->whereYear('created_at', $tahun);
    }

    if ($status !== 'semua') {
        $pendaftaranQuery->where('status', $status);
        $indentQuery->where('status', $status);
    }

    $data = collect();

    if ($jenis === 'semua' || $jenis === 'lowongan') {
        $data = $data->merge($pendaftaranQuery->get()->map(fn($p) => [
            'nama' => $p->nama ?? '-',
            'asal' => $p->asal_instansi ?? '-',
            'jenis' => 'Lowongan',
            'status' => ucfirst($p->status),
            'tanggal' => $p->created_at->format('d-m-Y'),
        ]));
    }

    if ($jenis === 'semua' || $jenis === 'indent') {
        $data = $data->merge($indentQuery->get()->map(fn($i) => [
            'nama' => $i->nama ?? '-',
            'asal' => $i->asal_instansi ?? '-',
            'jenis' => 'Indent',
            'status' => ucfirst($i->status),
            'tanggal' => $i->created_at->format('d-m-Y'),
        ]));
    }

    $pdf = Pdf::loadView('admin.laporan_pdf', compact('data'))->setPaper('a4', 'portrait');
    return $pdf->download('laporan_pendaftar.pdf');
    }

// --------------------------------------
// Helper: build filters for queries
// --------------------------------------
private function applyDateRange($query, $start, $end)
{
    if ($start && $end) {
        // pastikan format Y-m-d
        $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
    } elseif ($start && !$end) {
        $query->whereDate('created_at', '>=', $start);
    } elseif (!$start && $end) {
        $query->whereDate('created_at', '<=', $end);
    }
}

// -------------------------
// Laporan Pendaftar (view)
// -------------------------
public function laporanPendaftar(Request $req)
{
    // =============== FILTER PARAMETER ===============
    $jenis  = $req->jenis;     // semua / lowongan / indent
    $start  = $req->start;
    $end    = $req->end;
    $bulan  = $req->bulan;
    $tahun  = $req->tahun;

    // =============== QUERY LOWONGAN ===============
    $qLow = Pendaftaran::select(
        'nama', 'asal_instansi', 'jurusan',
        'tanggal_mulai', 'tanggal_selesai', 'created_at', 'status'
    );

    // =============== QUERY INDENT ===============
    $qInd = Indent::select(
        'nama', 'asal_instansi', 'jurusan',
        'tanggal_mulai', 'tanggal_selesai', 'created_at', 'status'
    );

    // =============== FILTER TANGGAL RANGE ===============
    if ($start && $end) {
        $qLow->whereBetween('created_at', [$start, $end]);
        $qInd->whereBetween('created_at', [$start, $end]);
    }

    // =============== FILTER BULAN ===============
    if ($bulan) {
        $qLow->whereMonth('created_at', $bulan);
        $qInd->whereMonth('created_at', $bulan);
    }

    // =============== FILTER TAHUN ===============
    if ($tahun) {
        $qLow->whereYear('created_at', $tahun);
        $qInd->whereYear('created_at', $tahun);
    }

    // =============== FILTER JENIS ===============
    if ($jenis == "lowongan") {
        $data = $qLow->get(); // hanya lowongan
    } elseif ($jenis == "indent") {
        $data = $qInd->get(); // hanya indent
    } else {
        // semua → gabungkan
        $data = $qLow->get()->concat($qInd->get());
    }

    // =============== AGAR TIDAK MENJADI ARRAY ===============
    // ubah ke object (supaya Blade tetap pakai $item->nama)
    $data = $data->map(function ($row) {
        return (object) [
            'nama'            => $row->nama,
            'asal_instansi'   => $row->asal_instansi,
            'jurusan'         => $row->jurusan,
            'tanggal_mulai'   => $row->tanggal_mulai,
            'tanggal_selesai' => $row->tanggal_selesai,
            'status'          => $row->status,
            'created_at'      => $row->created_at,
        ];
    });

    $title = "Laporan Semua Pendaftar (Lowongan + Indent)";

    return view('admin.laporan.pendaftar', compact('data', 'title'));
}

// -------------------------
// Laporan Diterima
// -------------------------
public function laporanDiterima(Request $req)
{
    $req->merge(['status' => 'diterima']);
    // reuse laporanPendaftar's logic by applying status filter
    $start = $req->start; $end = $req->end; $bulan = $req->bulan; $tahun = $req->tahun; $jenis = $req->jenis ?? 'semua'; $lowonganId = $req->lowongan_id;

    $qP = Pendaftaran::where('status','diterima')->select('id','nama','asal_instansi','jurusan','status','created_at','tanggal_mulai','tanggal_selesai');
    $qI = Indent::where('status','diterima')->select('id','nama','asal_instansi','jurusan','status','created_at','tanggal_mulai','tanggal_selesai');

    $this->applyDateRange($qP, $start, $end);
    $this->applyDateRange($qI, $start, $end);

    if ($bulan) { $qP->whereMonth('created_at',$bulan); $qI->whereMonth('created_at',$bulan); }
    if ($tahun) { $qP->whereYear('created_at',$tahun); $qI->whereYear('created_at',$tahun); }
    if ($lowonganId) { $qP->where('lowongan_id',$lowonganId); }

    if ($jenis === 'lowongan') {
        $data = $qP->get()->map(function($r){
            $r->setAttribute('jenis', 'Lowongan');
            return $r;
        });

    } elseif ($jenis === 'indent') {

        $data = $qI->get()->map(function($r){
            $r->setAttribute('jenis', 'Indent');
            return $r;
        });

    } else {
        $data = $qP->get()->map(function($r){
            $r->setAttribute('jenis', 'Lowongan');
            return $r;
        })->concat(
            $qI->get()->map(function($r){
                $r->setAttribute('jenis', 'Indent');
                return $r;
            })
        );
    }

    $data = collect($data)->sortByDesc('created_at')->values();
    $title = "Laporan Pendaftar Diterima";
    return view('admin.laporan.pendaftar', compact('data','title','start','end','bulan','tahun','jenis','lowonganId'));
}

// -------------------------
// Laporan Ditolak
// -------------------------
public function laporanDitolak(Request $req)
{
    $start = $req->start; $end = $req->end; $bulan = $req->bulan; $tahun = $req->tahun; $jenis = $req->jenis ?? 'semua'; $lowonganId = $req->lowongan_id;

    $qP = Pendaftaran::where('status','ditolak')->select('id','nama','asal_instansi','jurusan','status','created_at','tanggal_mulai','tanggal_selesai');
    $qI = Indent::where('status','ditolak')->select('id','nama','asal_instansi','jurusan','status','created_at','tanggal_mulai','tanggal_selesai');

    $this->applyDateRange($qP, $start, $end);
    $this->applyDateRange($qI, $start, $end);

    if ($bulan) { $qP->whereMonth('created_at',$bulan); $qI->whereMonth('created_at',$bulan); }
    if ($tahun) { $qP->whereYear('created_at',$tahun); $qI->whereYear('created_at',$tahun); }
    if ($lowonganId) { $qP->where('lowongan_id',$lowonganId); }

if ($jenis === 'lowongan') {
    $data = $qP->get()->map(function($r){
        $r->setAttribute('jenis', 'Lowongan');
        return $r;
    });

} elseif ($jenis === 'indent') {

    $data = $qI->get()->map(function($r){
        $r->setAttribute('jenis', 'Indent');
        return $r;
    });

} else {
    $data = $qP->get()->map(function($r){
        $r->setAttribute('jenis', 'Lowongan');
        return $r;
    })->concat(
        $qI->get()->map(function($r){
            $r->setAttribute('jenis', 'Indent');
            return $r;
        })
    );
}


    $data = collect($data)->sortByDesc('created_at')->values();
    $title = "Laporan Pendaftar Ditolak";
    return view('admin.laporan.pendaftar', compact('data','title','start','end','bulan','tahun','jenis','lowonganId'));
}

// -------------------------
// Laporan Instansi
// -------------------------
public function laporanInstansi(Request $req)
{
    $start = $req->start; $end = $req->end; $bulan = $req->bulan; $tahun = $req->tahun;

    // Pendaftaran aggregated
    $q1 = Pendaftaran::select(
            'asal_instansi',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "diterima" THEN 1 ELSE 0 END) as diterima'),
            DB::raw('SUM(CASE WHEN status = "ditolak" THEN 1 ELSE 0 END) as ditolak'),
            DB::raw('SUM(CASE WHEN status = "menunggu" THEN 1 ELSE 0 END) as menunggu')
        );

    $q2 = Indent::select(
            'asal_instansi',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "diterima" THEN 1 ELSE 0 END) as diterima'),
            DB::raw('SUM(CASE WHEN status = "ditolak" THEN 1 ELSE 0 END) as ditolak'),
            DB::raw('SUM(CASE WHEN status = "menunggu" THEN 1 ELSE 0 END) as menunggu')
        );

    $this->applyDateRange($q1, $start, $end);
    $this->applyDateRange($q2, $start, $end);

    if ($bulan) { $q1->whereMonth('created_at',$bulan); $q2->whereMonth('created_at',$bulan); }
    if ($tahun) { $q1->whereYear('created_at',$tahun); $q2->whereYear('created_at',$tahun); }

    $p = $q1->groupBy('asal_instansi')->get();
    $i = $q2->groupBy('asal_instansi')->get();

    // combine
    $combined = $p->concat($i)
        ->groupBy('asal_instansi')
        ->map(function ($rows, $instansi) {
            return [
                'asal_instansi' => $instansi,
                'total' => $rows->sum('total'),
                'diterima' => $rows->sum('diterima'),
                'ditolak' => $rows->sum('ditolak'),
                'menunggu' => $rows->sum('menunggu'),
            ];
        })
        ->values();

    $title = "Laporan Per-Instansi";
    return view('admin.laporan.instansi', compact('combined','title','start','end','bulan','tahun'));
}

// -------------------------
// EXPORT Pendaftar -> Excel
// -------------------------
public function exportPendaftarExcel(Request $req)
{
    // Reuse laporanPendaftar logic to build $pendaftars collection
    $req->merge($req->all()); // keep same inputs
    $start = $req->start; $end = $req->end; $bulan = $req->bulan; $tahun = $req->tahun; $jenis = $req->jenis ?? 'semua'; $lowonganId = $req->lowongan_id;

    $qP = Pendaftaran::select('nama','asal_instansi','jurusan','status','created_at','tanggal_mulai','tanggal_selesai')
            ->when($lowonganId, fn($q) => $q->where('lowongan_id', $lowonganId));
    $qI = Indent::select('nama','asal_instansi','jurusan','status','created_at','tanggal_mulai','tanggal_selesai');

    $this->applyDateRange($qP, $start, $end);
    $this->applyDateRange($qI, $start, $end);
    if ($bulan) { $qP->whereMonth('created_at',$bulan); $qI->whereMonth('created_at',$bulan); }
    if ($tahun) { $qP->whereYear('created_at',$tahun); $qI->whereYear('created_at',$tahun); }

    if ($jenis==='lowongan') {
        $rows = $qP->get()->map(fn($r) => [
            'Nama'=>$r->nama,
            'Asal Instansi'=>$r->asal_instansi,
            'Jurusan'=>$r->jurusan,
            'Jenis'=>'Lowongan',
            'Status'=>ucfirst($r->status),
            'Tanggal Daftar'=>$r->created_at->format('d-m-Y'),
            'Tanggal Mulai'=>$r->tanggal_mulai ? date('d-m-Y', strtotime($r->tanggal_mulai)) : '-',
            'Tanggal Selesai'=>$r->tanggal_selesai ? date('d-m-Y', strtotime($r->tanggal_selesai)) : '-',
        ]);
    } elseif ($jenis==='indent') {
        $rows = $qI->get()->map(fn($r) => [
            'Nama'=>$r->nama,
            'Asal Instansi'=>$r->asal_instansi,
            'Jurusan'=>$r->jurusan,
            'Jenis'=>'Indent',
            'Status'=>ucfirst($r->status),
            'Tanggal Daftar'=>$r->created_at->format('d-m-Y'),
            'Tanggal Mulai'=>$r->tanggal_mulai ? date('d-m-Y', strtotime($r->tanggal_mulai)) : '-',
            'Tanggal Selesai'=>$r->tanggal_selesai ? date('d-m-Y', strtotime($r->tanggal_selesai)) : '-',
        ]);
    } else {
        $rows = $qP->get()->map(fn($r) => [
            'Nama'=>$r->nama, 'Asal Instansi'=>$r->asal_instansi, 'Jurusan'=>$r->jurusan,
            'Jenis'=>'Lowongan','Status'=>ucfirst($r->status),
            'Tanggal Daftar'=>$r->created_at->format('d-m-Y'),
            'Tanggal Mulai'=> $r->tanggal_mulai ? date('d-m-Y', strtotime($r->tanggal_mulai)) : '-',
            'Tanggal Selesai'=> $r->tanggal_selesai ? date('d-m-Y', strtotime($r->tanggal_selesai)) : '-',
        ])->concat(
            $qI->get()->map(fn($r)=>[
                'Nama'=>$r->nama, 'Asal Instansi'=>$r->asal_instansi, 'Jurusan'=>$r->jurusan,
                'Jenis'=>'Indent','Status'=>ucfirst($r->status),
                'Tanggal Daftar'=>$r->created_at->format('d-m-Y'),
                'Tanggal Mulai'=> $r->tanggal_mulai ? date('d-m-Y', strtotime($r->tanggal_mulai)) : '-',
                'Tanggal Selesai'=> $r->tanggal_selesai ? date('d-m-Y', strtotime($r->tanggal_selesai)) : '-',
            ])
        );
    }

    $exportCollection = collect($rows)->values()->map(function($row, $k){
        return array_merge(['No' => $k+1], $row);
    });

    return Excel::download(new PendaftarExport(collect($exportCollection)), 'laporan_pendaftar.xlsx');
}

// -------------------------
// EXPORT Pendaftar -> PDF
// -------------------------
public function exportPendaftarPdf(Request $req)
{
    // reuse same data building logic as Excel
    $start = $req->start; $end = $req->end; $bulan = $req->bulan; $tahun = $req->tahun; $jenis = $req->jenis ?? 'semua'; $lowonganId = $req->lowongan_id;
    $qP = Pendaftaran::select('nama','asal_instansi','jurusan','status','created_at','tanggal_mulai','tanggal_selesai')
            ->when($lowonganId, fn($q) => $q->where('lowongan_id', $lowonganId));
    $qI = Indent::select('nama','asal_instansi','jurusan','status','created_at','tanggal_mulai','tanggal_selesai');

    $this->applyDateRange($qP, $start, $end);
    $this->applyDateRange($qI, $start, $end);
    if ($bulan) { $qP->whereMonth('created_at',$bulan); $qI->whereMonth('created_at',$bulan); }
    if ($tahun) { $qP->whereYear('created_at',$tahun); $qI->whereYear('created_at',$tahun); }

    if ($jenis==='lowongan') {
        $rows = $qP->get()->map(fn($r)=> (object)[
            'nama'=>$r->nama,'asal_instansi'=>$r->asal_instansi,'jurusan'=>$r->jurusan,
            'jenis'=>'Lowongan','status'=>ucfirst($r->status),'tanggal_daftar'=>$r->created_at->format('d-m-Y'),
            'tanggal_mulai'=>$r->tanggal_mulai ? date('d-m-Y', strtotime($r->tanggal_mulai)) : '-',
            'tanggal_selesai'=>$r->tanggal_selesai ? date('d-m-Y', strtotime($r->tanggal_selesai)) : '-',
        ]);
    } elseif ($jenis==='indent') {
        $rows = $qI->get()->map(fn($r)=> (object)[
            'nama'=>$r->nama,'asal_instansi'=>$r->asal_instansi,'jurusan'=>$r->jurusan,
            'jenis'=>'Indent','status'=>ucfirst($r->status),'tanggal_daftar'=>$r->created_at->format('d-m-Y'),
            'tanggal_mulai'=>$r->tanggal_mulai ? date('d-m-Y', strtotime($r->tanggal_mulai)) : '-',
            'tanggal_selesai'=>$r->tanggal_selesai ? date('d-m-Y', strtotime($r->tanggal_selesai)) : '-',
        ]);
    } else {
        $rows = $qP->get()->map(fn($r)=> (object)[
            'nama'=>$r->nama,'asal_instansi'=>$r->asal_instansi,'jurusan'=>$r->jurusan,
            'jenis'=>'Lowongan','status'=>ucfirst($r->status),'tanggal_daftar'=>$r->created_at->format('d-m-Y'),
            'tanggal_mulai'=>$r->tanggal_mulai ? date('d-m-Y', strtotime($r->tanggal_mulai)) : '-',
            'tanggal_selesai'=>$r->tanggal_selesai ? date('d-m-Y', strtotime($r->tanggal_selesai)) : '-',
        ])->concat(
            $qI->get()->map(fn($r)=> (object)[
                'nama'=>$r->nama,'asal_instansi'=>$r->asal_instansi,'jurusan'=>$r->jurusan,
                'jenis'=>'Indent','status'=>ucfirst($r->status),'tanggal_daftar'=>$r->created_at->format('d-m-Y'),
                'tanggal_mulai'=>$r->tanggal_mulai ? date('d-m-Y', strtotime($r->tanggal_mulai)) : '-',
                'tanggal_selesai'=>$r->tanggal_selesai ? date('d-m-Y', strtotime($r->tanggal_selesai)) : '-',
            ])
        );
    }

    $rows = collect($rows)->values();
    $pdf = Pdf::loadView('admin.laporan.pdf_pendaftar', [
        'rows' => $rows,
        'title' => 'Laporan Pendaftar',
        'start' => $start, 'end' => $end, 'jenis' => $jenis
    ])->setPaper('a4','landscape');

    return $pdf->download('laporan_pendaftar.pdf');
}

// -------------------------
// EXPORT Instansi -> Excel
// -------------------------
public function exportInstansiExcel(Request $req)
{
    $start = $req->start; $end = $req->end; $bulan = $req->bulan; $tahun = $req->tahun;
    
    $q1 = Pendaftaran::select('asal_instansi', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN status="diterima" THEN 1 ELSE 0 END) as diterima'), DB::raw('SUM(CASE WHEN status="ditolak" THEN 1 ELSE 0 END) as ditolak'));
    $q2 = Indent::select('asal_instansi', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN status="diterima" THEN 1 ELSE 0 END) as diterima'), DB::raw('SUM(CASE WHEN status="ditolak" THEN 1 ELSE 0 END) as ditolak'));

    $this->applyDateRange($q1, $start, $end);
    $this->applyDateRange($q2, $start, $end);
    if ($bulan) { $q1->whereMonth('created_at',$bulan); $q2->whereMonth('created_at',$bulan); }
    if ($tahun) { $q1->whereYear('created_at',$tahun); $q2->whereYear('created_at',$tahun); }

    $p = $q1->groupBy('asal_instansi')->get();
    $i = $q2->groupBy('asal_instansi')->get();

    $combined = $p->concat($i)->groupBy('asal_instansi')->map(function($group,$inst){
        return [
            'asal_instansi'=>$inst,
            'total'=>$group->sum('total'),
            'diterima'=>$group->sum('diterima'),
            'ditolak'=>$group->sum('ditolak'),
        ];
    })->values();

    $exportCollection = $combined->map(function($row, $k){
        return [
            'No' => $k+1,
            'Asal Instansi' => $row['asal_instansi'],
            'Total Pendaftar' => $row['total'],
            'Diterima' => $row['diterima'],
            'Ditolak' => $row['ditolak'],
        ];
    });
    $title = "Laporan Pendaftar Diterima";
    return Excel::download(new InstansiExport(collect($exportCollection,$title)), 'laporan_instansi.xlsx');
}

// -------------------------
// EXPORT Instansi -> PDF
// -------------------------
public function exportInstansiPdf(Request $req)
{
    $start = $req->start; $end = $req->end; $bulan = $req->bulan; $tahun = $req->tahun;

    $q1 = Pendaftaran::select('asal_instansi', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN status="diterima" THEN 1 ELSE 0 END) as diterima'), DB::raw('SUM(CASE WHEN status="ditolak" THEN 1 ELSE 0 END) as ditolak'));
    $q2 = Indent::select('asal_instansi', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN status="diterima" THEN 1 ELSE 0 END) as diterima'), DB::raw('SUM(CASE WHEN status="ditolak" THEN 1 ELSE 0 END) as ditolak'));

    $this->applyDateRange($q1, $start, $end);
    $this->applyDateRange($q2, $start, $end);
    if ($bulan) { $q1->whereMonth('created_at',$bulan); $q2->whereMonth('created_at',$bulan); }
    if ($tahun) { $q1->whereYear('created_at',$tahun); $q2->whereYear('created_at',$tahun); }

    $p = $q1->groupBy('asal_instansi')->get();
    $i = $q2->groupBy('asal_instansi')->get();

    $combined = $p->concat($i)->groupBy('asal_instansi')->map(function($group,$inst){
        return [
            'asal_instansi'=>$inst,
            'total'=>$group->sum('total'),
            'diterima'=>$group->sum('diterima'),
            'ditolak'=>$group->sum('ditolak'),
        ];
    })->values();

    $pdf = Pdf::loadView('admin.laporan.pdf_instansi', [
        'rows' => $combined,
        'title' => 'Laporan Per-Instansi',
        'start' => $start, 'end' => $end
    ])->setPaper('a4','portrait');

    return $pdf->download('laporan_instansi.pdf');
}




}
