{include 'overall/header.tpl'}
<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">
</head>
<body>
{include 'overall/admin-nav.tpl'}

<br><br><br><br><br><br><br><center>
<h3 class="mbr-section-title display-2"><U>Galería de Fotos</U></h3></center>
{if isset($smarty.get.error)}
  {if $smarty.get.error == '1'}
    <div class="alert alert-success" role="alert" style="width: 500px">Actualización Realizada</div>
  {/if}
  {if $smarty.get.error == '2'}
    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el id de la foto</div>
  {/if}
  {if $smarty.get.error == '3'}
    <div class="alert alert-danger" role="alert" style="width: 500px">La foto debe ser un formato  (  jpg,  JPG, png, PNG, gif, GIF  ).</div>
  {/if}
  {if $smarty.get.error == '4'}
    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el archivo</div>
  {/if}
{/if}
<br>
<div class="form-horizontal range-form">
  <div class="form-signin">
    <form action="?view=gal" method="POST">
      <legend>Títulos del Módulo</legend>
      <label>Nombre del Módulo <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 10px;" type="text" class="form-control" name="titulo" id="titulo" placeholder="Escribir Nombre del Módulo" required="" value="{$titulo}" />
      <label>Descripción del Módulo <span style="color: #FF0000">*</span></label>
      <textarea class="form-control" required="" id="descripcion" name="descripcion" placeholder="Escribir descripcion...">{$descripcion}</textarea>
      <br>
      <center><button class="btn btn-primary btn-block"  type="submit" id="submit" name="submit">Guardar Cambios</button></center>
    </form>
  </div>
</div>

<hr><br>
<center>
  <div class="table-responsive">
    <div id="resultado" class="alert alert-warning" role="alert" style="width: 980px"></div>
    <table class="table table-striped table-hover" style="width: 50%;">
      <thead>
        <tr>
          <th style="width: 5%;">Id</th>
            <th style="width: 7%;">Foto</th>
            <th style="width: 5%;">Editar</th>
          </tr>
                </thead>
              <tbody>
          {if isset($gal)}
            {foreach from=$gal item=gl}
              <tr>
                <td>{$gl.id}</td>
                <td><img src="uploads/gal/{$gl.id}.{$gl.ext}" width="60" height="40"></td>
                <td style="text-align: center;"><a class="mbr-buttons__link btn text-white" data-toggle="modal" data-target="#editargalfotos"><img src="styles/image/editar.png"></a></td>
              </tr>
            {/foreach}
           {else}
              <tr>
                <td colspan="4">No hay archivos para mostrar</td>
              </tr>
          {/if}
              </tbody>
            </table>
        </div>
</center>

<hr>
  {include 'overall/footer.tpl'}
  {include 'public/editargalfotos.tpl'}

  <script>
  function pasarparametros(valor){

          var parametros = {
                  "idaudio" : valor,
          };
          $.ajax({
                  data:  parametros,
                  url:   '?view=borraraudio',
                  type:  'post',
                  beforeSend: function () {
                          $("#resultado").html("Procesando, espere por favor...");
                  },
                  success:  function (response) {
                          $("#resultado").html(response);
                          location.href ="?view=audios";
                  }
          });
  }
  </script>
