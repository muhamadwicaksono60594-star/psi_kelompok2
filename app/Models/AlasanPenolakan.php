<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlasanPenolakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftar_id',
        'indent_id',
        'alasan',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftar_id');
    }

    public function indent()
    {
        return $this->belongsTo(Indent::class, 'indent_id');
    }
}
