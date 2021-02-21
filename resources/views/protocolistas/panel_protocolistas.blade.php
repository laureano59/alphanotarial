@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control Configuraciones')
@section('content')

  <div class="page-header">
      <h1>
          Protocolistas
      </h1>
  </div><!-- /.page-header -->
  <div class="row">
    <div class="col-xs-12">
      <br>
    <div class="center">
      <a href="javascript://" id="cambiar_protocolista" class="btn btn-app btn-pink">
        <i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
        Cambiar<br>Protocolista
      </a>
    </div>
    </div>
  </div>


@endsection

@section('scripts')
<script src="{{ asset('js/protocolistas/script.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
@endsection
