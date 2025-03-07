<?php

namespace App\Exports;

use\App\Informe_cartera_bonos_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class BonosExportCli implements FromCollection,WithHeadings
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
            '#Abono',
            'Codigo_bono',
            'Factura',
            'Fecha_Factura',
            'Fecha_Abono',
            'Escritura',
            'Identificacion',
            'Cliente',
            'Saldo_General',
            'Valor_Abono',
            'Saldo',
            'Valor_Bono',
        ];        
    }

    public function collection()
    {

        $opcionreporte = $this->opcionreporte;
        $identificacion_cli = $this->identificacion_cli;
  
        if($opcionreporte == 'maycero'){
             $informecarterabonos = Informe_cartera_bonos_view::select([
            'id_abono', 'codigo_bono', 'id_fact', 'fecha_fact', 'fecha_abono', 'num_esc', 'identificacion_cli', 'cliente','saldogeneral', 'valor_abono', 'nuevo_saldo', 'valor_bon'
        ])->where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->where('saldo_bon', '>=', 1)
        ->orderBy('id_fact')
        ->orderBy('fecha_abono')
        ->get();
       
        }elseif($opcionreporte == 'completo'){
            $informecarterabonos = Informe_cartera_bonos_view::select([
            'id_abono', 'codigo_bono', 'id_fact', 'fecha_fact', 'fecha_abono', 'num_esc', 'identificacion_cli', 'cliente','saldogeneral', 'valor_abono', 'nuevo_saldo', 'valor_bon'
        ])->where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->orderBy('id_fact')
        ->orderBy('fecha_abono')
        ->get();
        
        }
               
        return $informecarterabonos;

    }
}