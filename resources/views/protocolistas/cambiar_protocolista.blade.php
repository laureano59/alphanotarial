@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control Configuraciones')
@section('content')

  <div class="page-header">
      <h1>
          Cambiar protocolista a la radicación
      </h1>
  </div><!-- /.page-header -->


  <div class="row">
        <div class="col-xs-12 col-sm-6">
          <div class="alert alert-success" role="alert" id="msj-error" style="display:none">
            <strong id="msj"></strong>
          </div>
          <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Radicación</h4>
        <div class="widget-toolbar">
            <a href="#" data-action="reload" id="guardar">
                <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar Cambios"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-main">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"><b class="green">Año</b></label>
                    <div class="col-sm-9">
                        <input type="text" class="red" size="7" id="anio_radica" placeholder="Año" maxlength="4" onKeyPress="return soloNumeros(event)"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"><b class="green">No.Radicación</b></label>
                    <div class="col-sm-9">
                        <input type="text" class="red"  size="10" id="id_radica" placeholder="No.Radicación" onKeyPress="return soloNumeros(event)"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="blue">Protocolista</b> </label>

                    <div class="col-sm-9">
                        <select class="form-control" id="id_proto"  style="width: 250px;">
                            <option value="" disabled selected>Elija Protocolista</option>
                            @foreach ($Protocolistas as $Protocolista)
                            <option value="{{$Protocolista->id_proto}}">{{$Protocolista->nombre_proto}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="space-10"></div>

        </div>
    </div>
</div>

          </form>
        </div><!-- /.span -->
  

@endsection

@section('scripts')
<script src="{{ asset('js/protocolistas/script.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/solonumeros.js')}}"></script>
@endsection
