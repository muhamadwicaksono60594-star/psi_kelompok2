<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasIndent extends Model
{
    use HasFactory;

    protected $table = 'berkas_indent';

    protected $fillable = [
        'indent_id',
        'nama_file',
        'path',
    ];

    public function indent()
    {
        return $this->belongsTo(Indent::class);
    }
}
