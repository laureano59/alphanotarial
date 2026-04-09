<!-- MODAL EGRESOS ACTAS FACT -->
<div class="modal fade" id="mod_egresos_actas_fact" tabindex="-1" role="dialog" 
     aria-hidden="true" style="z-index: 1065;">
  <div class="modal-dialog modal-dialog-centered" role="document" 
       style="max-width:95%; width:95%;">

    <div class="modal-content shadow-lg" style="border-radius:15px; overflow:hidden;">

      <!-- HEADER -->
      <div class="modal-header text-white"
           style="
             background: linear-gradient(135deg, #ff6a00, #ffb300);
             box-shadow: 0 4px 10px rgba(0,0,0,0.25);
             border-bottom: none;
           ">
        <h4 class="modal-title font-weight-bold d-flex align-items-center">
          <span class="badge badge-light text-uppercase mr-2" 
                style="font-size:1.0rem; letter-spacing:1px; color:#ff6a00;">
            Actas de depósito
          </span>
          <i class="fa fa-file-invoice-dollar mr-2"></i>
          Listado de Actas
        </h4>
        <button type="button" class="close text-white" data-dismiss="modal" style="opacity:1;">
          <span>&times;</span>
        </button>
      </div>

      <!-- BODY -->
      <div class="modal-body bg-light p-4" style="overflow:visible;">

        <table class="table table-hover table-bordered bg-white mb-0">
          
          <thead style="background-color:#f1f3f5;" class="text-center">
            <tr style="font-weight:600;">
              <th>No. Acta</th>
              <th>Fecha</th>
              <th>Nombre Proyecto</th>
              <th>Tipo Depósito</th>
              <th>Depósito por Escrituras</th>
              <th>Deposito por Boleta</th>
              <th>Deposito por Registro</th>
              <th>Total Depósito</th>
              <th>Saldo General</th>
              <th>Saldo por Escrituras</th>
              <th>Descuento</th>
              <th width="60"></th>
              <th width="60"></th>
            </tr>
          </thead>

          <tbody id="datos_acta">
            <!-- Se llena dinámicamente -->
          </tbody>

        </table>

      </div>

      <!-- FOOTER -->
      <div class="modal-footer bg-white">
        <button type="button" class="btn btn-light px-4" 
                onclick="CancelarActas()">
                    Cancelar
                </button>

                <button type="button" class="btn btn-success px-4 font-weight-bold"
                        onclick="AceptarActas()">
                    Aceptar
                </button>
            </div>

    </div>
  </div>
</div>

<script>

  function AceptarActas() {

   $('#mod_egresos_actas_fact').modal('hide');
   

   let valor =  abonosporactasdeposito.reduce((total, item) => {
                  return total + Number(item.descuento || 0);
                }, 0);
   

    $("#mediopactadeposito").val(valor);   

   
  }


  function CancelarActas() {

    abonosporactasdeposito.length    = 0;
    $('#mod_egresos_actas_fact').modal('hide');
   
  }
  


</script>
