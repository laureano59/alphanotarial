<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelIngresosExcedentes implements FromCollection, WithHeadings
{
    private $fecha1;
    private $fecha2;

    public function __construct($fecha1, $fecha2)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
    }

    public function collection()
    {
        if (empty($this->fecha1) || empty($this->fecha2)) {
            return collect([]);
        }

        return DB::table('facturas as f')
            ->leftJoin('escrituras as e', function ($join) {
                $join->on('e.id_radica', '=', 'f.id_radica')
                     ->on('e.anio_radica', '=', 'f.anio_radica');
            })
            ->select(
                'f.id_fact',
                'f.id_radica',
                'f.anio_radica',
                'f.fecha_fact',
                'e.num_esc',
                'e.fecha_esc',
                'f.total_derechos',
                'f.total_conceptos',
                'f.total_iva',
                'f.total_rtf',
                'f.total_fondo',
                'f.total_super',
                'f.total_fact as total_fac'
            )
            ->whereDate('f.fecha_fact', '>=', $this->fecha1)
            ->whereDate('f.fecha_fact', '<=', $this->fecha2)
            ->where('f.nota_credito', '=', false)
            ->where('f.nota_periodo', '=', 0)
            ->orderBy('f.fecha_fact')
            ->get();
    }

    public function headings()
    {
        return [
            'No. Fac',
            'Radicado',
            'Año',
            'Fecha Fac',
            'No. Esc',
            'Fecha Esc',
            'Derechos',
            'Conceptos',
            'IVA',
            'RTF',
            'Fondo',
            'Super',
            'Total Fac.',
        ];
    }
}
