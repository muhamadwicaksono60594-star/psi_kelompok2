<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InstansiExport implements FromCollection, WithHeadings
{
    protected $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
        
    }

    public function collection()
    {
        return $this->collection;
        $this->title = $title;
    }

    public function headings(): array
    {
        return [
            'No', 'Asal Instansi', 'Total Pendaftar', 'Diterima', 'Ditolak'
        ];
    }
}
