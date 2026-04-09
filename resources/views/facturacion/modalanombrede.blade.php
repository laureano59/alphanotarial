<div class="modal fade" id="mod_anombrede" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg rounded">

      <!-- Header -->
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title">
          <i class="fa fa-user-circle mr-2"></i> Seleccione un Cliente
        </h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead class="thead-light">
              <tr>
                <th class="text-center">
                  <i class="fa fa-id-card text-primary"></i><br>
                  Identificación
                </th>
                <th>
                  <i class="fa fa-user text-primary"></i>
                  Nombre
                </th>
                <th>
                  <i class="fa fa-briefcase text-primary"></i>
                  A Cargo de
                </th>
              </tr>
            </thead>
            <tbody id="datos_anombrede"></tbody>
          </table>
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">
          <i class="fa fa-times"></i> Cerrar
        </button>
      </div>

    </div>
  </div>
</div>
