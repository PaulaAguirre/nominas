<?php

namespace App\Exports;

use App\NominaDirecta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NominaDirectaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $nominas= NominaDirecta::all()->where('mes', '=', 201909);
        return $nominas;
    }

    public function headings(): array
    {
        return
        [
            'id_nomina',
            'id_persona_directa'
        ];
    }
}
