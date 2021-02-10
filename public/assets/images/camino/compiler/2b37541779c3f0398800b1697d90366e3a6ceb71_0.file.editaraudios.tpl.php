<?php /* Smarty version 3.1.27, created on 2018-02-19 05:40:22
         compiled from "C:\wamp\www\camino\styles\templates\public\editaraudios.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:79045a8a5536685215_62804013%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b37541779c3f0398800b1697d90366e3a6ceb71' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\public\\editaraudios.tpl',
      1 => 1515826062,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '79045a8a5536685215_62804013',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a55366ffa39_28577512',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a55366ffa39_28577512')) {
function content_5a8a55366ffa39_28577512 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '79045a8a5536685215_62804013';
?>
<div class="modal fade" id="editaraudios" role="dialog">

   <div class="modal-dialog">

     <div class="modal-content">

       <div id="_AJAX_LOGIN_"></div>

          <div class="modal-header">

         <button type="button" class="close" data-dismiss="modal">&times;</button>

         <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span> Editar Audios</h4>

       </div>

       <div class="modal-body">

        <form action="?view=editaraudios" method="POST">

         <div class="form-group">

             <label for="idaudio"><span class="glyphicon glyphicon-user"></span> Escribir Id</label>

             <input type="text" required="" class="form-control" id="idaudio" name="idaudio" placeholder="Introducir el id que quiere tratar">

           </div>

           <div class="form-group">

             <label for="descripcion"><span class="glyphicon glyphicon-user"></span> Descripción del Audio que quiere mostrar</label>

             <input type="text" required="" class="form-control" id="descripcion" name="descripcion" placeholder="Introducir Nueva Descripción">

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