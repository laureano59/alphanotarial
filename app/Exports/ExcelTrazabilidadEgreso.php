<?php

namespace App\Exports;

use App\Http\Controllers\ReportesController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ExcelTrazabilidadEgreso
{
    private $fecha1;
    private $fecha2;
    private $identificacion;
    private $tipoActa;

    public function __construct($fecha1, $fecha2, $identificacion = '', $tipoActa = 'todas')
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->identificacion = $identificacion;
        $this->tipoActa = $tipoActa;
    }

    public function export()
    {
        $ctrl = app(ReportesController::class);
        $rows = $ctrl->buildTrazabilidadEgresoQuery($this->fecha1, $this->fecha2, $this->identificacion, $this->tipoActa)->limit(5000)->get();
        $data = $ctrl->calcularDescuentosTrazabilidad($rows);

        $filename = 'TrazabilidadEgreso_'.$this->fecha1.'_'.$this->fecha2.'.xls';

        // Crear archivo XLS usando PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Trazabilidad');

        // Encabezados
        $headers = [
            'Acta', 'Fecha acta', 'Rad', 'Identificación', 'Cliente', 'Estado',
            'Valor acta', 'Boleta', 'Registro', 'Escritura', 'No. egreso', 'Fecha egreso',
            'Id con', 'Concepto egreso', 'Factura', 'Desc. acta', 'Desc. boleta',
            'Desc. registro', 'Desc. escritura', 'Valor egreso', 'Saldo', 'Observaciones'
        ];

        foreach ($headers as $col => $header) {
            $sheet->setCellValueByColumnAndRow($col + 1, 1, $header);
        }

        // Datos
        $row = 2;
        foreach ($data as $r) {
            $credito = ($r->credito_act == true || $r->credito_act == 1 || $r->credito_act === '1' || $r->credito_act === 't' || $r->credito_act === 'true') ? 'CREDITO' : 'NORMAL';

            try {
                $fechaActa = ! empty($r->fecha_acta) ? \Carbon\Carbon::createFromFormat('Y-m-d', substr($r->fecha_acta, 0, 10))->format('d/m/Y') : '';
            } catch (\Exception $e) {
                $fechaActa = '';
            }

            try {
                $fechaEgreso = ! empty($r->fecha_egreso) ? \Carbon\Carbon::createFromFormat('Y-m-d', substr($r->fecha_egreso, 0, 10))->format('d/m/Y') : '';
            } catch (\Exception $e) {
                $fechaEgreso = '';
            }

            $colData = [
                $r->id_act,
                $fechaActa,
                $r->id_radica,
                $r->identificacion_cli,
                $r->nombre,
                $credito,
                $r->deposito_act,
                $r->deposito_boleta,
                $r->deposito_registro,
                $r->deposito_escrituras,
                $r->id_egr,
                $fechaEgreso,
                $r->id_con,
                $r->concepto_egreso,
                $r->factura,
                $r->descuento_acta,
                $r->descuento_boleta,
                $r->descuento_registro,
                $r->descuento_escritura,
                $r->egreso_egr,
                $r->saldo_final,
                isset($r->observaciones_egr) ? $r->observaciones_egr : ''
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

