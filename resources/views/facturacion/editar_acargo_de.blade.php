@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

  <h1>
    Actualizar a cargo de quién va la factura

  </h1>
</div><!-- /.page-header -->



<div class="alert alert-success" role="alert" id="msj-error1" style="display:none">
  <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
  <strong id="msj1"></strong>
</div>



<div class="row">
  <div class="col-xs-12">

    <table id="simple-table" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Prefijo</th>
          <th>No.Factura</th>
          <th>Fecha_fact</th>
          <th>Identificación</th>
          <th>Nombre</th>
          <th>Detalle</th>
          <th>
            $Total Factura
          </th>
        </tr>
      </thead>
      <tbody id="data_fact"></tbody>
      @foreach ($Factura as $fac)
      <tr>
        <td>{{$fac->prefijo}}</td>
        <td>{{$fac->id_fact}}</td>
        <td>{{ Carbon\Carbon::parse($fac->fecha_fact)->format('d/m/Y') }}</td>
        <td>{{$fac->identificacion}}</td>
        <td>{{$fac->nombre}}</td>
        <td>{{$fac->detalle}}</td>
        <td>{{ number_format($fac->total_fact, 2) }}</td>
      </tr>
      @endforeach
    </table>
    <span>Identificación:</span><br>
    <input type="text" id="identificacion" value="{{$Identificacion}}" placeholder="Identificación" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
    <br>
    <span>Detalle:</span><br>
    <textarea id="detalle" rows="5" cols="50">{{$Detalle}}</textarea>
    <br><br>
    <button type="button" id="actualizar_fact" class="btn btn-primary btn-block">Guardar</button>

  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/mantenimiento/script.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
@endsection
