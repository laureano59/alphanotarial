@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

  <div class="page-header">

      <h1>
          Caja Rápida<span id="radi">

      </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">

      <br>
    <div class="center">
      <a href="javascript://" id="cajarapida"  class="btn btn-app btn-pink">
        <i class="ace-icon glyphicon glyphicon-qrcode bigger-230"></i>
        Facturar
      </a>

      <a href="/notacreditocajarapida" class="btn btn-app btn-warning">
        <i class="ace-icon fa fa-print bigger-160"></i>
        Nota CT
      </a>

      <a href="javascript://" id="editarfacturacajarapida" class="btn btn-app btn-primary">
        <i class="ace-icon glyphicon glyphicon-pencil bigger-150"></i>
        Editar
      </a>

      <a href="javascript://" id="copiasfacturarapida" class="btn btn-app btn-light">
        <i class="ace-icon fa fa-print bigger-160"></i>
        Copias
      </a>

    </div>

    </div>
  </div>

  <div class="widget-box" id="guycopiafacturacajarapida" style="display:none">
  <form>
    @csrf
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <div class="widget-header">
      <h4 class="widget-title">Escribe el No. de Factura que desea imprimir</h4>
        <span class="nav-search widget-toolbar">
          <input type="text" id="num_factura" placeholder="Escribir No. de factura" class="nav-search-input"  autocomplete="off" />
          <a href="#" id="imprimircopiafacturacajarapida">
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
<script src="{{ asset('js/mantenimiento/script.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/caja_rapida/script.js')}}"></script>
@endsection
