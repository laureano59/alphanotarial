<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <!-- Encabezado -->
      <div class="modal-header">
        <h5 class="modal-title">Vista previa de factura</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Cuerpo con el PDF -->
      <div class="modal-body">
        <iframe id="pdfIframe" src="" width="100%" height="600px" frameborder="0"></iframe>
      </div>

      <!-- Pie con botones -->
      <div class="modal-footer">
        <button type="button" id="notacredito" class="btn btn-danger" >Crear Nota Crédito</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>        
      </div>

    </div>
  </div>
</div>
