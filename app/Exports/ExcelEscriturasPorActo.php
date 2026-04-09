<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelEscriturasPorActo
{
    protected $fecha1;
    protected $fecha2;
    protected $actos;

    public function __construct($fecha1, $fecha2, $actos)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->actos = $actos;
    }

    private function parseDate($dateStr)
    {
        $d = str_replace('/', '-', (string)$dateStr);
        $arr = explode('-', $d);
        if (count($arr) == 3) {
            // Si el segundo elemento es mayor a 12, es mm/dd/yyyy
            if ((int)$arr[1] > 12) {
                return $arr[2].'-'.$arr[0].'-'.$arr[1];
            }
            // Por defecto dd-mm-yyyy => Y-m-d
            return $arr[2].'-'.$arr[1].'-'.$arr[0];
        }
        return date('Y-m-d', strtotime($d));
    }

    private function getDataRows()
    {
        $f1 = $this->parseDate($this->fecha1);
        $f2 = $this->parseDate($this->fecha2);

        if (empty($this->actos) || in_array('TODOS', (array)$this->actos)) {
            $actos_list = DB::table('actos')->pluck('id_acto')->toArray();
        } else {
            $actos_list = is_array($this->actos) ? $this->actos : explode(',', (string)$this->actos);
        }

        if (empty($actos_list)) $actos_list = array(-1);
        $actos_formatted = implode(",", array_map('intval', $actos_list));

        $sql = "
          SELECT DISTINCT ON (apr.id_radica, apr.anio_radica, a.id_acto)
              e.num_esc AS escritura,
              e.fecha_esc::text AS fecha,
              apr.id_radica AS radicacion,
              apr.anio_radica AS anio,
              f.id_fact AS factura,
              f.total_fact AS valor,
              a.id_acto AS id_acto,
              a.nombre_acto AS acto,
              TRIM(COALESCE(cli1.pmer_nombrecli,'') || ' ' || COALESCE(cli1.sgndo_nombrecli,'') || ' ' || COALESCE(cli1.pmer_apellidocli,'') || ' ' || COALESCE(cli1.sgndo_apellidocli,'')) AS otorgante,
              TRIM(COALESCE(cli2.pmer_nombrecli,'') || ' ' || COALESCE(cli2.sgndo_nombrecli,'') || ' ' || COALESCE(cli2.pmer_apellidocli,'') || ' ' || COALESCE(cli2.sgndo_apellidocli,'')) AS compareciente
          FROM actos_persona_radica apr
          INNER JOIN actos a ON apr.id_acto = a.id_acto
          LEFT JOIN escrituras e ON e.id_radica::text = apr.id_radica::text AND e.anio_radica = apr.anio_radica
          LEFT JOIN facturas f ON f.id_radica::text = apr.id_radica::text AND f.anio_radica = apr.anio_radica AND f.nota_credito = false
          LEFT JOIN clientes cli1 ON cli1.identificacion_cli = apr.identificacion_cli
          LEFT JOIN clientes cli2 ON cli2.identificacion_cli = apr.identificacion_cli2
          WHERE
              apr.id_acto IN ($actos_formatted)
              AND e.num_esc IS NOT NULL
              AND e.fecha_esc::date BETWEEN ? AND ?
          ORDER BY apr.id_radica, apr.anio_radica, a.id_acto, e.num_esc ASC NULLS LAST;
        ";

        $results = DB::select($sql, array($f1, $f2));
        
        $rows = array();
        // Convertir a array para Excel
        foreach ($results as $r) {
            $rows[] = (array)$r;
        }
        
        return $rows;
    }

    public function exportExcel()
    {
        $filename = 'EscriturasPorActo_' . date('Ymd_His');
        
        return Excel::create($filename, function($excel) {
            $excel->sheet('Escrituras', function($sheet) {
                $data = $this->getDataRows();
                $sheet->fromArray($data);
                $sheet->row(1, function($row) {
                    $row->setFontWeight('bold');
                });
            });
        })->download('xls');
    }
}
