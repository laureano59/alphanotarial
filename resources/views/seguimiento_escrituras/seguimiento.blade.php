@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">
    <h1>Trazabilidad de las Escrituras</h1>
</div><!-- /.page-header -->
<form>
    @csrf
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <input type="hidden" id="tipogrid" value="retiros">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <span class="nav-search widget-toolbar">
                        <input type="text" id="idfact" placeholder="Buscar por No.de Escritura" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
                        <a href="javascript://" id="buscarpornumesc">
                            <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar por No.de Factura"></i>
                        </a>
                    </span>

                    <span class="nav-search widget-toolbar">
                        <input type="text" id="identif" placeholder="Buscar por No de Radicación" class="nav-search-input" autocomplete="off"  onKeyPress="return soloNumeros(event)" />
                        <a href="javascript://" id="buscarpornumrad">
                            <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar por Identificación"></i>
                        </a>
                    </span>

                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <table id="simple-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.Radicación</th>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Liquidada</th>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody id="data"></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
  </form>
    <hr>
    <div class="row">
        <div class="alert alert-success" role="alert" id="msj-error1" style="display:none">
            <strong id="msj1"></strong>
        </div>
         <div class="widget-body" style hidden>
                    <div class="widget-main">

                        <table id="simple-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.seguimiento</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody id="data"></tbody>
                        </table>

                    </div>
                </div>

</form>
@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/seguimiento_escrituras/script.js')}}"></script>
<script src="{{ asset('js/seguimiento_escrituras/grid.js')}}"></script>
<script src="{{ asset('js/validaradicacion.js')}}"></script>
@endsection
