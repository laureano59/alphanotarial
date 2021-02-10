{include 'overall/header.tpl'}
<link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpaneldecontrol.css" type="text/css">
<link rel="stylesheet" href="styles/css/selec-range.css">
</head>
<body>
{include 'overall/admin-nav.tpl'}

<br><br><br><br><br><br><br><center>
<h3 class="mbr-section-title display-2"><U>Actualización de los Textos</U></h3></center>
{if isset($smarty.get.error)}
  {if $smarty.get.error == '1'}
    <div class="alert alert-warning" role="alert" style="width: 500px">Textos Actualizados.</div>
  {/if}
{/if}
<div class="form-horizontal range-form">
  <div class="form-signin">
    <form action="?view=caption" method="POST">
      <legend>Textos del Head</legend>
      <label>Título Head <span style="color: #FF0000">*</span></label>
      <input style="margin-bottom: 10px;" type="text" class="form-control" name="titulo" id="titulo" placeholder="Escribir Título" required="" value="{$titulo}" />
      <label>Texto Head <span style="color: #FF0000">*</span></label>
      <textarea class="form-control" required="" id="texto" name="texto" placeholder="Escribir Contenido...">{$texto}</textarea>
        <br><br>
      <center><button class="btn btn-primary btn-block"  type="submit" id="submit" name="submit">Guardar Cambios</button></center>
    </form>
  </div>
</div>

  {include 'overall/footer.tpl'}
