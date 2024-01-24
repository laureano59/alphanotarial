@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
        Consulta de Facturas<span id="radi"></span>

    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-4">
        <div class="control-group">
            <label class="control-label bolder blue">Seleccione Filtro</label>
            <br>
            <input type="text" id="anio" size="5" placeholder="Año" onKeyPress="return soloNumeros(event)">
              
              <div class="radio">
                <label>
                  <input name="seleccion" id="factura" value="factura" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">No.Factura</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="identificacion" value="identificacion" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">No.Identificación</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="nombre" value="nombre" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">Nombre/Apellido/Empresa</span>
                </label>
              </div>

             <div class="radio">
                <label>
                  <input name="seleccion" id="usuario" value="usuario" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">Facturador</span>
                </label>
              </div>

        </div>
    </div>

    <div class="col-xs-7">
        <div class="control-group">
            <div class="widget-box">
                <div class="widget-header">
                    <div class="widget-toolbar">
                        <a href="javascript://" id="buscar">
                            <i><img src="{{ asset('images/analisis.png') }}" width="28 px" height="28 px" title="Buscar"></i>
                        </a>
                    </div>
                    
                    <center>
                        <h4 class="widget-title">Estas buscando por:&nbsp;<font color="red"><span id="tipo_filtro"></span></font>
                        </h4>
                    </center>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <form class="form-horizontal" role="form">
                          @csrf
                          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                          <input type="hidden" id="saldo_iden" value="0">
                          <input type="hidden" id="id_fact_iden" value="0">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right orange" for="form-field-1"> <b>Información a consultar</b></label>
                                <div class="col-sm-9">
                                    <input type="text" id="buscar_info" placeholder="Digite la información que desea buscar" class="col-xs-10 col-sm-10" />
                                </div>
                            </div>

                            <br>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

    <div class="row">
    <div class="col-xs-12">
      <table id="radicaciones" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No.Fact</th>
                <th>Fecha_Fact</th>
                <th>Id_Cliente</th>
                <th>Nombre_Cliente</th>
                <th>Facturador</th>
            </tr>
        </thead>
        <tbody id="data_consulta">
        </tbody>
    </table>

    </div>
  </div>

@endsection

@section('csslau')


@endsection

@section('scripts')

  <script src="{{asset('js/caja_rapida/consultas/script.js')}}"></script>
  <script src="{{asset('js/caja_rapida/consultas/grid_consulta.js')}}"></script>
  <script src="{{ asset('js/solonumeros.js')}}"></script>
  <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.dataTables.bootstrap.min.js')}}"></script>


@endsection
