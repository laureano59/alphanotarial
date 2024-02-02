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
