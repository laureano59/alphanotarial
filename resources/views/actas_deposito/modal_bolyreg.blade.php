<div class="modal fade" id="modalbolyreg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
  <div class="modal-dialog modal-lg d-flex align-items-center" style="min-height: 80vh;">
    <div class="modal-content border-0 shadow-lg rounded-lg" style="display: flex; flex-direction: column; height: 100%;">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title mx-auto font-weight-bold">Depósito de Boleta y Registro</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      
      <div class="modal-body d-flex flex-column flex-grow-1" style="overflow-y: auto;">
        <form class="w-100">
          <div class="form-group">
            <label><b class="text-primary">Depósito Boleta</b></label>
            <input type="text" id="depo_bol" class="form-control rounded-lg shadow-sm" onKeyPress="return soloNumeros(event)">

             <input type="hidden" id="depo_bol_hid">
          </div>

          <div class="form-group">
            <label><b class="text-primary">Depósito Registro</b></label>
            <input type="text" id="depo_reg" class="form-control rounded-lg shadow-sm" onKeyPress="return soloNumeros(event)">

            <input type="hidden" id="depo_reg_hid">
          </div>
        </form>
      </div>

      <div class="modal-footer d-flex justify-content-between bg-light border-0">
         <button type="button" id="obtenerbolyreg" class="btn btn-primary px-4 rounded-lg">Aceptar</button>
        <button type="button" id="cerrarbolyreg" class="btn btn-outline-secondary px-4 rounded-lg" data-dismiss="modal">Cancelar</button>
       
      </div>

    </div>
  </div>
</div>
