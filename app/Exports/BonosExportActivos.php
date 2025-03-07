<?php

namespace App\Exports;

use\App\Informe2_bonos_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class BonosExportActivos implements FromCollection,WithHeadings
{
    
    public function __construct($identificacion_cli, $opcionreporte) 
    {        
        $this->opcionreporte = $opcionreporte;
        $this->identificacion_cli = $identificacion_cli;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Codigo_bono',
            'Factura',
            'Fecha_Factura',
            'Escritura',
            'Identificacion',
            'Cliente',
            'Valor_Bono',
            'Saldo',
        ];        
    }

    public function collection()
    {

        $opcionreporte = $this->opcionreporte;
        $identificacion_cli = $this->identificacion_cli;
  
        if($opcionreporte == 'maycero'){
             $informecarterabonos = Informe2_bonos_view::select([
            'codigo_bono', 'id_fact', 'fecha_fact', 'num_esc', 'identificacion_cli', 'cliente', 'valor_bono', 'saldo'
        ])->where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->where('saldo', '>=', 1)
        ->orderBy('id_fact')
        ->orderBy('fecha_abono')
        ->get();
       
        }elseif($opcionreporte == 'completo'){
             $informecarterabonos = Informe2_bonos_view::select([
            'codigo_bono', 'id_fact', 'fecha_fact', 'num_esc', 'identificacion_cli', 'cliente', 'valor_bono', 'saldo'
        ])->where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->orderBy('id_fact')
        ->orderBy('fecha_abono')
        ->get();
        
        }
               
        return $informecarterabonos;

    }
}