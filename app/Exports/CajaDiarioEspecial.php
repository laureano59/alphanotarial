<?php

namespace App\Exports;

use App\Cajadiarioespecial_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class CajaDiarioEspecial implements FromCollection,WithHeadings
{
    private $fecha1;
    private $fecha2;

    public function __construct($fecha1, $fecha2, $tipoinforme) 
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->tipoinforme = $tipoinforme;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Número Factura',
            'Fecha',
            'Derechos',
            'Conceptos',
            'Ingresos',
            'Iva',
            'Recaudos',
            'Aporte_esp',
            'Impuesto_timbre',
            'Timbre ley 175',
            'Retención',
            'ReteIva',
            'ReteIca',
            'Retefuente',
            'Total',
            'Tipo pago',
            'Estado',
            'NC',

        ];
    }
    
    

    public function collection()
    {
        $fecha1 = $this->fecha1;
        $fecha2 = $this->fecha2;
        $tipo_informe = $this->tipoinforme;
       
        $query = Cajadiarioespecial_view::select([
            'numfact',
            'fecha',
            'derechos',
            'conceptos',
            DB::raw('(COALESCE(derechos,0) + COALESCE(conceptos,0)) as ingresos'),
            'iva',
            'recaudo',
            'aporteespecial',
            'impuesto_timbre',
            'timbreley175',
            'retencion',
            'reteiva',
            'reteica',
            'retertf',
            'total',
            'tipo_pago',
            'estado'
        ])
        ->whereDate('fecha', '>=', $fecha1)
        ->whereDate('fecha', '<=', $fecha2);

        if ($tipo_informe == 'contado') {
            $query->where('tipo_pago', 'Contado');

            if ($anio_trabajo) {
                $query->where('anio_esc', $anio_trabajo);
            }

        } elseif ($tipo_informe == 'credito') {
            $query->where('tipo_pago', 'Crédito');
        }

            return $query->get(); 
    }

}