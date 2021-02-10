<div class="modal fade" id="modalactosradica" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Editar Actos</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          @csrf
          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
          <input type="hidden" id="id_actoperrad">
          <input type="hidden" id="id_rad">
            @include('radicacion.form-actos-edit')
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="actualizar" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
