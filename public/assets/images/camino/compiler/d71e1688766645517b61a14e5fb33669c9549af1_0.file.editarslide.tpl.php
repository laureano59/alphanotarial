<?php /* Smarty version 3.1.27, created on 2018-02-19 04:59:14
         compiled from "C:\wamp\www\camino\styles\templates\public\editarslide.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:274635a8a4b920dae50_56127587%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd71e1688766645517b61a14e5fb33669c9549af1' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\editarslide.tpl',
      1 => 1515826061,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '274635a8a4b920dae50_56127587',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a4b921200c7_25420915',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a4b921200c7_25420915')) {
function content_5a8a4b921200c7_25420915 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '274635a8a4b920dae50_56127587';
?>
<div class="modal fade" id="editarslide" role="dialog">

   <div class="modal-dialog">

     <div class="modal-content">

       <div id="_AJAX_LOGIN_"></div>

          <div class="modal-header">

         <button type="button" class="close" data-dismiss="modal">&times;</button>

         <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span> Editar Slide</h4>

       </div>

       <div class="modal-body">

        <form action="?view=editarslide" method="POST">

         <div class="form-group">

             <label for="idslide"><span class="glyphicon glyphicon-user"></span> Escribir Id</label>

             <input type="text" required="" class="form-control" id="idslide" name="idslide" placeholder="Introducir el id qu quiere tratar">

           </div>

           <div class="form-group">

             <label for="titulo"><span class="glyphicon glyphicon-user"></span> Título sobre la foto</label>

             <input type="text" class="form-control" id="titulo_slide" name="titulo_slide" placeholder="Introducir Nuevo Título">

           </div>

           <div class="form-group">

             <label for="texto"><span class="glyphicon glyphicon-user"></span> Texto sobre la foto</label>

             <input type="text" class="form-control" id="texto_slide" name="texto_slide" placeholder="Introducir Nuevo Texto">

           </div>

           <div class="form-group">

             <label for="texto"><span class="glyphicon glyphicon-user"></span> Color de Opacidad</label>

             <input type="color" id="colorslide" name="colorslide">

           </div>

           <div class="form-group">

             <label for="texto"><span class="glyphicon glyphicon-user"></span> Opacidad</label>

             <input class="range-slider__range" type="range" id="opacidad" name="opacidad" min="0" max="1" step="0.1">

             <span class="range-slider__value">1</span>

           </div>

           <input type="submit" value="Guardar Cambios" name="submit" style="width: 300px;" />

         </form>

          </div>

       <div class="modal-footer">

         <button type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>

        </div>

     </div>

   </div>

 </div>

<?php }
}
?>