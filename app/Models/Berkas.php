<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    protected $table = 'berkas';

    protected $fillable = ['pendaftar_id', 'indent_id', 'nama_file', 'path', 'jenis'];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftar_id');
    }

    public function indent()
    {
    return $this->belongsTo(Indent::class, 'indent_id');
    }

}
