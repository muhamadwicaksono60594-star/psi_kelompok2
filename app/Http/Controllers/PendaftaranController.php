<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Berkas;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $lowongan = Lowongan::with('divisi')->get();
        return view('pendaftar.dashboard', compact('lowongan'));
    }

    public function pendaftaran(){
        return view('pendaftar.pendaftaran');
    }


    // {
        // public function status($nim_nis)
    //     $pendaftaran = Pendaftaran::where('nim_nis', $nim_nis)->first();

    //     if (!$pendaftaran) {
    //         return view('pendaftar.status', ['message' => 'Data tidak ditemukan']);
    //     }

    //     return view('pendaftar.status', compact('pendaftaran'));
    // }

    
    public function create($lowongan_id)
    {
        $lowongan = Lowongan::findOrFail($lowongan_id);
        return view('pendaftar.pendaftaranlowongan', compact('lowongan'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required|string|max:255',
        'asal_instansi' => 'required|string|max:255',
        'jurusan' => 'required|string|max:255',
        'nim_nis' => 'required|string|max:20',
        'no_telepon' => 'required|string|max:20',
        'alamat' => 'required|string|max:255',
        'berkas.*' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // validasi tiap file
    ]);

    // Simpan data pendaftar
    $pendaftar = Pendaftaran::create([
        'user_id' => Auth::id(), 
        'nama' => $request->nama,
        'asal_instansi' => $request->asal_instansi,
        'jurusan' => $request->jurusan,
        'nim_nis' => $request->nim_nis,
        'no_telepon' => $request->no_telepon,
        'alamat' => $request->alamat,
        'status' => 'menunggu',
    ]);

    // Simpan semua file berkas
    if ($request->hasFile('berkas')) {
        foreach ($request->file('berkas') as $file) {
            $path = $file->store('berkas_pendaftar', 'public');

            Berkas::create([
                'pendaftar_id' => $pendaftar->id,
                'nama_file' => $file->getClientOriginalName(),
                'path' => $path,
                'jenis' => 'dokumen',
            ]);
        }
    }

    return redirect()->route('status.status')->with('success', 'Pendaftaran berhasil dikirim!');
    }

    public function status()
    {
        $user = Auth::user();
            $pendaftaran = Pendaftaran::where('user_id', $user->id)->with('berkas')->first();

        return view('status.status', compact('pendaftaran'));
    }



}
