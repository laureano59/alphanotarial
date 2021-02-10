@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Facturación Electrónica')
@section('content')

  <div class="page-header">

      <h1>
          Factura Electrónica<span id="radi">

      </h1>
  </div><!-- /.page-header -->


  <div class="row">
    <div class="col-sm-12">
        <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Ingresar Rango de Fecha</h4>
                    <span class="widget-toolbar">
                        <a href="#" data-action="settings" id="cargartodo">
                            <i><img src="{{ asset('images/buscar.png') }}" width="28 px" height="28 px" title="Mostrar"></i>
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

<br>
  <div class="row">
    <div class="col-sm-4">
      <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Facturas:&nbsp;&nbsp; dd/mm/yyyy</h4>
        </div>
        <div class="widget-body">
          
          <table id="simple-table" class="table table-bordered table-striped">
            <thead>
              <tr> 
                <th>No.Factura</th> 
                <th></th>
              </tr>
            </thead>
            <tbody id="datos">
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-sm-4">
      <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Notas Crédito:&nbsp;&nbsp; dd/mm/yyyy</h4>
        </div>

        <div class="widget-body">

          <table id="simple-table" class="table table-bordered table-striped">
            <thead>
              <tr> 
                <th>No.Nota Credito</th> 
                <th></th>
              </tr>
            </thead>
            <tbody id="datos_nc">
            </tbody>
          </table>

        </div>
      </div>
    </div>

    <div class="col-sm-4">
      <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Notas Débito:&nbsp;&nbsp; dd/mm/yyyy</h4>
        </div>

        <div class="widget-body">

          <table id="simple-table" class="table table-bordered table-striped">
            <thead>
              <tr> 
                <th>No.Nota Debito</th> 
                <th></th>
              </tr>
            </thead>
            <tbody id="datos_nd">
            </tbody>
          </table>
          
        </div>
      </div>
    </div>

  </div>

@endsection

@section('csslau')
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker3.min.css')}}" />
@endsection

@section('scripts')

  <script src="{{ asset('js/facturacion/scriptfactelectronica.js')}}"></script>
  <script src="{{ asset('js/__AJAX.js')}}"></script>
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
