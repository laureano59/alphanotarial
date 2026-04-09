<style>
  /* CONTENEDOR GENERAL DEL FORMULARIO EN MODAL */
  .cliente-modal-wrapper {
    padding: 2rem;
    background: #f3f4f6;
    border-radius: 18px;
    position: relative;
  }

  /* HEADER GENERAL */
  .cliente-modal-header {
    color: #111827;
    margin-bottom: 1.75rem;
  }

  .cliente-title {
    font-weight: 700;
    letter-spacing: 0.03em;
  }

  .cliente-subtitle {
    font-size: 0.9rem;
    color: #6b7280;
  }

  /* GRID PRINCIPAL */
  .cliente-main-grid {
    row-gap: 1.75rem;
  }

  /* CARDS ESTILO BANCO */
  .cliente-card {
    position: relative;
    border-radius: 14px;
    padding: 1.5rem 1.5rem 1.25rem;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow:
      0 10px 25px rgba(15, 23, 42, 0.04),
      0 0 0 1px rgba(148, 163, 184, 0.18);
  }

  .cliente-card-personal {
    border-top: 3px solid #1d4ed8;
  }

  .cliente-card-contacto {
    border-top: 3px solid #0f766e;
  }

  .cliente-card-tributaria {
    border-top: 3px solid #b45309;
  }

  /* HEADER DE CADA CARD */
  .cliente-card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
  }

  .cliente-card-header h6 {
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #111827;
  }

  .cliente-card-header small {
    font-size: 0.78rem;
    color: #6b7280;
  }

  /* PASTILLAS LATERALES DISCRETAS */
  .cliente-pill {
    width: 6px;
    height: 40px;
    border-radius: 999px;
  }

  .pill-personal {
    background: linear-gradient(to bottom, #2563eb, #1d4ed8);
  }

  .pill-contacto {
    background: linear-gradient(to bottom, #059669, #047857);
  }

  .pill-tributaria {
    background: linear-gradient(to bottom, #f59e0b, #b45309);
  }

  /* CUERPO DEL CARD */
  .cliente-card-body {
    color: #111827;
  }

  /* ESPACIADO ENTRE FILAS / CAMPOS */
  .cliente-card-body .row {
    margin-bottom: 0.35rem;
  }

  .cliente-card-body .row:last-child {
    margin-bottom: 0;
  }

  /* LABELS */
  .cliente-label {
    display: block;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.09em;
    margin-bottom: 0.25rem;
    color: #6b7280;
  }

  /* WRAPPER DE INPUT CON ICONO (MUCHO MÁS SUTIL) */
  .cliente-input-wrapper {
    position: relative;
  }

  .cliente-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.9rem;
    color: #9ca3af;
    pointer-events: none;
  }

  /* INPUTS / SELECTS CORPORATIVOS */
  .cliente-input.form-control,
  .cliente-input.form-select {
    border-radius: 8px;
    background-color: #f9fafb;
    border: 1px solid #d1d5db;
    color: #111827;
    padding-left: 2.1rem;
    padding-right: 0.75rem;
    font-size: 1.2rem;
    height: 2.4rem;
  }

  .cliente-input.form-control::placeholder {
    color: #9ca3af;
  }

  .cliente-input.form-control:focus,
  .cliente-input.form-select:focus {
    background-color: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.16);
    color: #111827;
  }

  /* DIVISOR AUTORETENCIONES */
  .cliente-divider {
    position: relative;
    text-align: left;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: #9ca3af;
    margin: 1.1rem 0 0.75rem;
  }

  .cliente-divider::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -0.3rem;
    width: 80px;
    height: 2px;
    background: #e5e7eb;
  }

  /* RADIOS PERSONALIZADOS SOBRIOS */
  .cliente-radio-title {
    font-size: 1rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.45rem;
  }

  .cliente-radio-group {
    display: inline-flex;
    gap: 0.25rem;
    background: #f9fafb;
    padding: 0.1rem;
    border-radius: 999px;
    border: 1px solid #e5e7eb;
  }

  .cliente-radio {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.1rem 0.7rem;
    border-radius: 999px;
    cursor: pointer;
    font-size: 1.2rem;
    color: #4b5563;
    transition: background-color 0.15s ease-out, color 0.15s ease-out;
  }

  .cliente-radio input {
    display: none;
  }

  .cliente-radio span {
    position: relative;
  }

  .cliente-radio input:checked + span {
    color: #111827;
    font-weight: 600;
  }

  .cliente-radio input:checked + span::before {
    content: "";
    position: absolute;
    inset: -0.1rem -0.55rem;
    border-radius: 999px;
    background: #e5f0ff;
    z-index: -1;
  }

  /* HINT CONTACTO */
  .cliente-hint {
    font-size: 0.78rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: 1.25rem;
  }

  /* RESPONSIVE: DAR MÁS AIRE EN MOBILE */
  @media (max-width: 991.98px) {
    .cliente-modal-wrapper {
      padding: 1.5rem 1.25rem;
    }

    .cliente-card {
      padding: 1.25rem 1.1rem 1rem;
    }

    .cliente-input.form-control,
    .cliente-input.form-select {
      height: 2.6rem;
    }
  }
