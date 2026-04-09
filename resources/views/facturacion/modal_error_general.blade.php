<!-- Modal de Error Bonita (Bootstrap 4) -->
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalErrorTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 450px;">
        <div class="modal-content" style="
            border: none;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.3);
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            overflow: hidden;
        ">
            <!-- Header con icono y título -->
            <div class="modal-header" style="
                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                border-bottom: none;
                padding: 25px 30px;
                color: white;
                position: relative;
                overflow: hidden;
            ">
                <div style="display: flex; align-items: center; width: 100%;">
                    <div style="
                        font-size: 28px;
                        margin-right: 15px;
                        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
                    ">⚠️</div>
                    <div>
                        <h5 class="modal-title mb-0" id="modalErrorTitulo" style="font-weight: 600; font-size: 20px; margin: 0;">Error inesperado</h5>
                        <small id="modalErrorSubtitulo" style="opacity: 0.9;">Revisa los detalles a continuación</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar" style="
                    font-size: 30px;
                    font-weight: 300;
                    opacity: 0.8;
                    text-shadow: none;
                ">
                    ×
                </button>
            </div>
            
            <!-- Body con mensaje editable -->
            <div class="modal-body p-4" style="padding: 30px;">
                <div id="contenidoError" style="
                    min-height: 80px;
                    font-size: 16px;
                    line-height: 1.6;
                    color: #495057;
                    background: rgba(220, 53, 69, 0.05);
                    border-left: 4px solid #dc3545;
                    padding: 20px;
                    border-radius: 8px;
                    font-weight: 500;
                ">
                    
                </div>
            </div>
            
            <!-- Footer -->
            <div class="modal-footer border-top" style="
                padding: 20px 30px;
                background: #f8f9fa;
                border-top: 1px solid #e9ecef;
            ">
                <button type="button" class="btn btn-outline-danger btn-block" data-dismiss="modal" style="
                    border-radius: 25px;
                    font-weight: 500;
                    padding: 12px 30px;
                    border: 2px solid #dc3545;
                    transition: all 0.3s ease;
                " onmouseover="this.style.background='#dc3545'; this.style.color='white';" 
                   onmouseout="this.style.background='transparent'; this.style.color='#dc3545';">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
