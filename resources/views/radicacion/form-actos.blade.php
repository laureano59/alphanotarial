<div class="widget-box">
    <div class="widget-header">

      <div class="widget-toolbar">
          <a target="_blank" href="/reporteradicacion">
              <i><img src="{{ asset('images/imprimir.png') }}" width="28 px" height="28 px" title="Imprimir Radicación"></i>
          </a>
      </div>

        <div class="widget-toolbar">
            <a href="#" id="guardaractosradica">
                <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Acto"></i>
            </a>
        </div>

        <span class="nav-search widget-toolbar">
          <input type="text" id="radicacion" name="radicacion" placeholder="Buscar Radicación" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
          <a href="javascript://" id="buscaractosradica">
              <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar Radicación"></i>
          </a>
        </span>
        <span id="ok" class="nav-search widget-toolbar">

        </span>
        <span id="estadoradicacion" class="nav-search widget-toolbar">
        </span>
    </div>

    <div class="widget-body">
        <div class="widget-main">
            <div>
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="blue">Actos</b> </label>
                        <div class="col-sm-9">
                            <select class="chosen1" id="id_acto" data-placeholder="Seleccione un Acto">
                                <option value='' disabled selected>Seleccione un Acto</option>
                                @foreach ($Actos as $Acto)
                                <option value="{{$Acto->id_acto}}">{{$Acto->nombre_acto}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="blue">Cuantia</b> </label>

                        <div class="col-sm-9">
                            <input type="text" id="cuantia" name="cuantia" class="col-xs-10 col-sm-5" onKeyPress="return soloNumeros(event)" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="blue">Tradición</b> </label>

                        <div class="col-sm-9">
                            <input type="text" id="tradicion" name="tradicion" maxlength="4" onKeyPress="return soloNumeros(event)" class="col-xs-10 col-sm-5" />
                        </div>
                    </div>
                </div>
                <div class="space-10"></div>
            </div>
        </div>
    </div>
</div>
