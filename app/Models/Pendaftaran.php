<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftarans'; 

    protected $fillable = [
        'user_id',
        'nama', 'asal_instansi', 'jurusan', 'nim_nis',
        'no_telepon', 'alamat', 'status',
    ];

    public function berkas()
    {
        return $this->hasMany(Berkas::class, 'pendaftar_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function alasanPenolakan()
    {
    return $this->hasOne(AlasanPenolakan::class, 'pendaftar_id');
    }


}
