$("#guardarcambios").click(function(){
	const checkboxes = document.querySelectorAll('input[name="reportes[]"]:checked');
    const valoresSeleccionados = Array.from(checkboxes).map(cb => cb.value);
    const id_user = $("#id_usuario").val();

    console.log("Valores seleccionados:", valoresSeleccionados);
    console.log("id usuario:", id_user);

    var route = "/panelroles/" + id_user;
    var token = $("#token").val();
    var type = 'PUT';
    var datos = {
        "roles": valoresSeleccionados
    };

    __ajax(route, token, type, datos)
    .done( function( info ){
        if(info.validar == 1){
            $("#msj1").html(info.mensaje);
            $("#msj-error1").fadeIn();
            setTimeout(function() {
                $("#msj-error1").fadeOut();
            }, 3000);
        }
    })   

    

});


document.getElementById('id_usuario').addEventListener('change', function() {
    let id_user = this.value; // Obtiene el valor seleccionado   
    var route = "/cargarroles";
    var token = $("#token").val();
    var type = 'GET';
    var datos = {
        "id_user": id_user
    };

    __ajax(route, token, type, datos)
    .done( function( info ){
        if(info.validar == 1){            
            $("#botonguardarcambios").fadeIn();
            var RolesUsers = info.RolUsers;
            CargarRoles(RolesUsers);
            
        }
    })   
   
});

function CargarRoles(data){

    for (let i = 1; i <= 59; i++) {
        let checkbox = document.getElementById(i);
        if (checkbox) {
            checkbox.checked = false;
        }
    }

    for (let item in data) {
        let roleId = data[item].role_id;
        let checkbox = document.getElementById(roleId);
        if (checkbox) {
            checkbox.checked = true;
        }
        }
}

