@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')
  <div class="alert alert-danger" role="alert" id="msj-error" style="display:none">
    <strong id="msj"></strong>
  </div>
  <div class="page-header">

      <h1>
          Seleccione el Tipo de Factura<span id="radi">
            @if (session('key'))

              @section('scripts2')
                <script>
                  window.onload = function() {
                  document.getElementById('radicacion').value = {{ session('key') }};
                  var id_radica = document.getElementById('radicacion').value;
                  //BuscarPorSession(id_radica);

                  }

              </script>
              @endsection
            @endif
          </span>

          <small>
              <span class="nav-search widget-toolbar ">
                  <form>
                      @csrf
                      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                      <input type="text" id="radicacion" name="radicacion" onKeyPress="return soloNumeros(event)" placeholder="Buscar Radicación" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
                      <a href="javascript://" id="buscar_fact">
                          <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar Radicación"></i>
                      </a>
                  </form>

              </span>
          </small>
      </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">

      <br><br><br>
    <div class="center">
      <a href="javascript://" id="factunica" class="btn btn-app btn-primary">
        <i class="ace-icon glyphicon glyphicon-file bigger-230"></i>
        Única
      </a>

      <!--<a href="javascript://" id="factdoble" class="btn btn-app btn-success">
        <i class="ace-icon fa  fa-exchange bigger-230"></i>
        Doble
      </a>-->

      <a href="javascript://" id="factmultiple" class="btn btn-app btn-warning">
        <i class="ace-icon glyphicon glyphicon-list-alt bigger-230"></i>
        Múltiple
      </a>

      <a href="/facturaelectronica"  class="btn btn-app btn-success">
        <i class="ace-icon glyphicon glyphicon-qrcode bigger-230"></i>
        Electrónica
      </a>

      <a href="javascript://" id="copiasfactura" class="btn btn-app btn-light">
        <i class="ace-icon fa fa-print bigger-160"></i>
        Copias
      </a>
      <br>
    
      <a href="/notascreditofact"  class="btn btn-app btn-pink btn-sm">
        <i class="ace-icon fa fa-print bigger-160"></i>
        Nota CT
      </a>

      <a href="/notasdebitofact"  class="btn btn-app btn-purple btn-sm">
        <i class="ace-icon fa fa-print bigger-160"></i>
        Nota DT
      </a>
    </div>
    </div>
  </div>
<br>
<div class="widget-box" id="guycopiafactura" style="display:none">
  <form>
    @csrf
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <div class="widget-header">
      <h4 class="widget-title">Escribe el No. de Factura que desea imprimir</h4>
        <span class="nav-search widget-toolbar">
          <input type="text" id="num_factura" placeholder="Escribir No. de factura" class="nav-search-input"  autocomplete="off" />
          <input type="text" size="5" id="anio_fiscal" placeholder="Año fiscal" class="nav-search-input"  autocomplete="off" onKeyPress="return soloNumeros(event)" />
          <a href="#" id="imprimircopiafactura">
              <i><img src="{{ asset('images/imprimir.png') }}" width="28 px" height="28 px" title="Imprimir Copia de Factura"></i>
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
                </div>
                <div class="space-10"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/facturacion/script.js')}}"></script>
@endsection
