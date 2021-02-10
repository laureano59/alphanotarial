<?php

namespace App\Exports;

use App\Ron_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RonExport implements FromCollection,WithHeadings
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
            'Número Escritura',
            'Fecha Escritura',
            'Valor Escritura',
            'Clase Trámite',
            'Tipo Identificación',
            'Nro. Identificación',
            '1er. Apellido',
            '2do. Apellido',
            '1er. Nombre',
            'Otros Nombres',
            'Razón Social',
            'Teléfono',
            'Dirección',
            'Actividad Económica',
            'Código Departamento/Municipio',
            'Calidad',

        ];
    }
    public function collection()
    {

        $fecha1 = $this->fecha1;
        $fecha2 = $this->fecha2;
               
        $anio_trabajo = date("Y", strtotime($fecha1)); //Convierte Fecha a YYYY*/
       
        $ron = Ron_view::whereDate('fecha_esc', '>=', $fecha1)
        ->whereDate('fecha_esc', '<=', $fecha2)
        ->where('anio_esc', '=', $anio_trabajo)
        ->select("num_esc", "fecha_esc", "cuantia", "id_ron", "id_tipoident", "identificacion", "primerpellido", "segundoapellido", "primernombre", "otrosnombres", "razonsocial", "telefono_cli", "direccion_cli", "actividadeconomica", "id_ciud", "cod_calidad1")
        ->get()
        ->toArray();
       
        $i = 1;
        $j = 0;
        foreach ($ron as $key) {
            $ron[$j]['Consecutivo'] = $i;
            $i++;
            $j++;
        }


        $ron = collect($ron);
        
         return $ron;

    }
}