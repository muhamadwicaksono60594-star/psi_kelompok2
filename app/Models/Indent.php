<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'asal_instansi',
        'jurusan',
        'nim_nis',
        'no_telepon',
        'alamat',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'berkas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alasanPenolakan()
    {
    return $this->hasOne(AlasanPenolakan::class, 'indent_id');
    }

    public function berkas_indent()
    {
        return $this->hasMany(BerkasIndent::class, 'indent_id');
    }

}
