<?php

namespace App\Exports;

use\App\Enajenaciones_principales_view;
use\App\Enajenaciones_secundarios_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class EnajenacionesExport implements FromCollection,WithHeadings
{
    private $fecha1;
    private $fecha2;

    public function __construct($fecha1, $fecha2, $opcionreporte) 
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->opcionreporte = $opcionreporte;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        $opcionreporte = $this->opcionreporte;

         if($opcionreporte == 'enajenacionesprincipales'){
            return [
            'COD DIAN',
            'TIPO DOC VENDEDOR',
            'IDENTIFICACION VENDEDOR',
            'pmer_apellido_vend',
            'sgdo_apellido_vend',
            'pmer_nombre_vend',
            'sgdo_nombre_vend',
            'sociedad_vend',
            'Participacion_vend',
            '#Escritura',
            'Anio Escritura',
            'Tradicion',
            'Cuantia',
            'Valor Retencion',
            'TIPO DOC COMPRADOR',
            'IDENTIFICACION COMPRADOR',
            'pmer_apellido_comp',
            'sgdo_apellido_comp',
            'pmer_nombre_comp',
            'sgdo_nombre_comp',
            'sociedad_comp',
            'Participacion_comp',
        ];

         }elseif($opcionreporte == 'enajenacionesvendedoressecundarios'){
             return [
                '#Escritura',
                'IDENTIFICACION VENDEDOR PCPAL',
                'IDENTIFICACION COMPRADOR PCPAL',
                'TIPO DOC VENDEDOR SECUNDARIO',
                'Identificacion Vendedor Secundario',
                'pmer_apellido_vend',
                'sgdo_apellido_vend',
                'pmer_nombre_vend',
                'sgdo_nombre_vend',
                'sociedad_vend',
                'Participacion_vend',
        ];

         }elseif($opcionreporte == 'enajenacionescompradoressecundarios'){
             return [
                '#Escritura',
                'IDENTIFICACION VENDEDOR PCPAL',
                'IDENTIFICACION COMPRADOR PCPAL',
                'TIPO DOC COMPRADOR SECUNDARIO',
                'Identificacion Comprador Secundario',
                'pmer_apellido_comp',
                'sgdo_apellido_comp',
                'pmer_nombre_comp',
                'sgdo_nombre_comp',
                'sociedad_comp',
                'Participacion_comp',
        ];
        
        }
    }

    public function collection()
    {

        $fecha1 = $this->fecha1;
        $fecha2 = $this->fecha2;
        $opcionreporte = $this->opcionreporte;
  
        if($opcionreporte == 'enajenacionesprincipales'){
            $reporte = Enajenaciones_principales_view::select([
            'cod_dian', 'tipo_doc_vendedor', 'identificacion_vendedor',  
            'pmerapellido_vendedor', 'sgdoapellido_vendedor', 
            'pmernombre_vendedor', 'sgdonombre_vendedor', 
            'empresa_vendedor', 'porcentajeparticipacion_vendedor', 'escritura',
            'anio_esc', 'tradicion', 'cuantia', 'retefuente', 
            'tipo_doc_comprador', 'identificacion_comprador', 
            'pmerapellido_comprador', 'sgdoapellido_comprador', 'pmernombre_comprador', 
            'sgdonombre_comprador', 'empresa_comprador', 'porcentajeparticipacion_comprador'
        ])->whereDate('fecha_esc', '>=', $fecha1)
            ->whereDate('fecha_esc', '<=', $fecha2)
            ->get();
        }elseif($opcionreporte == 'enajenacionesvendedoressecundarios'){
            $reporte = Enajenaciones_secundarios_view::select([
                'escritura', 'identificacion_vendedor_principal', 
                'identificacion_comprador_principal',
                'tipo_doc_vendedor', 'identificacion_vendedor_secundario',   
                'pmerapellido_vendedor', 'sgdoapellido_vendedor', 
                'pmernombre_vendedor', 'sgdonombre_vendedor', 
                'empresa_vendedor', 'porcentajeparticipacion_vendedor'
        ])->whereDate('fecha_esc', '>=', $fecha1)
            ->whereDate('fecha_esc', '<=', $fecha2)
            ->get();
        }elseif($opcionreporte == 'enajenacionescompradoressecundarios'){
            $reporte = Enajenaciones_secundarios_view::select([
                'escritura', 'identificacion_vendedor_principal', 
                'identificacion_comprador_principal',
                'tipo_doc_comprador', 'identificacion_comprador_secundario',   
                'pmerapellido_comprador', 'sgdoapellido_comprador', 
                'pmernombre_comprador', 'sgdonombre_comprador', 
                'empresa_comprador', 'porcentajeparticipacion_comprador'
        ])->whereDate('fecha_esc', '>=', $fecha1)
            ->whereDate('fecha_esc', '<=', $fecha2)
            ->get();
        }
               
        return $reporte;

    }
}