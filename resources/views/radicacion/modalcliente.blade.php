<!-- MODAL CREAR CLIENTE PRO -->
<div class="modal fade" id="modalcliente" tabindex="-1" role="dialog" style="z-index: 1065;">
  <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width:90%; width:90%;">
    <div class="modal-content shadow-lg border-0 rounded-lg">

      <!-- HEADER -->
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title font-weight-bold">
          <i class="fa fa-user-plus mr-2"></i> Nuevo Cliente
        </h4>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <!-- BODY -->
      <div class="modal-body px-5 py-4">

        <form>
          @csrf
          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
          <input type="hidden" id="identificacion_cli">
          <input type="hidden" id="calidad">

          @include('cliente.form')

        </form>
      </div>

      <!-- FOOTER -->
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
          Cancelar
        </button>
        <button type="button" id="guardar_cli"
                class="btn btn-primary px-4 shadow">
          <i class="fa fa-save"></i> Guardar Cliente
        </button>
      </div>

    </div>
  </div>
</div>