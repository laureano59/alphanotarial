<div class="modal fade" id="modaldetallebonos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">   
  <div class="modal-dialog modal-lg d-flex align-items-center" style="min-height: 80vh; width: 100vw; margin: 0;">
    <div class="modal-content border-0 shadow-lg rounded-lg" style="display: flex; flex-direction: column; height: 100%; width: 100%;">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title mx-auto font-weight-bold">Detalle Factura No: <span id="factura"></span>  </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      
      <div class="modal-body d-flex flex-column flex-grow-1" style="overflow-y: auto;">
        <div class="table-responsive" style="width: 100%;">
          <table class="table table-bordered table-striped" style="width: 100%;">
            <thead class="bg-primary text-white">
              <tr>
                <th>No. Abono</th>
                <th>Código Bono</th>
                <th>No. Fact</th>
                <th>Fecha Fact</th>
                <th>Fecha Abono</th>
                <th>No. Esc</th>
                <th>Identificación</th>
                <th>Cliente</th>
                <th>Saldo General</th>
                <th>Valor Abono</th>
                <th>Saldo</th>
                <th>Valor del Bono</th>
              </tr>
            </thead>
            <tbody id="carteradata">
              <!-- Filas dinámicas -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
