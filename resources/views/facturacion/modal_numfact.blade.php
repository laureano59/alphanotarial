<!-- MODAL FACTURA -->
<div class="modal fade" id="modalFactura" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content factura-modal">

            <div class="modal-body text-center">

                <h1 class="factura-title">
                    Factura No.
                    <span id="numeroFactura">FEN-000</span>
                </h1>

                <div class="factura-divider"></div>

                <div class="mt-4">

                    <!-- BOTÓN IMPRIMIR FACTURA -->
                    <button class="btn btn-imprimir" onclick="imprimirFactura()">                       
                        <img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" class="mr-2" title="Imprimir Factura">
                        Imprimir Factura
                    </button>

                    <!-- BOTÓN RTF (OCULTO POR DEFECTO) -->
                    <div id="contenedorRTF" class="mt-3" style="display:none;">
                        <button class="btn btn-rtf" onclick="imprimirRTF()">
                            Imprimir Certificado de Retención en la Fuente
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<style>
.factura-modal {
    border-radius: 20px;
    padding: 40px 20px;
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    animation: fadeInScale 0.4s ease;
}

.factura-title {
    font-size: 3rem;
    font-weight: 800;
    color: #2c3e50;
}

.factura-title span {
    display: block;
    font-size: 3.5rem;
    color: #007bff;
    margin-top: 10px;
    letter-spacing: 2px;
}

.factura-divider {
    width: 80px;
    height: 5px;
    background: #007bff;
    margin: 25px auto;
    border-radius: 10px;
}

.btn-imprimir {
    background: #007bff;
    color: #fff;
    font-size: 1.2rem;
    padding: 12px 30px;
    border-radius: 50px;
    border: none;
    margin-bottom: 25px;
    transition: 0.3s;
    box-shadow: 0 8px 20px rgba(0,123,255,0.3);
}

.btn-imprimir:hover {
    background: #0056b3;
    transform: translateY(-3px);
}

.btn-rtf {
    background: #28a745;
    color: #fff;
    font-size: 1rem;
    padding: 10px 25px;
    border-radius: 50px;
    border: none;
    transition: 0.3s;
    box-shadow: 0 6px 15px rgba(40,167,69,0.3);
}

.btn-rtf:hover {
    background: #1e7e34;
    transform: translateY(-3px);
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<script>
function mostrarModalFactura(info) {

    // Colocar número de factura
    document.getElementById("numeroFactura").innerText = info.id_fact;

    // Mostrar u ocultar botón RTF
    if (parseFloat(info.total_rtf) > 0) {
        document.getElementById("contenedorRTF").style.display = "block";
    } else {
        document.getElementById("contenedorRTF").style.display = "none";
    }

    // Mostrar modal
    $('#modalFactura').modal('show');
}

// Funciones ejemplo
function imprimirFactura() {
     var url = "/factunicapdf";
      $("<a>").attr("href", url).attr("target", "_blank")[0].click();
  
}

function imprimirRTF() {
    var opcion = 13;
    var reporte = "Certificado de Retención en la Fuente";
    var ordenar = "nuevos";
    var route = "/cargartiporeporte";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
            "opcionreporte": opcion,
            "reporte": reporte,
            "ordenar": ordenar
        };
    __ajax(route, token, type, datos)
        .done( function( info ){
            if(info.validar == 1){
                 window.open("/reportes", "_blank");
        }
    })
}
</script>
