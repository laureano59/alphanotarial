@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

  <div class="page-header">

      <h1>
          Actas de Depósito<span id="radi">

      </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">

      <br>
    <div class="center">
      <a href="/depositos"  class="btn btn-app btn-pink">
        <i class="ace-icon fa fa-cloud-download bigger-230"></i>
        Depósitos
      </a>

      <a href="/egresos" class="btn btn-app btn-warning">
        <i class="ace-icon glyphicon glyphicon-plus bigger-230"></i>
        Cruzar
      </a>

    </div>

    </div>
  </div>
@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/mantenimiento/script.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
@endsection
