<div class="modal fade" id="mod_acargo_de" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow rounded">

      <!-- Header -->
      <div class="modal-header bg-info text-white">
        <h4 class="modal-title">
          <i class="fa fa-edit mr-2"></i> Escribir detalle
        </h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4">
        <div class="form-group">
          <label for="detalle_acargo_de" class="font-weight-bold">
            Detalla el A Cargo de
          </label>
          <input 
            type="text" 
            class="form-control form-control-lg" 
            id="detalle_acargo_de"
            placeholder="Escriba el detalle..."
            autocomplete="off"
          >
        </div>

        <input type="hidden" id="doc_acargo_de">
      </div>

      <!-- Footer -->
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-info px-4" data-dismiss="modal">
          <i class="fa fa-check"></i> Aceptar
        </button>
      </div>

    </div>
  </div>
</div>
