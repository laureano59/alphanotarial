
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nombres</label>
    <input type="text" size="30" id="pmer_nombrecli" value="{{$cli['pmer_nombrecli']}}" placeholder="Primer Nombre" onkeyup="mayus(this);" />
    <input type="text" size="30" id="sgndo_nombrecli" value="{{$cli['sgndo_nombrecli']}}" placeholder="Segundo Nombre" onkeyup="mayus(this);" />
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Apellidos</label>
    <input type="text" size="30" id="pmer_apellidocli" value="{{$cli['pmer_apellidocli']}}" placeholder="Primer Apellido" onkeyup="mayus(this);" />
    <input type="text" size="30" id="sgndo_apellidocli" value="{{$cli['sgndo_apellidocli']}}" placeholder="Segundo Apellido" onkeyup="mayus(this);" />
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Estado Civil</label>
    <select id="estadocivil">
        <option value="{{$cli['estadocivil']}}">{{$cli['estadocivil']}}</option>
        <option value="Soltero">Soltero</option>
        <option value="Casado">Casado</option>
        <option value="Unión Libre">Unión Libre</option>
        <option value="Unión Marital de Hecho">Unión Marital de Hecho</option>
        <option value="Soc. Conyugal Vigente">Soc. Conyugal Vigente</option>
        <option value="Soc. Conyugal disuelta en estado de liquidación">Soc. Conyugal disuelta en estado de liquidación</option>
        <option value="Soc. Conyugal disuelta y liquidada">Soc. Conyugal disuelta y liquidada</option>
        <option value="No Aplica">No Aplica</option>
        <option value="Indeterminado">No Indeterminado</option>
    </select>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Teléfono</label>
    <input type="text" size="50" id="telefono_cli" value="{{$cli['telefono_cli']}}" placeholder="No.Teléfono" />
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Dirección</label>
    <input type="text" size="50" id="direccion_cli" value="{{$cli['direccion_cli']}}" placeholder="Dirección" />
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Departamento</label>
    <select id="departamento">
        <option value="" disabled selected>Seleccione un departamento</option>
        @foreach ($Departamentos as $dep)
        <option value="{{$dep->id_depa}}">{{$dep->nombre_depa}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <div class="selector-ciudad">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Ciudad</label>
        <select id="ciudad">
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1">E-Mail</label>
    <input type="email" size="50" id="email_cli" name="email_cli" placeholder="Correo Electrónico" oninput="validarEmail(this)" />
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
