@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

  <div class="page-header">

      <h1>
          Actualización de Información<span id="radi">

      </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">

      <br>
    <div class="center">
      <a href="javascript://" id="liberaradicacion" class="btn btn-app btn-pink">
        <i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
        Liberar<br>Radicación
      </a>

      <a href="javascript://" id="editarclientes" class="btn btn-app btn-success">
        <i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
        Editar<br>Clientes
      </a>

      <a href="javascript://" id="editar_a_cargo_de" class="btn btn-app btn-primary">
        <i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
        Editar<br>Factura
      </a>

    </div>

    </div>
  </div>
<br>
  <div class="widget-box" id="guyliberaradicacion" style="display:none">
    <form>
      @csrf
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      <div class="widget-header">
        <h4 class="widget-title">Escribe el No. de Radicación que desea liberar</h4>
          <span class="nav-search widget-toolbar">
            <input type="text" id="radicacion" name="radicacion" placeholder="Escribir No.Radicación" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
            <a href="#" id="liberarad" data-action="reload">
                <i><img src="{{ asset('images/comprobar.png') }}" width="28 px" height="28 px" title="Liberar Radicación"></i>
            </a>
          </span>
      </div>
    </form>

      <div class="widget-body">
          <div class="widget-main">
              <div>
                  <div class="form-horizontal">
                      <div class="form-group">
                        <div class="alert alert-warning" role="alert" id="msj-error1" style="display:none">
                          <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                          <strong id="msj1"></strong>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="alert alert-success" role="alert" id="msj-error2" style="display:none">
                          <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                          <strong id="msj2"></strong>
                        </div>
                      </div>

                  </div>
                  <div class="space-10"></div>
              </div>
          </div>
      </div>
  </div>

  <div class="widget-box" id="guyeditarcliente" style="display:none">
    <form>
      @csrf
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      <div class="widget-header">
        <h4 class="widget-title">Escribe el No. de Identificación del Cliente</h4>
          <span class="nav-search widget-toolbar">
            <input type="text" id="identificacion_cli" placeholder="Escribir No. de Identificación" class="nav-search-input"  autocomplete="off" />
            <a href="#" id="editarclientebtn" data-action="reload">
                <i><img src="{{ asset('images/comprobar.png') }}" width="28 px" height="28 px" title="Editar Cliente"></i>
            </a>
          </span>
      </div>
    </form>

      <div class="widget-body">
          <div class="widget-main">
              <div>
                  <div class="form-horizontal">
                      <div class="form-group">
                        <div class="alert alert-warning" role="alert" id="msj-error1" style="display:none">
                          <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                          <strong id="msj1"></strong>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="alert alert-success" role="alert" id="msj-error2" style="display:none">
                          <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                          <strong id="msj2"></strong>
                        </div>
                      </div>

                  </div>
                  <div class="space-10"></div>
              </div>
          </div>
      </div>
  </div>


  <div class="widget-box" id="guyeditaracargode" style="display:none">
    <form>
      @csrf
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      <div class="widget-header">
        <h4 class="widget-title">Escribe el No. de Factura</h4>
          <span class="nav-search widget-toolbar">
            <input type="text" id="prefijo" placeholder="Escribir prefijo" class="nav-search-input"  autocomplete="off" />
            <input type="text" id="num_fact" placeholder="Escribir número de factura" class="nav-search-input"  autocomplete="off" onKeyPress="return soloNumeros(event)" />
            <a href="#" id="editaracargode" data-action="reload">
                <i><img src="{{ asset('images/comprobar.png') }}" width="28 px" height="28 px" title="Editar a cargo de"></i>
            </a>
          </span>
      </div>
    </form>

      <div class="widget-body">
          <div class="widget-main">
              <div>
                  <div class="form-horizontal">
                      <div class="form-group">
                        <div class="alert alert-warning" role="alert" id="msj-error7" style="display:none">
                          <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                          <strong id="msj7"></strong>
                        </div>
                      </div>
                  </div>
                  <div class="space-10"></div>
              </div>
          </div>
      </div>
  </div>
@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/mantenimiento/script.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
@endsection
