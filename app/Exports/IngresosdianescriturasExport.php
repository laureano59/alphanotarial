<?php

namespace App\Exports;

use\App\Ingresos_dian_escrituras_view;
use\App\Ingresos_dian_cajarapida_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class IngresosdianescriturasExport implements FromCollection,WithHeadings
{
    private $fecha1;
    private $fecha2;

    public function __construct($fecha1, $fecha2, $ingreso, $opcionreporte) 
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->ingreso = $ingreso;
        $this->opcionreporte = $opcionreporte;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'tipo_doc',
            'identificacion',
            'pmer_apellido',
            'sgdo_apellido',
            'pmer_nombre',
            'sgdo_nombre',
            'sociedad',
            'ingresos',

        ];
    }
    public function collection()
    {

        $fecha1 = $this->fecha1;
        $fecha2 = $this->fecha2;
        $ingreso = $this->ingreso;
        $opcionreporte = $this->opcionreporte;

        if($opcionreporte == 'escrituras'){
            $reporte = Ingresos_dian_escrituras_view::whereDate('fecha_fact', '>=', $fecha1)
               ->whereDate('fecha_fact', '<=', $fecha2)
               ->where('nota_credito', false)
               ->selectRaw('tipo_doc, identificacion, pmer_apellido, sgdo_apellido, 
               pmer_nombre, sgdo_nombre, sociedad,
               SUM(ingresos) AS ingresos_totales')
               ->groupBy([
               'tipo_doc',
               'identificacion',
               'pmer_apellido',
               'sgdo_apellido',
               'pmer_nombre',
               'sgdo_nombre',
               'sociedad'
               ])
               ->havingRaw('SUM(ingresos) > ?', [$ingreso])
               ->get();
        }elseif($opcionreporte == 'cajarapida'){
            $reporte = Ingresos_dian_cajarapida_view::whereDate('fecha_fact', '>=', $fecha1)
               ->whereDate('fecha_fact', '<=', $fecha2)
               ->where('nota_credito', false)
               ->selectRaw('tipo_doc, identificacion, pmer_apellido, sgdo_apellido, 
               pmer_nombre, sgdo_nombre, sociedad,
               SUM(ingresos) AS ingresos_totales')
               ->groupBy([
               'tipo_doc',
               'identificacion',
               'pmer_apellido',
               'sgdo_apellido',
               'pmer_nombre',
               'sgdo_nombre',
               'sociedad'
               ])
               ->havingRaw('SUM(ingresos) > ?', [$ingreso])
               ->get();
        }
               
        return $reporte;

    }
}