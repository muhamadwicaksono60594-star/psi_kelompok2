<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\Indent;

class StatusController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Hanya ambil data milik user yang login
        $pendaftaran = Pendaftaran::where('user_id', $user->id)
            ->with(['berkas', 'alasanPenolakan'])
            ->latest()
            ->get();

        $indents = Indent::where('user_id', $user->id)
            ->with(['berkas_indent', 'alasanPenolakan'])
            ->latest()
            ->get();

        return view('status.status', compact('pendaftaran', 'indents'));
    }
}
