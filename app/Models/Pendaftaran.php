<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftarans'; 

    protected $fillable = [
        'user_id','lowongan_id',
        'nama', 'asal_instansi', 'jurusan', 'nim_nis',
        'no_telepon', 'alamat', 'tanggal_mulai',
        'tanggal_selesai', 'status',
    ];

    public function berkas()
    {
        return $this->hasMany(Berkas::class, 'pendaftar_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan');
    }
    
    public function getDurasiMagangAttribute()
    {
        if ($this->lowongan) {
            return "{$this->lowongan->tanggal_mulai} s/d {$this->lowongan->tanggal_selesai}";
        }

        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            return "{$this->tanggal_mulai} s/d {$this->tanggal_selesai}";
        }

        return '-';
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
