@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')
@include('caja_rapida.modalbase')

  <div class="page-header">

      <h1>
          Caja Rápida<span id="radi">

      </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">

      <br>

    <div class="center">
      <a href="javascript://" id="aperturacajarapida"  class="btn btn-app btn-pink">
        Apertura
      </a>
      <a href="javascript://" id="cajarapida"  class="btn btn-app btn-pink">
        <i class="ace-icon glyphicon glyphicon-qrcode bigger-230"></i>
        Facturar
      </a>

      <a href="/notacreditocajarapida" class="btn btn-app btn-warning">
        <i class="ace-icon fa fa-print bigger-160"></i>
        Nota CT
      </a>

      <!--<a href="javascript://" id="editarfacturacajarapida" class="btn btn-app btn-primary">
        <i class="ace-icon glyphicon glyphicon-pencil bigger-150"></i>
        Editar
      </a>-->
         

      <a href="javascript://" id="copiasfacturarapida" class="btn btn-app btn-light">
        <i class="ace-icon fa fa-print bigger-160"></i>
        Copias
      </a>

    </div>

    <div class="center">
       <a href="javascript://" id="informediariocajarapida" class="btn btn-app btn-success">
        <i class="ace-icon  glyphicon  glyphicon-th-large bigger-160"></i>
        R.Diario
      </a>

      <a href="javascript://" id="informeporconceptoscajarapida" class="btn btn-app btn-purple">
        <i class="ace-icon  glyphicon  glyphicon-th-large bigger-160"></i>
        R.Grupos
      </a>

       <a href="javascript://" id="statusfactelectronicacajarapida" class="btn btn-app btn-warning">
        <i class="ace-icon fa fa-print bigger-160"></i>
        Status
      </a>

      <a href="/carteracacajarapida" class="btn btn-app btn-danger">
        <i class="ace-icon fa fa-credit-card bigger-160"></i>
        Cartera
      </a>


       <a href="/consulta_cajarapida" class="btn btn-app btn btn-info">
        <i class="ace-icon fa fa-search bigger-160"></i>
        Consultar
      <a>
      
    </div>

    </div>
  </div>

   <div class="widget-body">
        <div class="widget-main">
            <div>
                <div class="form-horizontal">
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


<script src="{{ asset('assets/js/jquery-2.1.4.min.js')}}"></script>

@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/mantenimiento/script.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/caja_rapida/script.js')}}"></script>
<script src="{{ asset('js/reportes/script.js')}}"></script>
@endsection
