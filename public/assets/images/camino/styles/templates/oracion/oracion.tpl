{include 'overall/header.tpl'}
<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionaloracion.css" type="text/css">
</head>
<body>
{include 'overall/nav.tpl'}
<br><br>

<section class="mbr-section form1 cid-qJyAccVNVG" id="form1-y">
  <div class="container">
    <div class="row justify-content-center">
      <div class="title col-12 col-lg-8">
        <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">ORAMOS POR TU NECESIDAD</h2>
        <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-7">No se inquieten por nada; más bien, en toda ocasión, con oración y ruego, presenten sus peticiones a Dios y denle gracias. Filipenses 4:6</h3>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <form action="?view=peticion" method="post" data-form-title="Petición de Oración por la Página Web">
        <div class="row row-sm-offset">
          <div class="col-md-4 multi-horizontal" data-for="name">
            <div class="form-group">
              <label class="form-control-label mbr-fonts-style display-7" for="name-form1-y">Nombre</label>
                <input type="text" class="form-control" name="name" data-form-field="Name" required="" id="name-form1-y">
            </div>
          </div>
          <div class="col-md-4 multi-horizontal" data-for="email">
            <div class="form-group">
              <label class="form-control-label mbr-fonts-style display-7" for="email-form1-y">Email</label>
                <input type="email" class="form-control" name="email" data-form-field="Email" required="" id="email-form1-y">
            </div>
          </div>
          <div class="col-md-4 multi-horizontal" data-for="phone">
            <div class="form-group">
              <label class="form-control-label mbr-fonts-style display-7" for="phone-form1-y">Móvil</label>
                <input type="tel" class="form-control" name="phone" data-form-field="Phone" id="phone-form1-y">
            </div>
          </div>
        </div>
        <div class="form-group" data-for="message">
          <label class="form-control-label mbr-fonts-style display-7" for="message-form1-y">Petición de Oración</label>
            <textarea type="text" class="form-control" name="message" rows="7" data-form-field="Message" id="message-form1-y"></textarea>
        </div>
        <span class="input-group-btn">
          <input type="submit" class="btn btn-primary btn-form display-4" value="ENVIAR PETICIÓN" name="submit"/>
        </span>
      </form>
    </div>
  </div>
</section>

{include 'overall/footer.tpl'}
