<div class="widget-box">
    <div class="widget-header">
        <h4 class="widget-title">Radicación</h4>
        <div class="widget-toolbar">
            <a href="#" data-action="reload" id="guardar">
                <i><img src="{{ asset('images/comprobar.png') }}" width="28 px" height="28 px" title="Guardar Radicación"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-main">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"><b class="green">No.Radicación</b></label>
                    <div class="col-sm-9">
                        <input type="text" class="red" readonly="" size="5" id="anio_radica" name="anio_radica" value="{{$AnioTrabajo->anio_trabajo}}" />
                        <input type="text" class="red" readonly="" size="7" id="id_radica" name="id_radica" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="blue">Protocolista</b> </label>

                    <div class="col-sm-9">
                        <select class="form-control" id="id_proto" name="id_proto" style="width: 250px;">
                            <option value="" disabled selected>Elija Protocolista</option>
                            @foreach ($Protocolistas as $Protocolista)
                            <option value="{{$Protocolista->id_proto}}">{{$Protocolista->nombre_proto}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="space-10"></div>

        </div>
    </div>
</div>
