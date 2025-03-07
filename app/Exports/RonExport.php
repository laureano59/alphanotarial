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
       
        $raw = \DB::raw("
        min(num_esc) AS num_esc,
        min(fecha_esc) AS fecha_esc,
        min(cuantia) AS cuantia,
        min(id_ron) AS id_ron,
        min(id_tipoident) AS id_tipoident,
        min(identificacion) AS identificacion,
        min(primerpellido) AS primerpellido,
        min(segundoapellido) AS segundoapellido,
        min(primernombre) AS primernombre,
        min(otrosnombres) AS otrosnombres,
        min(razonsocial) AS razonsocial,
        min(telefono_cli) AS telefono_cli,
        min(direccion_cli) AS direccion_cli,
        min(actividadeconomica) AS actividadeconomica,
        min(id_ciud) AS id_ciud,
        min(cod_calidad1) AS cod_calidad1");
        $ron = Ron_view::whereDate('fecha_esc', '>=', $fecha1)
        ->whereDate('fecha_esc', '<=', $fecha2)
        ->where('anio_esc', '=', $anio_trabajo)
        ->groupBy('num_esc', 'identificacion', 'id_ron', 'cod_calidad1') 
        ->select($raw)
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