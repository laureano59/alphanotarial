<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Identificación</label>
  <select id="tipo_documento_empresa" style="width: 70px;">
      <option value="" disabled selected>T.Doc</option>
      @foreach ($TipoIdentificaciones as $TipoIdentificacion)
        <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
      @endforeach
  </select>
  <input type="text" size="30" id="identificacion_empresa" name="identificacion_empresa" placeholder="Nit" />
  <input type="text" size="5" id="digito_verif" name="digito_verif" placeholder="Dígito" />
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Empresa</label>
  <input type="text" size="50" id="empresa" name="empresa" placeholder="Nombre de la Empresa" onkeyup="mayus(this);"/>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Teléfono</label>
  <input type="text" size="50" id="telefono_cli_empresa" name="telefono_cli" placeholder="No.Teléfono" />
</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Dirección</label>
  <input type="text" size="50" id="direccion_cli_empresa" name="direccion_cli" placeholder="Dirección" />
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
  <input type="email" size="50" id="email_cli_empresa" name="email_cli" placeholder="Correo Electrónico" oninput="validarEmail(this)" />

</div>

<div class="form-group">
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Autoretenedor de Iva</label>
  <input name="autoreiva" id="si" value="si" type="radio" class="ace" />
  <span class="lbl"> Si</span>
  <input name="autoreiva" id="no" value="no" type="radio" class="ace" />
  <span class="lbl"> No</span>
</div>

<div class="form-group">
  <br>
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Autoretenedor de Retefuente</label>
  <input name="autorertf" id="si" value="si" type="radio" class="ace" />
  <span class="lbl"> Si</span>
  <input name="autorertf" id="no" value="no" type="radio" class="ace" />
  <span class="lbl"> No</span>
</div>

<div class="form-group">
  <br>
  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Autoretenedor de Ica</label>
  <input name="autoreica" id="si" value="si" type="radio" class="ace" />
  <span class="lbl"> Si</span>
  <input name="autoreica" id="no" value="no" type="radio" class="ace" />
  <span class="lbl"> No</span>
</div>
