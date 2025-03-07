<div class="form-horizontal">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="red">Actos</b> </label>
        <div class="col-sm-9">
            <select  id="id_act" data-placeholder="Seleccione un Acto">
                <option value="" disabled selected>Seleccione un Acto</option>
                @foreach ($Actos as $Acto)
                <option value="{{$Acto->id_acto}}">{{$Acto->nombre_acto}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="red">Cuantia</b> </label>

        <div class="col-sm-9">
            <input type="text" id="cuant" name="cuant" class="col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="red">Catastro</b> </label>

        <div class="col-sm-9">
            <input type="text" id="catast" name="catast" class="col-xs-10 col-sm-5" />
        </div>
    </div>

   <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="red">Tradición</b> </label>
    <div class="col-sm-9">
        <input type="hidden" id="tradi" name="tradi" maxlength="4" onKeyPress="return soloNumeros(event)" class="col-xs-10 col-sm-5" />
            <div class="input-group date col-sm-4" data-provide="datepicker">
                <input type="text" class="form-control" id="fecha_tradicion" disabled="disabled" >
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
    </div>  
    </div>


    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="red">Matri_Inmob</b> </label>
        <div class="col-sm-9">
            <input type="text" id="matripref" maxlength="5" class="col-xs-10 col-sm-2" placeholder="prefijo" />
            <input type="text" id="matricu" maxlength="30" class="col-xs-10 col-sm-7" placeholder="matricula" />
        </div>
    </div>
</div>
