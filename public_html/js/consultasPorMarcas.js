function seleccionaConsulta(objeto) {
	var marca = document.getElementById("marca");
	var tipo = document.getElementById("tipo");
	var campo = document.getElementById("pedido");
	var ok = true;

	if(marca === null) marca = "";
	if(tipo === null) tipo = "";
	if(campo === null) campo = "";
				
	if(campo == "") ok = false;							
		
	if(tipo != "") ok = false;

	if(marca.value == "") {
		ok = false;
	}
	
	if((marca.value == "Hyundai") && (tipo.value == "3")){
		alert("Para la marca \"" + marca.value.toUpperCase() + 
				"\" no puede seleccionar el tipo de pedido\n\t\t\t\t\"VOR UK\".");
		ok = false;
	}

	if((marca.value == "Chevrolet") && (tipo.value == "3")){
		alert("Para la marca \"" + marca.value.toUpperCase() + 
				"\" no puede seleccionar el tipo de pedido\n\t\t\t\t\"VOR UK\".");
		ok = false;
	}

	if((marca.value == "Mazda") && (tipo.value == "3")){
		alert("Para la marca \"" + marca.value.toUpperCase() + 
				"\" no puede seleccionar el tipo de pedido\n\t\t\t\t\"VOR UK\".");
		ok = false;
	}

	if((marca.value == "Peugeot") && (tipo.value == "3")){
		alert("Para la marca \"" + marca.value.toUpperCase() + 
				"\" no puede seleccionar el tipo de pedido\n\t\t\t\t\"VOR UK\".");
		ok = false;
	}

	if((marca.value == "Rover") && (tipo.value == "3")){
		alert("Para la marca \"" + marca.value.toUpperCase() + 
				"\" no puede seleccionar el tipo de pedido\n\t\t\t\t\"VOR UK\".");
		ok = false;
	}

	return ok;
}
