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
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard'); 
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

}
