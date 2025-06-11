<?php

namespace App\Exports;

use App\Relacion_nota_credito_caja_rapida_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NotasCreditoCajaRapidaExport implements FromCollection,WithHeadings
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
            'Identificación',
            'Cliente',
            'Subtotal',
            'Iva',
            'Total',
            'Facturador',
        ];
    }
    
    public function collection()
    {

        $fecha1 = $this->fecha1;
        $fecha2 = $this->fecha2;       
        

        $rel_notas_credito = Relacion_nota_credito_caja_rapida_view::select([
            'id_ncf', 'id_fact', 'prefijo', 'fecha_fact', 'a_nombre_de', 'cliente',
            'subtotal', 'total_iva', 'total_fact', 'name'
        ])
        ->whereDate('fecha_fact', '>=', $fecha1)
        ->whereDate('fecha_fact', '<=', $fecha2)
        ->where('nota_credito', '=', true)
        ->orderBy('id_ncf')
        ->get()
        ->map(function ($item) {
    // Concatenar prefijo + id_fact
            $item->id_fact = $item->prefijo . $item->id_fact;

    // Formatear fecha
            $item->fecha_fact = \Carbon\Carbon::parse($item->fecha_fact)->format('d/m/Y');

    // Si no quieres incluir 'prefijo' en el resultado final, puedes ocultarlo
            unset($item->prefijo);

            return $item;
        })
        ->toArray();   

        $rel_notas_credito = collect($rel_notas_credito);
        
        return $rel_notas_credito;

    }
}