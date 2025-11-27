<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftarExport implements FromCollection, WithHeadings
{
    protected $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return [
            'No', 'Nama', 'Asal Instansi', 'Jurusan', 'Jenis', 'Status', 'Tanggal Daftar', 'Tanggal Mulai', 'Tanggal Selesai'
        ];
    }
}
