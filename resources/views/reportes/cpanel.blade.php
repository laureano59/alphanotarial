@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
        Reportes<span id="radi">

    </h1>
</div><!-- /.page-header -->


<div class="row">
    <div class="col-xs-4">
        <div class="center">

<div id="accordion" class="accordion-style2">
  <div class="group">
    <h3 class="accordion-header">INFORMES ADMINISTRATIVOS</h3>

    <div>
      <table class="table table-striped table-bordered table-hover head">
        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="mensualcaja">
              Relación de Facturas Mensuales
          </a>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="estadisticonotarial">
              Estadístico Notarial
            </a>
          </td>
        </tr>

        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="relacionnotascreditomensual">
              Relación Notas Crédito Mensual
            </a>
          </td>
        </tr>

        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="">
              Relación Notas Débito Mensual
            </a>
          </td>
        </tr>

        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="ingresosporconceptomensual">
              Informe de Conceptos
            </a>
          </td>
        </tr>

        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="informerecaudos">
              Informe de Recaudos
            </a>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="group">
    <h3 class="accordion-header">INFORMES DE CAJA</h3>

    <div>
      <table class="table table-striped table-bordered table-hover head" width="100%">
        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="diariocaja">
              Relación de Facturas Diarias
          </a>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="relacionnotascreditodiario">
              Relación Nota Crédito Diario
          </a>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FFF2E0">
            <a href="javascript://" id="ingresosporconcepto">
              Relación de Facturas Diarias por Conceptos
            </a>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FFF2E0">
            <a href="javascript://" id="informerecaudosdiario">
              Relación de Facturas Diarias por Recaudos
            </a>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FFF2E0">
            <a href="javascript://" id="auxiliarcaja">
              Relación de Facturas Diarias Auxiliar
            </a>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="group">
    <h3 class="accordion-header">INFORMES DE ESCRITURACIÓN</h3>

    <div>
      <table class="table table-striped table-bordered table-hover head">
        <tr>
          <td bgcolor="#FFF2E0">
            <a href="javascript://" id="enlaces">
              Actos Jurídicos Notariales
            </a>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FFF2E0">
            <a href="javascript://" id="actos_notariales_escritura">
              Informe de Actos Notariales por Escritura 
            </a>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="libroindice">
            Libro Índice
          </a>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="libroalfabetico">
            Libro Alfabético Notarial
          </a>
          </td>
        </tr>

        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="ron">
            Reporte de Operaciones Notariales (RON)
          </a>
          </td>
        </tr>

      </table>
    </div>
  </div>

  <div class="group">
    <h3 class="accordion-header">INFORMES DE CARTERA</h3>

    <div>
      <table class="table table-striped table-bordered table-hover head">
        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="informecarteracliente">
              Relación Cartera por Cliente
          </a>
          </td>
        </tr>
        <tr>
          <td bgcolor="#FEFFE0">
            <a href="javascript://" id="informecarterames">
              Relación Cartera por Mes
          </a>
          </td>
        </tr>

      </table>
    </div>
  </div>
</div><!-- #accordion -->

</div>
</div>
</div>


@endsection

@section('scripts')
  <script src="{{ asset('js/reportes/script.js')}}"></script>
  <script src="{{ asset('js/calendario.js')}}"></script>
  <script src="{{ asset('js/__AJAX.js')}}"></script>
@endsection
