<?php

namespace App\Exports;

use Illuminate\Support\Facades\Response;

class ExcelActasIdentificacion
{
    private $fecha1;
    private $fecha2;
    private $identificacion;
    private $estado_acta;

    public function __construct($fecha1, $fecha2, $identificacion = '', $estado_acta = '')
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->identificacion = $identificacion;
        $this->estado_acta = $estado_acta;
    }

    public function export()
    {
        $query = \App\Actas_deposito_view::leftJoin('escrituras', function($join) {
                $join->on('actas_deposito_view.id_radica', '=', 'escrituras.id_radica')
                     ->on('actas_deposito_view.anio_radica', '=', 'escrituras.anio_radica');
            })
            ->leftJoin('facturas as f', function($join) {
                $join->on('f.id_radica', '=', 'actas_deposito_view.id_radica')
                     ->on('f.anio_radica', '=', 'actas_deposito_view.anio_radica')
                     ->where('f.nota_credito', '=', false);
            });

        $query->whereDate('actas_deposito_view.fecha', '>=', $this->fecha1)
              ->whereDate('actas_deposito_view.fecha', '<=', $this->fecha2)
              ->select('actas_deposito_view.*', 'escrituras.num_esc', 'f.id_fact')
              ->limit(5000);

        if (!empty($this->identificacion)) {
            $query->where('actas_deposito_view.identificacion_cli', $this->identificacion);
        }

        $estadoNorm = is_string($this->estado_acta) ? strtolower(trim($this->estado_acta)) : '';
        if ($estadoNorm !== '') {
            if ($estadoNorm === 'con_saldo') {
                $query->where('actas_deposito_view.saldo', '>', 1);
            } elseif ($estadoNorm === 'anuladas') {
                $query->where(function($q) {
                    $q->where('actas_deposito_view.anulada', true)
                      ->orWhere('actas_deposito_view.anulada', '1')
                      ->orWhere('actas_deposito_view.anulada', 1)
                      ->orWhere('actas_deposito_view.anulada', 't');
                });
            } elseif ($estadoNorm === 'credito') {
                $query->where(function($q) {
                    $q->where('actas_deposito_view.credito_act', true)
                      ->orWhere('actas_deposito_view.credito_act', 1)
                      ->orWhere('actas_deposito_view.credito_act', '1')
                      ->orWhere('actas_deposito_view.credito_act', 't');
                });
            }
        }

        $informe = $query->orderBy('actas_deposito_view.id_act')->get();

        $filename = 'ActasIdentificacion_'.$this->fecha1.'_'.$this->fecha2.'.xls';

        // Crear archivo XLS usando PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Actas');

        // Encabezados
        $headers = [
            'No. Acta', 'Fecha', 'Radicación', 'Año', 'Identificación', 'Cliente',
            'Boleta', 'Registro', 'Escritura', 'Escritura No.', 'Estado Crédito',
            'Depósito Acta', 'Depósito Boleta', 'Depósito Registro', 'Depósito Escritura',
            'Saldo', 'Factura', 'Observaciones'
        ];

        foreach ($headers as $col => $header) {
            $sheet->setCellValueByColumnAndRow($col + 1, 1, $header);
        }

        // Datos
        $row = 2;
        foreach ($informe as $item) {
            $crediAct = ($item->credito_act == true || $item->credito_act == 1 || $item->credito_act === '1' || $item->credito_act === 't') ? 'Si' : 'No';
            $estado = ($item->anulada == true || $item->anulada == 1 || $item->anulada === '1' || $item->anulada === 't') ? 'Anulada' : 'Activa';

            $colData = [
                $item->id_act,
                isset($item->fecha) ? substr($item->fecha, 0, 10) : '',
                $item->id_radica,
                $item->anio_radica,
                $item->identificacion_cli,
                $item->nombre,
                $item->deposito_boleta,
                $item->deposito_registro,
                $item->deposito_escrituras,
                isset($item->num_esc) ? $item->num_esc : '',
                $crediAct,
                $item->deposito_act,
                $item->deposito_boleta,
                $item->deposito_registro,
                $item->deposito_escrituras,
                $item->saldo,
                isset($item->id_fact) ? $item->id_fact : '',
                isset($item->observaciones) ? $item->observaciones : ''
            ];

            foreach ($colData as $col => $value) {
                $sheet->setCellValueByColumnAndRow($col + 1, $row, $value);
            }
            $row++;
        }

        // Auto-ajustar ancho de columnas
        for ($col = 1; $col <= count($headers); $col++) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        // Crear escritor Excel5 (XLS)
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);

        // Guardar en memoria y retornar respuesta
        $filename_with_path = sys_get_temp_dir() . '/' . $filename;
        $writer->save($filename_with_path);

        return response()->download($filename_with_path, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ])->deleteFileAfterSend(true);
    }
}

