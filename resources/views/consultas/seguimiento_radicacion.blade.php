@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<!-- HEADER MODERNO -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius:20px; background: linear-gradient(135deg,#1e3c72,#2a5298);">
                <div class="card-body text-white text-center">
                    <h2 class="mb-0" style="font-weight:600; letter-spacing:1px; color: #FFF;">
                        🔎 Rastrear Radicación <span id="radi"></span>
                    </h2>
                    <small class="opacity-75" style="color: #FFF;">Sistema inteligente de consulta notarial</small>
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-xs-4">
        <div class="control-group">
            <label class="control-label bolder blue">Seleccione Filtro</label>
            <br>
            <input type="text" id="anio" size="5" placeholder="Año" onKeyPress="return soloNumeros(event)">
              <div class="radio">
                <label>
                  <input name="seleccion" id="radicacion" value="radicacion" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">No.Radicación</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="factura" value="factura" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">No.Factura</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="escritura" value="escritura" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">No.Escritura</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="otorgante" value="otorgante" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">Otorgante</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="compareciente" value="compareciente" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">Compareciente</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="protocolista" value="protocolista" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">Protocolista</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="usuario" value="usuario" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">Usuario</span>
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
                            <i><img src="{{ asset('images/analisis.png') }}" width="28 px" height="28 px" title="Buscar Principales"></i>
                        </a>

                        <a href="javascript://" id="buscar_secun">
                            <i><img src="{{ asset('images/analisis.png') }}" width="28 px" height="28 px" title="Buscar secundarios"></i>
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

  <!-- TABLA RESULTADOS -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius:20px;">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold text-primary">📊 Resultados de la Consulta</h5>
                </div>

                <div class="card-body">
                    <table id="radicaciones" 
                           class="table table-hover table-striped table-bordered"
                           style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th>No.Radi</th>
                                <th>Fecha_Rad</th>
                                <th>Usuario</th>
                                <th>Protocolista</th>
                                <th>No.Fact</th>
                                <th>Fecha_Fact</th>
                                <th>No.Escr</th>
                                <th>Fecha_Esc</th>
                                <th>Otorgante</th>
                                <th>Nombre_otorgante</th>
                                <th>Compareciente</th>
                                <th>Nombre_compareciente</th>
                                <th>Acto</th>
                            </tr>
                        </thead>
                        <tbody id="data_seguimiento">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('csslau')
<style>

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
}

.filtro-item {
    padding: 8px 12px;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.filtro-item:hover {
    background: rgba(42,82,152,0.08);
    cursor: pointer;
}

#buscar_info {
    border-radius: 12px;
    padding: 10px 15px;
}

.btn {
    border-radius: 12px;
}

table.dataTable thead {
    font-size: 13px;
}

table.dataTable tbody tr:hover {
    background-color: rgba(42,82,152,0.08) !important;
}

</style>
@endsection

@section('scripts')

  <script src="{{asset('js/consultas/script.js')}}"></script>
  <script src="{{asset('js/consultas/gridseguimiento.js')}}"></script>
  <script src="{{ asset('js/solonumeros.js')}}"></script>
  <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.dataTables.bootstrap.min.js')}}"></script>


@endsection
