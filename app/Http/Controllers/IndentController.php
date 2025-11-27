<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Indent;
use App\Models\Berkas;
use App\Models\BerkasIndent; 

class IndentController extends Controller
{
    public function index()
    {
    // $indents = Indent::all();
    // return view('indent.indent', compact('indents'));
    }

    public function create()
    {
        $indents = Indent::all();
        return view('indent.indent', compact('indents'));
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
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'berkas.*' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Simpan data indent
        $indent = Indent::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'asal_instansi' => $request->asal_instansi,
            'jurusan' => $request->jurusan,
            'nim_nis' => $request->nim_nis,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'menunggu',
        ]);

        // Upload semua berkas indent ke tabel berkas
        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $file) {
                $path = $file->store('berkas_indent', 'public');

                BerkasIndent::create([
                    'indent_id' => $indent->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path' => $path,
                    'jenis' => 'indent',
                ]);
            }
}
        return redirect()->route('status.status')->with('success', 'Pendaftaran Indent berhasil dikirim!');
    }

    public function status()
    {
        $user = Auth::user();
        $indents = Indent::where('user_id', $user->id)->with(['berkas' => function($query){
            $query->where('jenis', 'indent');
        }])->get();

        return view('indent.status', compact('indents'));
    }
}
