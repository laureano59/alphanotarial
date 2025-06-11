<?php

namespace App\Exports;

use App\Relacion_nota_credito_print_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NotasCreditoExport implements FromCollection,WithHeadings
{
    private $fecha1;
    private $fecha2;

    public function __construct($fecha1, $fecha2) 
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Número Nota',
            'Número Factura',
            'Fecha Factura',
            'Fecha Nota C',
            'Número Escritura',
            'Derechos',
            'Conceptos',
            'Ingresos',
            'IVA',
            'Recaudos',
            'Ap Especial',
            'Imp Timbre',
            'Retención',
            'Reteiva',
            'Reteica',
            'Retefuente',
            'Total',
        ];
    }
    
    public function collection()
    {

        $fecha1 = $this->fecha1;
        $fecha2 = $this->fecha2;
        $anio_trabajo = date("Y", strtotime($fecha1));     
               

         $rel_notas_credito = Relacion_nota_credito_print_view::select([
            'id_ncf', 'numfact', 'fecha', 'fecha_nc', 'num_esc', 'derechos', 'conceptos',
            'total_gravado', 'iva', 'recaudo', 'aporteespecial', 'impuesto_timbre', 
            'retencion', 'reteiva', 'reteica', 'retertf',
             \DB::raw('(total_gravado + iva + recaudo + aporteespecial + impuesto_timbre + retencion - reteiva - reteica - retertf) as grantotal')
        ])  ->whereDate('fecha_nc', '>=', $fecha1)
            ->whereDate('fecha_nc', '<=', $fecha2)        
            ->where('anio_esc', '=', $anio_trabajo)
            ->where('nota_credito', true)
            ->orderBy('id_ncf')
            ->get();

            // ✅ Formatear fechas antes de pasar a Excel
            $rel_notas_credito = $rel_notas_credito->map(function ($item) {
                $item->fecha = \Carbon\Carbon::parse($item->fecha)->format('d/m/Y');
                $item->fecha_nc = \Carbon\Carbon::parse($item->fecha_nc)->format('d/m/Y');
                return $item;
            });

            return $rel_notas_credito;

    }
}