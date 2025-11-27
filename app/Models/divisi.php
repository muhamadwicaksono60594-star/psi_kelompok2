<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class divisi extends Model
{
    use HasFactory;

    protected $table = 'divisi'; // <- kasih tau Laravel nama tabelnya
    protected $fillable = ['nama_divisi'];
}
