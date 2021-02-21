@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

  <div class="page-header">

      <h1>
          Editar Cliente

      </h1>
  </div><!-- /.page-header -->
@if ($id_tipoident == 31)
  <div class="modal-body">
    <form>
      @csrf
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      <input type="hidden" id="identificacion_cli" value="{{$Identificacion}}">
        @foreach ($Cliente as $key => $cli)
          @include('cliente.form-empresa_edit')
        @endforeach
    </form>
  </div>
  <div class="center">
    <button type="button" id="guardar_cli_empresa" class="btn btn-primary">Guardar</button>
  </div>

    <span class="alert alert-success" role="alert" id="msj-error1" style="display:none">
        <strong id="msj1"></strong>
    </span>

  @else
    <div class="modal-body">
      <form>
        @csrf
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
        <input type="hidden" id="identificacion_cli" value="{{$Identificacion}}">
          @foreach ($Cliente as $key => $cli)
            @include('cliente.form_edit')
          @endforeach

      </form>

    </div>
    <div class="center">
      <span class="alert alert-success" role="alert" id="msj-error1" style="display:none">
          <strong id="msj1"></strong>
      </span>
      <button type="button" id="actualizar_cli" class="btn btn-primary">Guardar</button>
    </div>
@endif

@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/cliente/script.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/validarciudad.js')}}"></script>
@endsection
