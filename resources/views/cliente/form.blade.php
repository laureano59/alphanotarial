<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Identificación</label>
  <select id="tipo_documento" style="width: 70px;">
    <option value="" disabled selected>T.Doc</option>
    @foreach ($TipoIdentificaciones as $TipoIdentificacion)
    <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
    @endforeach
  </select>
  <input type="text" size="30" id="identificacion" name="identificacion_cli" placeholder="No.Identificación" />
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nombres</label>
  <input type="text" size="30" id="pmer_nombrecli" name="pmer_nombrecli" placeholder="Primer Nombre" onkeyup="mayus(this);"/>
  <input type="text" size="30" id="sgndo_nombrecli" name="sgndo_nombrecli" placeholder="Segundo Nombre" onkeyup="mayus(this);"/>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Apellidos</label>
  <input type="text" size="30" id="pmer_apellidocli" name="pmer_apellidocli" placeholder="Primer Apellido" onkeyup="mayus(this);"/>
  <input type="text" size="30" id="sgndo_apellidocli" name="sgndo_apellidocli" placeholder="Segundo Apellido" onkeyup="mayus(this);"/>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Estado Civil</label>
  <select id="estadocivil">
    <option value="" disabled selected>Estado Civil</option>
    <option value="Soltero">Soltero</option>
    <option value="Casado">Casado</option>
    <option value="Casado">Unión Libre</option>
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
  <input type="text" size="50" id="telefono_cli" name="telefono_cli" placeholder="No.Teléfono" />
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Dirección</label>
  <input type="text" size="50" id="direccion_cli" name="direccion_cli" placeholder="Dirección" />
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
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Act_Econ</label>
  <select id="actiecon" style="width: 600px;">
    <option value="" disabled selected>Seleccione Actividad Económica</option>
    @foreach ($Actividad_economica as $Acteco)
    <option value="{{$Acteco->codigo}}">{{$Acteco->actividad}}</option>
    @endforeach
  </select>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Autoretenedor de Iva</label>
  <input name="autoreiva_natural" id="si" value="si" type="radio" class="ace" />
  <span class="lbl"> Si</span>
  <input name="autoreiva_natural" id="no" value="no" type="radio" class="ace" />
  <span class="lbl"> No</span>
</div>

<div class="form-group">
  <br>
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Autoretenedor de Retefuente</label>
  <input name="autorertf_natural" id="si" value="si" type="radio" class="ace" />
  <span class="lbl"> Si</span>
  <input name="autorertf_natural" id="no" value="no" type="radio" class="ace" />
  <span class="lbl"> No</span>
</div>

<div class="form-group">
  <br>
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Autoretenedor de Ica</label>
  <input name="autoreica_natural" id="si" value="si" type="radio" class="ace" />
  <span class="lbl"> Si</span>
  <input name="autoreica_natural" id="no" value="no" type="radio" class="ace" />
  <span class="lbl"> No</span>
</div>
