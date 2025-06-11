<?php

namespace App\Exports;

use App\Retencionesaplicadas_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelReteaplicadaExport implements FromCollection,WithHeadings
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
            'Fecha Factura',
            'Número Factura',
            'Número Escritura',
            'Identificación',
            'Nombre',
            'ICA',
            'RETEFTE',
            'IVA',
            'Derechos',
            'Conceptos',
            'Radicación',
        ];
    }
    
    public function collection()
    {

        $fecha1 = $this->fecha1;
        $fecha2 = $this->fecha2;       
               

         $Informe = Retencionesaplicadas_view::select([
            'fecha_fact', 'id_fact', 'num_esc', 'identificacion', 'nombre',
            'ica', 'retefte', 'reteiva', 'total_derechos', 'total_conceptos', 'id_radica'
        	])->whereDate('fecha_fact', '>=', $fecha1)
        		->whereDate('fecha_fact', '<=', $fecha2)        
        		->orderBy('id_fact')        
        		->get();

        		// Formatear la fecha antes de convertir en colección para Excel
				$Informe = collect($Informe)->map(function ($item) {
    			$item->fecha_fact = \Carbon\Carbon::parse($item->fecha_fact)->format('d/m/Y');
    			return $item;
				});

				return $Informe;
       

        $Informe = collect($Informe);
        
         return $Informe;

    }
}