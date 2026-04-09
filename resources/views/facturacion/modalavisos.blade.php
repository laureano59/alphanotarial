<!-- Modal Mensaje -->
<div class="modal fade"
     id="modalMensajeBonito"
     tabindex="-1"
     role="dialog"
     aria-labelledby="modalMensajeLabel"
     aria-hidden="true"
     style="position: fixed; z-index: 99999 !important;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow">

      <!-- Header -->
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title font-weight-bold" id="modalMensajeLabel">
          Atención
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body text-center">
        <p id="mensajeModalBonito" class="h5 text-secondary mb-0">
          <!-- Mensaje dinámico -->
        </p>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-warning px-4" data-dismiss="modal">
          Entendido
        </button>
      </div>

    </div>
  </div>
</div>
