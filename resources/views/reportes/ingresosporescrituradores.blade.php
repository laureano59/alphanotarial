@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
         {{$nombre_reporte}}<span id="radi">
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-sm-12">
        <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <div class="control-group">
              <label class="control-label bolder blue">Seleccione Tipo de Informe</label>
              <div class="radio">
                <label>
                  <input name="seleccion" id="general" value="general" type="radio" class="ace input-lg" onchange="handleRadioButtonChange()" />
                  <span class="lbl bigger-120">Informe General</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="porescriturador" value="porescriturador" type="radio" class="ace input-lg" onchange="handleRadioButtonChange()"/>
                  <span class="lbl bigger-120">Informe agrupado por Escriturador</span>
                </label>
              </div>

               <div id="mostrarprotocolista" style="display:none">
                <span>
                    Seleccione un protocolista
                </span>
                <select class="form-control" id="id_proto" name="id_proto" style="width: 250px;">
                    <option value="" disabled selected>Elija Protocolista</option>
                        @foreach ($Protocolistas as $Protocolista)
                        <option value="{{$Protocolista->id_proto}}">{{$Protocolista->nombre_proto}}</option>
                            @endforeach
                        </select>
                </div>

              
            </div>

            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Ingresar Rango de Fecha</h4>
                    <span class="widget-toolbar">
                         <a href="#" data-action="settings" id="imprimiringresosporescrituradores">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Generar Reporte"></i>
                        </a>
                    </span>
                   
                    <span class="nav-search widget-toolbar">
                        <div class="input-daterange input-group">
                            <input type="text" class="input-sm form-control" name="start" id="start" />
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control" name="end" id="end" />
                        </div>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection

@section('csslau')
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker3.min.css')}}" />
@endsection

@section('scripts')
<script src="{{ asset('js/calendario.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.custom.min.js')}}"></script>
<script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
<script src="{{asset('assets/js/spinbox.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/js/autosize.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.inputlimiter.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.maskedinput.min.js')}}"></script>
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
@endsection
