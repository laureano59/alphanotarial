<?php

namespace App\Exports;

use\App\Informe_cartera_bonos_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class BonosExportFecha implements FromCollection,WithHeadings
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

        $fecha1 = $this->fecha1;
        $fecha2 = $this->fecha2;
        $opcionreporte = $this->opcionreporte;
          
        if($opcionreporte == 'maycero'){
             $informecarterabonos = Informe_cartera_bonos_view::select([
            'id_abono', 'codigo_bono', 'id_fact', 'fecha_fact', 'fecha_abono', 'num_esc', 'identificacion_cli', 'cliente','saldogeneral', 'valor_abono', 'nuevo_saldo', 'valor_bon'
        ])->whereDate('fecha_abono', '>=', $fecha1)
        ->whereDate('fecha_abono', '<=', $fecha2)
        ->where('nota_credito', false)
        ->where('saldo_bon', '>=', 1)
        ->orderBy('id_fact')
        ->orderBy('fecha_abono')
        ->get();
       
        }elseif($opcionreporte == 'completo'){
            $informecarterabonos = Informe_cartera_bonos_view::select([
            'id_abono', 'codigo_bono', 'id_fact', 'fecha_fact', 'fecha_abono', 'num_esc', 'identificacion_cli', 'cliente','saldogeneral', 'valor_abono', 'nuevo_saldo', 'valor_bon'
        ])->whereDate('fecha_abono', '>=', $fecha1)
       ->whereDate('fecha_abono', '<=', $fecha2)
       ->where('nota_credito', false)
       ->orderBy('id_fact')
       ->orderBy('fecha_abono')
       ->get();
        
        }
               
        return $informecarterabonos;

    }
}