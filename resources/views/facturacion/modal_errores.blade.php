<div class="modal fade" id="modalErroresDerechos" tabindex="-1" role="dialog" aria-labelledby="modalErroresDerechosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius:10px;">

      <div class="modal-header" style="background:#dc3545; color:#fff; border-top-left-radius:10px; border-top-right-radius:10px;">
        <h5 class="modal-title" id="modalErroresDerechosLabel">
          ⚠️ Inconsistencias detectadas
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p style="font-size:14px;">
          Se encontraron inconsistencias en los valores calculados para los siguientes Items.
          Revisa la información antes de continuar con el proceso.
        </p>

        <ul id="listaErroresDerechos" class="list-group">
          <!-- contenido dinámico -->
        </ul>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Revisar información
        </button>
      </div>

    </div>
  </div>
</div>
