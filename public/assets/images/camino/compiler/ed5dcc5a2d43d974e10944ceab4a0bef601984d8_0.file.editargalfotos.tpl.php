<?php /* Smarty version 3.1.27, created on 2018-02-19 05:37:22
         compiled from "C:\wamp\www\camino\styles\templates\public\editargalfotos.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:94905a8a5482b1d129_76236723%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed5dcc5a2d43d974e10944ceab4a0bef601984d8' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\editargalfotos.tpl',
      1 => 1515826062,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '94905a8a5482b1d129_76236723',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a5482b53230_16504424',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a5482b53230_16504424')) {
function content_5a8a5482b53230_16504424 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '94905a8a5482b1d129_76236723';
?>
<div class="modal fade" id="editargalfotos" role="dialog">

   <div class="modal-dialog">

     <div class="modal-content">

       <div id="_AJAX_LOGIN_"></div>

          <div class="modal-header">

         <button type="button" class="close" data-dismiss="modal">&times;</button>

         <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span> Actualizar Fotos</h4>

       </div>

       <div class="modal-body">

        <form enctype="multipart/form-data" action="?view=actualizargalfoto" method="POST">

         <div class="form-group">

             <label for="idgalfoto"><span class="glyphicon glyphicon-user"></span> Escribir Id</label>

             <input type="text" required="" class="form-control" id="idgalfoto" name="idgalfoto" placeholder="Introducir el id de la foto que quiere actualizar">

           </div>

           <div class="form-group">

             <label for="descripcion"><span class="glyphicon glyphicon-user"></span> Elección de foto</label>

             <input name="foto" type="file"/>

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