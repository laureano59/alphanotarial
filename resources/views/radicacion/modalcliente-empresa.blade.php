<div class="modal fade" id="modalcliente-empresa" tabindex="-1" role="dialog">
  <div class= "modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Crear Cliente</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          @csrf
          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
          <input type="hidden" id="identificacion_cli">
          <input type="hidden" id="calidad">
            @include('cliente.form-empresa')
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="guardar-cli-empresa" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
