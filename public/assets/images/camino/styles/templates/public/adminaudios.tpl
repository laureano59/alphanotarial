{include 'overall/header.tpl'}
<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">
</head>
<body>
{include 'overall/admin-nav.tpl'}

<br><br><br><br><br><br><br><center>
<h3 class="mbr-section-title display-2"><U>Agregar Prédicas y Audios</U></h3></center>
<br><br>
{if isset($smarty.get.error)}
  {if $smarty.get.error == '1'}
    <div class="alert alert-success" role="alert" style="width: 500px">Descripción Actualizada</div>
  {/if}
  {if $smarty.get.error == '2'}
    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el id del audio</div>
  {/if}
  {if $smarty.get.error == '3'}
    <div class="alert alert-success" role="alert" style="width: 500px">Audio Eliminado</div>
  {/if}
  {if $smarty.get.error == '4'}
    <div class="alert alert-success" role="alert" style="width: 500px">Carga Exitosa</div>
  {/if}
  {if $smarty.get.error == '5'}
    <div class="alert alert-danger" role="alert" style="width: 500px">El audio debe ser un formato  (  mp3,  MP3  ).</div>
  {/if}
  {if $smarty.get.error == '6'}
    <div class="alert alert-danger" role="alert" style="width: 500px">No se ha seleccionado el archivo</div>
  {/if}
{/if}

<div class="form-horizontal range-form">
  <div class="form-signin">
    <form enctype="multipart/form-data" action="?view=cargarpredica" method="POST">
      <label>Descripción Prédica <span style="color: #FF0000">*</span></label>
      <input type="text" required=""  class="form-control" id="descripcion" name="descripcion" placeholder="Escribir descripción">
      <label>Cargar Archivo de Audio <span style="color: #FF0000">*</span></label>
        <input name="audio" type="file"/>
        <br><br>
      <center><input type="submit" value="Cargar Audio" name="submit" style="width: 300px;" /></center>
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
            <th style="width: 50%;">Descripción Audio</th>
            <th style="width: 10%;">Ext</th>
            <th style="width: 5%;">Eliminar</th>
            <th style="width: 5%;">Editar</th>
          </tr>
                </thead>
              <tbody>
          {if isset($audios)}
            {foreach from=$audios item=au}
              <tr>
                <td>{$au.idaudio}</td>
                <td>{$au.descripcion}</td>
                <td>{$au.ext}</td>
                <input type='hidden' name='id_cliente' value='".$fila["id_cliente"]."'>
                <td style="text-align: center;"><a href="#" onclick="pasarparametros({$au.idaudio});return false;"><img src="styles/image/delete.png"></a></td>
                <td style="text-align: center;"><a class="mbr-buttons__link btn text-white" data-toggle="modal" value="{$au.idaudio}" data-target="#editaraudios"><img src="styles/image/editar.png"></a></td>
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
  {include 'public/editaraudios.tpl'}

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
