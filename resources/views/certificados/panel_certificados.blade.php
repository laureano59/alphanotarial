@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

  <div class="page-header">

      <h1>
          Certificados<span id="radi">

      </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">

      <br>
    <div class="center">
      <a href="javascript://" id="certitimbre"  class="btn btn-app btn-pink">
        <i class="ace-icon glyphicon glyphicon-list-alt bigger-230"></i>
        Timbre
      </a>

      <a href="javascript://" id="certirtf" class="btn btn-app btn-warning">
        <i class="ace-icon glyphicon glyphicon-list-alt bigger-230"></i>
        Retefuente
      </a>

    </div>

    </div>
  </div>

  <div class="widget-box" id="guycertificadotimbre" style="display:none">
  <form>
    @csrf
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <div class="widget-header">
      <h4 class="widget-title">Escribe el No. de Factura al que desea imprimir el certificado de impuesto al timbre</h4>
        <span class="nav-search widget-toolbar">
          <input type="text" id="num_factura" placeholder="Escribir No. de factura" class="nav-search-input"  autocomplete="off" />
          <input type="text" size="5" id="anio_fiscal" placeholder="Año fiscal" class="nav-search-input"  autocomplete="off" onKeyPress="return soloNumeros(event)" />
          <a href="#" id="imprimircertificadotimbre">
              <i><img src="{{ asset('images/imprimir.png') }}" width="28 px" height="28 px" title="Imprimir certificado timbre"></i>
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


<div class="widget-box" id="guycertificadoretefuente" style="display:none">
  <form>
    @csrf
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <div class="widget-header">
      <h4 class="widget-title">Escribe el No. de Factura al que desea imprimir el certificado de retención en la fuente</h4>
        <span class="nav-search widget-toolbar">
          <input type="text" id="num_factura2" placeholder="Escribir No. de factura" class="nav-search-input"  autocomplete="off" />
          <input type="text" size="5" id="anio_fiscal2" placeholder="Año fiscal" class="nav-search-input"  autocomplete="off" onKeyPress="return soloNumeros(event)" />
          <a href="#" id="imprimircertificadoretefuente">
              <i><img src="{{ asset('images/imprimir.png') }}" width="28 px" height="28 px" title="Imprimir certificado de retención"></i>
          </a>
        </span>
    </div>
  </form>

  
    <div class="widget-body">
        <div class="widget-main">
            <div>
                <div class="form-horizontal">
                    <div class="form-group">
                      <div class="alert alert-warning" role="alert" id="msj-error2" style="display:none">
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
@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/certificados/script.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
@endsection
