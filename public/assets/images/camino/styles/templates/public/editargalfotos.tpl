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
