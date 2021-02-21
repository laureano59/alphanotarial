<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Empresa</label>
  <input type="text" size="50" id="empresa" value="{{$cli['empresa']}}" placeholder="Nombre de la Empresa" onkeyup="mayus(this);"/>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Teléfono</label>
  <input type="text" size="50" id="telefono_cli_empresa"  value="{{$cli['telefono_cli']}}" placeholder="No.Teléfono" />
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Dirección</label>
  <input type="text" size="50" id="direccion_cli_empresa" value="{{$cli['direccion_cli']}}" placeholder="Dirección" />
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Departamento</label>
  <select id="departamento_empresa">
      <option value="" disabled selected>Seleccione un departamento</option>
      @foreach ($Departamentos as $dep)
        <option value="{{$dep->id_depa}}">{{$dep->nombre_depa}}</option>
      @endforeach
  </select>
</div>

<div class="form-group">
  <div class="selector-ciudad-empresa">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Ciudad</label>
  <select id="ciudad_empresa">
  </select>
</div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">E-Mail</label>
  <input type="email" size="50" id="email_cli_empresa" value="{{$cli['email_cli']}}" placeholder="Correo Electrónico" />
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Autoretenedor de Iva</label>
  @if($cli['autoreteiva'] == true)
    <input name="autoreiva_natural" id="si" checked value="si" type="radio" class="ace" />
    <span class="lbl"> Si</span>
    <input name="autoreiva_natural" id="no" value="no" type="radio" class="ace" />
    <span class="lbl"> No</span>
  @elseif($cli['autoreteiva'] == false)
    <input name="autoreiva_natural" id="si" value="si" type="radio" class="ace" />
    <span class="lbl"> Si</span>
    <input name="autoreiva_natural" id="no" checked value="no" type="radio" class="ace" />
    <span class="lbl"> No</span>
  @endif
</div>

<div class="form-group">
  <br>
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Autoretenedor de Retefuente</label>
  @if($cli['autoretertf'] == true)
    <input name="autorertf_natural" id="si" checked value="si" type="radio" class="ace" />
    <span class="lbl"> Si</span>
    <input name="autorertf_natural" id="no" value="no" type="radio" class="ace" />
    <span class="lbl"> No</span>
  @elseif($cli['autoretertf'] == false)
    <input name="autorertf_natural" id="si" value="si" type="radio" class="ace" />
    <span class="lbl"> Si</span>
    <input name="autorertf_natural" id="no" checked value="no" type="radio" class="ace" />
    <span class="lbl"> No</span>
  @endif
</div>

<div class="form-group">
  <br>
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Autoretenedor de Ica</label>
  @if($cli['autoreteica'] == true)
  <input name="autoreica_natural" id="si" checked value="si" type="radio" class="ace" />
  <span class="lbl"> Si</span>
  <input name="autoreica_natural" id="no" value="no" type="radio" class="ace" />
  <span class="lbl"> No</span>
  @elseif($cli['autoreteica'] == false)
  <input name="autoreica_natural" id="si" value="si" type="radio" class="ace" />
  <span class="lbl"> Si</span>
  <input name="autoreica_natural" id="no" checked value="no" type="radio" class="ace" />
  <span class="lbl"> No</span>
  @endif
</div>