</style>

<!-- AQUÍ VA TU CONTENIDO DENTRO DEL MODAL -->
<div class="cliente-modal-wrapper">

  <div class="cliente-modal-header text-center mb-4">
    <h4 class="cliente-title mb-1">Perfil del Cliente</h4>
    <p class="cliente-subtitle mb-0">Completa la información personal, de contacto y tributaria</p>
  </div>

  <div class="row g-4 cliente-main-grid">

    <!-- COLUMNA IZQUIERDA -->
    <div class="col-lg-6">

      <!-- INFORMACIÓN PERSONAL -->
      <div class="cliente-card cliente-card-personal">
        <div class="cliente-card-header">
          <div class="cliente-pill pill-personal"></div>
          <div>
            <h6 class="mb-0">Información Personal</h6>
            <small>Identificación y datos básicos</small>
          </div>
        </div>

        <div class="cliente-card-body">

          <div class="row g-3 align-items-end">

            <div class="col-md-1">
              <label class="cliente-label">Tipo Doc</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-id-card"></i>
                <select id="tipo_documento" class="form-select form-select-sm cliente-input">
                  <option value="" disabled selected>T.Doc</option>
                  @foreach ($TipoIdentificaciones as $TipoIdentificacion)
                    <option value="{{$TipoIdentificacion->id_tipoident}}">
                      {{$TipoIdentificacion->abrev}}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-5">
              <label class="cliente-label">Identificación</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-hash"></i>
                <input type="text"
                       id="identificacion"
                       name="identificacion_cli"
                       class="form-control cliente-input"
                       placeholder="Número de identificación">
              </div>
            </div>

            <div class="col-md-2">
              <label class="cliente-label">Estado Civil</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-user-voice"></i>
                <select id="estadocivil" class="form-select cliente-input">
                  <option value="" disabled selected>Seleccione</option>
                  <option value="Soltero">Soltero</option>
                  <option value="Casado">Casado</option>
                  <option value="Unión Libre">Unión Libre</option>
                  <option value="Unión Marital de Hecho">Unión Marital de Hecho</option>
                  <option value="Soc. Conyugal Vigente">Soc. Conyugal Vigente</option>
                  <option value="Soc. Conyugal disuelta en estado de liquidación">
                    Soc. Conyugal disuelta en estado de liquidación
                  </option>
                  <option value="Soc. Conyugal disuelta y liquidada">
                    Soc. Conyugal disuelta y liquidada
                  </option>
                  <option value="No Aplica">No Aplica</option>
                  <option value="Indeterminado">Indeterminado</option>
                </select>
              </div>
            </div>

          </div>

          <div class="row g-3 mt-3">

            <div class="col-md-6">
              <label class="cliente-label">Primer Nombre</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-user"></i>
                <input type="text"
                       id="pmer_nombrecli"
                       name="pmer_nombrecli"
                       class="form-control cliente-input"
                       onkeyup="mayus(this);"
                       placeholder="Primer nombre">
              </div>
            </div>

            <div class="col-md-6">
              <label class="cliente-label">Segundo Nombre</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-user"></i>
                <input type="text"
                       id="sgndo_nombrecli"
                       name="sgndo_nombrecli"
                       class="form-control cliente-input"
                       onkeyup="mayus(this);"
                       placeholder="Segundo nombre">
              </div>
            </div>

          </div>

          <div class="row g-3 mt-3">

            <div class="col-md-6">
              <label class="cliente-label">Primer Apellido</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-user-circle"></i>
                <input type="text"
                       id="pmer_apellidocli"
                       name="pmer_apellidocli"
                       class="form-control cliente-input"
                       onkeyup="mayus(this);"
                       placeholder="Primer apellido">
              </div>
            </div>

            <div class="col-md-6">
              <label class="cliente-label">Segundo Apellido</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-user-circle"></i>
                <input type="text"
                       id="sgndo_apellidocli"
                       name="sgndo_apellidocli"
                       class="form-control cliente-input"
                       onkeyup="mayus(this);"
                       placeholder="Segundo apellido">
              </div>
            </div>

          </div>

        </div>
      </div>

      <!-- INFORMACIÓN TRIBUTARIA -->
      <div class="cliente-card cliente-card-tributaria mt-4">
        <div class="cliente-card-header">
          <div class="cliente-pill pill-tributaria"></div>
          <div>
            <h6 class="mb-0">Información Tributaria</h6>
            <small>Responsabilidades y actividad económica</small>
          </div>
        </div>

        <div class="cliente-card-body">

          <div class="mb-3">
            <label class="cliente-label">Actividad Económica</label>
            <div class="cliente-input-wrapper">
              <i class="cliente-icon bx bx-briefcase-alt"></i>
              <select id="actiecon" class="form-select cliente-input">
                <option value="" disabled selected>Seleccione Actividad Económica</option>
                @foreach ($Actividad_economica as $Acteco)
                  <option value="{{$Acteco->codigo}}">
                    {{$Acteco->actividad}}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="cliente-divider my-3">
            <span>Autoretenciones</span>
          </div>

          <div class="row text-center gy-3">

            <div class="col-md-4">
              <p class="cliente-radio-title mb-1">Autoretenedor IVA</p>
              <div class="cliente-radio-group">
                <label class="cliente-radio">
                  <input name="autoreiva_natural" value="si" type="radio">
                  <span>Sí</span>
                </label>
                <label class="cliente-radio">
                  <input name="autoreiva_natural" value="no" type="radio">
                  <span>No</span>
                </label>
              </div>
            </div>

            <div class="col-md-4">
              <p class="cliente-radio-title mb-1">Autoretenedor Retefuente</p>
              <div class="cliente-radio-group">
                <label class="cliente-radio">
                  <input name="autorertf_natural" value="si" type="radio">
                  <span>Sí</span>
                </label>
                <label class="cliente-radio">
                  <input name="autorertf_natural" value="no" type="radio">
                  <span>No</span>
                </label>
              </div>
            </div>

            <div class="col-md-4">
              <p class="cliente-radio-title mb-1">Autoretenedor ICA</p>
              <div class="cliente-radio-group">
                <label class="cliente-radio">
                  <input name="autoreica_natural" value="si" type="radio">
                  <span>Sí</span>
                </label>
                <label class="cliente-radio">
                  <input name="autoreica_natural" value="no" type="radio">
                  <span>No</span>
                </label>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>

    <!-- COLUMNA DERECHA -->
    <div class="col-lg-6">

      <!-- INFORMACIÓN DE CONTACTO -->
      <div class="cliente-card cliente-card-contacto h-100">
        <div class="cliente-card-header">
          <div class="cliente-pill pill-contacto"></div>
          <div>
            <h6 class="mb-0">Información de Contacto</h6>
            <small>Datos de ubicación y comunicación</small>
          </div>
        </div>

        <div class="cliente-card-body">

          <div class="row g-3">

            <div class="col-md-6">
              <label class="cliente-label">Teléfono</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-phone"></i>
                <input type="text"
                       id="telefono_cli"
                       name="telefono_cli"
                       class="form-control cliente-input"
                       placeholder="Número telefónico">
              </div>
            </div>

            <div class="col-md-6">
              <label class="cliente-label">Email</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-envelope"></i>
                <input type="email"
                       id="email_cli"
                       name="email_cli"
                       class="form-control cliente-input"
                       placeholder="Correo electrónico"
                       oninput="validarEmail(this)">
              </div>
            </div>

          </div>

          <div class="row g-3 mt-3">

            <div class="col-12">
              <label class="cliente-label">Dirección</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-map"></i>
                <input type="text"
                       id="direccion_cli"
                       name="direccion_cli"
                       class="form-control cliente-input"
                       placeholder="Dirección de residencia">
              </div>
            </div>

          </div>

          <div class="row g-3 mt-3">

            <div class="col-md-6">
              <label class="cliente-label">Departamento</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-current-location"></i>
                <select id="departamento" class="form-select cliente-input">
                  <option value="" disabled selected>Seleccione</option>
                  @foreach ($Departamentos as $dep)
                    <option value="{{$dep->id_depa}}">
                      {{$dep->nombre_depa}}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <label class="cliente-label">Ciudad</label>
              <div class="cliente-input-wrapper">
                <i class="cliente-icon bx bx-buildings"></i>
                <select id="ciudad" class="form-select cliente-input"></select>
              </div>
            </div>

          </div>

          <div class="cliente-hint mt-4">
            <i class="bx bx-info-circle me-1"></i>
            Verifica que los datos de contacto estén actualizados para evitar problemas en notificaciones.
          </div>

        </div>
      </div>

    </div>

  </div>
</div>
