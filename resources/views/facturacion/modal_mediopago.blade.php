<!-- Modal Medios de Pago -->
<div class="modal fade" id="modalMediosPago" tabindex="-1" aria-labelledby="modalMediosPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg rounded-4">

      <!-- Header -->
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-semibold" id="modalMediosPagoLabel">
          💳 Medios de Pago
        </h5>
      </div>

      <!-- Body -->
      <div class="modal-body px-4 py-3">
        <form id="formMediosPago">

          <!-- Medios de pago convencionales -->
          <div class="row g-3 mb-4">

            <div class="col-md-4">
              <label class="form-label fw-semibold">💵 Efectivo</label>
              <input type="number" id="mediopefectivo" class="form-control text-end" value="0" min="0" onKeyPress="return soloNumerosdecimales(event)">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">🏦 Transferencia</label>
              <input type="number" id="medioptransferencia_bancaria" class="form-control text-end" value="0" min="0" onKeyPress="return soloNumerosdecimales(event)">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">🌐 PSE</label>
              <input type="number" id="medioppse" class="form-control text-end" value="0" min="0" onKeyPress="return soloNumerosdecimales(event)">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">💳 T. Crédito</label>
              <input type="number" id="medioptarjeta_credito" class="form-control text-end" value="0" min="0" onKeyPress="return soloNumerosdecimales(event)">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">💳 T. Débito</label>
              <input type="number" id="medioptarjeta_debito" class="form-control text-end" value="0" min="0">
            </div>

             <div class="col-md-4">
              <label class="form-label fw-semibold">🏛️ Consignación Bancaria</label>
              <input type="number" id="mediopconsignacion_bancaria" class="form-control text-end" value="0" min="0">
            </div>

             <div class="col-md-4">
              <label class="form-label fw-semibold">📄💰 Acta de depósito</label>
              <input type="number" readonly id="mediopactadeposito" class="form-control text-end" value="0" min="0">
            </div>

          </div>

          <!-- Separador -->
          <hr class="my-4">

          <!-- Sección Bono destacada -->
          <div class="card border-warning border-2 shadow-sm">

            <div class="card-header bg-warning bg-opacity-75">
              <h5 class="mb-0 fw-bold text-dark">
                🎟 Pago con Bono
              </h5>
              <small class="text-dark">Medio de pago especial</small>
            </div>

            <div class="card-body bg-light">

              <div class="row g-3 align-items-end">

                <div class="col-md-3">
                  <label class="form-label fw-semibold">Valor Bono</label>
                  <input type="number" id="valorbono" class="form-control text-end" value="0" min="0" placeholder="Valor bono" onKeyPress="return soloNumerosdecimales(event)">
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-semibold">Código Bono</label>
                  <input type="text" id="codigo_bono" class="form-control" placeholder="#Bono" maxlength="20">
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-semibold">Tipo Bono</label><br>
                  <select id="id_tipo_bono" class="form-select">
                    <option value="" disabled selected>Seleccione tipo</option>
                    @foreach ($TipoDeposito as $TipoDepo)
                      <option value="{{$TipoDepo->id_tip}}">
                        {{$TipoDepo->descripcion_tip}}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-semibold">Total Bono</label>
                  <input type="number" id="totalbono" class="form-control text-end bg-white" placeholder="Total del bono" onKeyPress="return soloNumerosdecimales(event)">
                </div>

              </div>

            </div>
          </div>

        </form>



        <!-- TOTAL FACTURA DESTACADO -->
      <div class="mt-4 p-3 rounded shadow-sm"
        style="background: #f8f9fa; border-left: 6px solid #198754;">
<hr>
      <div class="text-muted" style="font-size: 0.9rem;">
        Total factura
      </div>

      <div
        id="totalFactura"
        style="
          font-size: 3rem;
          font-weight: 700;
          color: #198754;
          line-height: 1;">  
      </div>

     </div>


      </div>
    <!----Footer----->
    <div class="modal-footer">
      <button type="button" 
                        class="btn btn-light px-4" 
                        onclick="CancelarMediosPago()">
                    Cancelar
                </button>
    <button type="button" class="btn btn-success" id="guardarfactura">
      ✓ Aceptar
    </button>
    </div>


    </div>
  </div>
</div>

<script>

  function CancelarMediosPago(){
    abonosporactasdeposito.length    = 0;
     $('#modalMediosPago').modal('hide');
  }
  

</script>
