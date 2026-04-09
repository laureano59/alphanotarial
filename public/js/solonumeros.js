function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57)
}


function soloNumerosdecimales(e){
	 var key = window.Event ? e.which : e.keyCode;

    // Números (0-9)
    if (key >= 48 && key <= 57) return true;

    // Punto (.)
    if (key === 46) return true;

    // Permitir borrar (backspace)
    if (key === 8) return true;

    return false;
}

