<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratBalasan extends Model
{
    use HasFactory;

    protected $table = 'surat_balasan';
    protected $fillable = [
        'pendaftar_id',
        'indent_id',
        'jenis',
        'status_surat',
        'file_path',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftar_id');
    }

    public function indent()
    {
        return $this->belongsTo(Indent::class, 'indent_id');
    }

    public function alasanPenolakan()
    {
    return $this->hasOne(AlasanPenolakan::class, 'pendaftar_id');
    }

}
