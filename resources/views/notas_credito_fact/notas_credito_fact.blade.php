@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')
@include('notas_credito_fact.modalvistafactura')

  <div class="page-header">

      <h1>
          Notas Crédito de Facturas
            <small>
                <span class="nav-search widget-toolbar ">
                    Nota Crédito No.&nbsp; <b>
                        <font size="5"><span class="red" id="id_ncf"></span></font>
                    </b>
                </span>
            </small>

      </h1>
  </div><!-- /.page-header -->

  <div class="widget-box" >
    <form>
      @csrf
      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
      <div class="widget-header">
        <h4 class="widget-title">Escribe el No. de Factura para la Nota Crédito</h4>
        <span class="nav-search widget-toolbar">
          <a target="_blank" href="/copianotacreditopdf">
              <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Nota Crédito"></i>
          </a>
        </span>
          <span class="nav-search widget-toolbar">
            <input type="text" id="id_fact" placeholder="Escribir No.Factura" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
            
            
            <a href="#" id="mostrarfactura" data-action="reload">
                <i><img src="{{ asset('images/comprobar.png') }}" width="28 px" height="28 px" title="Crear nota Credito Factura"></i>
            </a>
          </span>


          <span class="nav-search widget-toolbar">
          <a href="#">
              <i><img src="{{ asset('images/ayuda1.png') }}" width="28px" height="28px" title="Para imprimir una copia ingresa el número de la factura, escribe copia en detalle, click en el ícono de visto bueno verde y  click en el ícono de la impresora"></i>
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
                        <div class="alert alert-success" role="alert" id="msj-error" style="display:none">
                          <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                          <strong id="msj"></strong>
                        </div>
                      </div>
                      <div>
                        <label class="pink"><b>Detalle la razón de la nota crédito</b></label>
                      <textarea class="form-control" id="detalle_ncf" maxlength="250" placeholder="Default Text"></textarea>
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
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/notas_credito_fact/script.js')}}"></script>
@endsection
