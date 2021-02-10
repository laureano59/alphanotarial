@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')
  <div class="row">
    <div class="col-sm-12 infobox-container">
      <div class="infobox infobox-blue">
        <div class="infobox-icon">
          <i class="ace-icon glyphicon glyphicon-file"></i>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number">{{$Id_radica}}</span>
          <div class="infobox-content">Radicaciones</div>
        </div>
      </div>

      <div class="infobox infobox-green">
        <div class="infobox-icon">
          <i class="ace-icon fa fa-twitter"></i>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number">{{$Id_fact}}</span>
          <div class="infobox-content">Facturas</div>
        </div>
      </div>

      <div class="infobox infobox-red">
        <div class="infobox-icon">
          <i class="ace-icon fa fa-flask"></i>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number">{{$Num_esc}}</span>
          <div class="infobox-content">Escrituras</div>
        </div>
      </div>

      <div class="infobox infobox-orange2">
        <div class="infobox-chart">
          <span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>
        </div>

        <div class="infobox-data">
          <span class="infobox-data-number">{{$AnioTrabajo->anio_trabajo}}</span>
          <div class="infobox-content">Año Fiscal</div>
        </div>
      </div>
      <div class="space-6"></div>
      </div>
    </div>
  </div>
@endsection
