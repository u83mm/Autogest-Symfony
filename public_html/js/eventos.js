"use strict";

var $ = function(id) {
	return document.getElementById(id);
}

function salir() {
	if(confirm("Está a punto de salir de la aplicación. \n¿Estás seguro?")) {
		return true;
	}
	else {
		return false;
	}
}

// Comprueba valores del campo "Sección" y lo muestra en "muestraRegistro.php"
function comprueba_seccion() {
	var seccion = document.getElementsByName("seccion");
	if(seccion[0].value == 1) {
		seccion[0].checked = true;
		seccion[1].checked = false;
	}
	else {
		seccion[1].checked = true;
		seccion[0].checked = false;
	}
	seccion[0].value = 1;
	seccion[1].value = 2;
}

// Comprueba valores del campo "stock"
function comprueba_stock() {
	var stock = document.getElementsByClassName("stock");
	var textbox = document.getElementsByClassName("color");
	var i, x = 0;

	for(i = 0; i < stock.length; i++) {
		if(stock[i].checked == true) {
			stock[i].value = 1;
			for(x = 0; x < 7; x++) {
				textbox[(i * 7) + x].style.backgroundColor="lightgreen";
			}
		}
		else {
			stock[i].value = 0;
			for(x = 0; x < 7; x++) {
				textbox[(i * 7) + x].style.backgroundColor="white";						
			}			
		}
	}
}

// Comprueba checkbox en "muestra_registro.php" de los pedidos de clientes
var comprueba_check = function() {
	var check = document.getElementsByClassName("stock");
	var i = 0;

	for(i = 0; i < check.length; i++) {
		if(check[i].value == 0) {
			check[i].checked = false;
		}
		else {
			check[i].checked = true;
		}
	}
}

/*$(document).ready(function() {
	$("#username").focus(); //Pone el foco en el campo "usuario" en el formulario de inicio
	//$("#empresa").focus();

	//Valida el formulario de registro
	$("#createUser").validate({
		rules: {
			password: {
				minlength: 6
			},
			confirm_password: {
				minlength: 6,
				equalTo: "#password"
			}
		},
		messages: {
			first_name: {
				required: "Introduzca su nombre"
			},
			last_name1: {
				required: "Introduzca su apellido"
			},
			last_name2: {
				required: "Introduzca su apellido"
			},
			email: {
				required: "Introduzca un email"
			},
			user_name: {
				required: "Introduzca un usuario"
			},
			password: {
				required: "Introduzca una contraseña",
				minlength: "Mínimo 6 caracteres"
			},
			confirm_password: {
				required: "Introduzca una contraseña",
				minlength: "Mínimo 6 caracteres",
				equalTo: "Las contraseñas no coinciden"
			}
		}
	}); // end validate formulario registro
}); //end ready

// Valida formulario pedidos de taller
function validaPedidosTaller() {
	$("#pedidosForm").validate({
		messages: {
			marca: {
				required: "Elige una marca"
			},
			tipo: {
				required: "Especifica tipo de pedido"
			},
			fecha: {
				required: "Debes especificar una fecha"
			},
			referencia: {
				required: "No has puesto la referencia"
			},
			descripcion: {
				required: "¿qué quieres pedir?"
			},
			cantidad: {
				required: "Especifica una cantidad"
			},
			or: {
				required: "Anota la O.R"
			},
			operario: {
				required: "No olvides el operario"
			},
			estado: {
				required: "Selecciona una opción"
			},
			pedido: {
				required: "Introduce nº de pedido"
			},
			//También valida campos para formulario de pedidos de clientes
			empresa: {
				required: "Nombre de la empresa"
			},
			contacto: {
				required: "Introduce datos del cliente"
			}, 
			tfno: {
				required: "Telefono"
			},
			bastidor: {
				required: "Introduce el bastidor"
			},
			localidad: {
				required: "¿Localidad?"
			},
			cif: {
				required: "Introduce el C.I.F"
			},
			//Valida campo en formulario de consulta general de clientes
			campo: {
				required: "Selecciona opción"
			}
		}
	}); // end validate formulario pedidos taller

	$("#numPedido").validate({
		messages: {
			pedido: {
				required: "Introduce nº de pedido"
			}	
		}
	});
	
}*/

function validaPedidos() {
	var marca = document.getElementById("marca");
	var marca_error = document.getElementById("marca_error");
	var tipo = document.getElementById("tipo");
	var tipo_error = document.getElementById("tipo_error");
	var estado = document.getElementById("estado");
	var estado_error = document.getElementById("estado_error");
	var campo = document.getElementById("campo");
	var campo_error = document.getElementById("campo_error");

	if(marca === null ) {
		marca = "";
		marca_error = "";
	}
	else {
		if(marca.value == "") {
		marca_error.innerHTML = "Elige una marca";
		}
		else {
			marca_error.innerHTML = "";
		}
	}
	
	if(tipo === null) {
		tipo = "";
		tipo_error = "";
	}
	else {
		if(tipo.value == "") {
		tipo_error.innerHTML = "Especifica tipo de pedido";
		}
		else {
			tipo_error.innerHTML = "";
		}
	}
	
	if(estado === null) {
		estado = "";
		estado_error = "";
	}
	else {
		if(estado.value == "") {
		estado_error.innerHTML = "Selecciona una opción";
		}
		else {
			estado_error.innerHTML = "";
		}
	}
	
	if(campo === null) {
		campo = "";
		campo_error = "";
	}
	else {
		if(campo.value == "" && campo != null) {
		campo_error.innerHTML = "Selecciona una opción";
		}
		else {
			campo_error.innerHTML = "";
		}
	}

	$("#numPedido").validate({
		messages: {
			pedido: {
				required: "Introduce nº de pedido"
			}	
		}
	});

	var ok = seleccionaConsulta();

	if(ok) {		
		// envía el formulario
		document.getElementById("pedidosForm").submit();
	}

	// recoge valores del formulario de consulta "consulta_general.php" o "consulta_general_clientes.php"
	var campo = document.getElementById("campo");
	var criterio = document.getElementById("criterio");
	var dpto = document.getElementById("dpto");

	// recoge valores del formulario de consulta "seleccionaConsulta.php" 
	var marca = document.getElementById("marca");
	var tipo = document.getElementById("tipo");
	var estado = document.getElementById("estado");

	// si los campos son null los convierte a una cadena vacía
	if(campo === null) campo = "";
	if(criterio === null) criterio = "";
	if(dpto === null) dpto = "";
	if(marca === null) marca = "";
	if(tipo === null) tipo = "";
	if(estado === null) estado = "";

	// comprueba campos para parar el envío de datos a través de la función consulta_general() y que 
	// la validación de los campos se pueda llevar a cabo
	if(campo != null && campo.value == "") return;
	if((marca != null && marca.value == "") || (tipo != null && tipo.value == "") || (estado != null && estado.value == "")) return;

	// aborta AJAX para solucionar problema en "formulario_crea_marcas.php" al crear una marca nueva
	var stopAjax = document.getElementById("stop_ajax");
	if(stopAjax) return;

	// pasa los valores a la función "consulta_general" de ajax.js
	consulta_general(campo, criterio, marca, tipo, estado, dpto);
}
	
// Valida el campo cantidad
function validaCantidad(objeto){
	cantidad = document.getElementById("cantidad");
	if(cantidad.value != ""){
		if(/[^0-9]/.test(cantidad.value)){
			alert("Sólo puede introducir números.");
			cantidad.value = "";
		}
	}
}

// Valida el campo O.R
function validaOr(objeto){
	var or = document.getElementById("or");
	if(or.value != ""){
		if(/[^0-9]/.test(or.value)){
			alert("Sólo puede introducir números.");
			or.value = "";
		}
	}
}	

// Regresa al campo "Cantidad" después de haberlo validado
function regresaCantidad() {
	if(cantidad.value == "") {
		cantidad.focus();
	}
}

// Regresa al campo "O.R" después de haberlo validado
function regresaOr() {
	if(or.value == "") {
		or.focus();
	}
}

// Crea calendario para formulario de pedidos de taller
function datepicker() {
	$("#fecha").datepicker({
		monthNames: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
		changeMonth: true,
		changeYear: true,
		yearRange: "-120: +0",
		dateFormat: "dd/mm/yy",
		minDate: 0
	}); // end datepicker
}

//Desbloquea los campos de tipo texto para editar el contenido
function habilita_campos() {
	var input = document.getElementsByClassName("habShowUserEdit");
	var i = 0;
	var x = document.getElementsByName("password");
	var y = document.getElementsByName("confirm_password");
	var eliminaFoto = document.getElementById("eliminaFoto");
	var changePasswd = document.getElementById("change_passwd");

	if(input[i].disabled == true){
		document.getElementById("edita").value = "Finalizar";
		document.getElementById("actualiza").hidden = false;
		document.getElementById("resetea").hidden = false;
		if(eliminaFoto) eliminaFoto.hidden = false;
		if(changePasswd) changePasswd.hidden = false;
		for(var i = 0; i < input.length; i++) {
				input[i].disabled=false;
		}
	}else {
		document.getElementById("edita").value = "Editar";
		document.getElementById("actualiza").hidden = true;
		document.getElementById("resetea").hidden = true;
		if(eliminaFoto) eliminaFoto.hidden = true;
		if(changePasswd) changePasswd.hidden = true;
		for(i = 0; i < input.length; i++) {
				input[i].disabled=true;
		}
	}

	if(x[0]) {
		if(x[0].disabled == false && y[0].disabled == false) {
			x[0].disabled = true;
			y[0].disabled = true;
		}
	}	
}

//Habilita campo password
function habilita_password() {
	var x = document.getElementsByName("password");
	var y = document.getElementsByName("confirm_password");
	if(x[0].disabled == true && y[0].disabled == true) {
		x[0].disabled = false;
		y[0].disabled = false;
	}
	else {
		x[0].disabled = true;
		y[0].disabled = true;
	}
}

//Pone en mayúsculas el texto de los campos del formulario pedidos taller
function mayusculas() {
	var datos = document.getElementsByClassName("habShowUserEdit pTaller");
	for (var i = 0; i < datos.length; i++) {
		datos[i].value = datos[i].value.toUpperCase();
	}
}

//Pone en mayúsculas el texto de los campos del formulario pedidos cliente
function mayusculas_text() {	
	var datos = document.getElementsByClassName("mayusculas");
	for (var i = 0; i < datos.length; i++) {
		datos[i].value = datos[i].value.toUpperCase();		 
	}
}

//Pone en mayúsculas el texto de los campos del formulario "Nuevo Pedido de Call Center"
function mayusculas_clientes() {	
	var datos = document.getElementsByClassName("clientes");
	for (var i = 0; i < datos.length; i++) {
		datos[i].value = datos[i].value.toUpperCase();		 
	}	
}

//Avisa de que todos los registros van a ser modificados
function avisoTodos() {
	if(confirm("Algunos registros van a ser modificados.\n¿Quiere continuar?")) {
		return true;
	}
	else {
		return false;	
	}
}

//Agrega línea en formulario de "Nuevo Pedido de clientes"
function agrega_linea() {
	var elementos = document.getElementsByClassName("descripcion");

	//crea campo de tipo "text" para descripción
	var inputext = document.createElement("input"); //crea etiqueta de tipo input
	inputext.setAttribute("type", "text"); //Añade atributo de tipo texto a la etiqueta input
	inputext.setAttribute("id", "descripcion" + elementos.length);
	inputext.setAttribute("name", "descripcion" + elementos.length);
	inputext.setAttribute("onblur", "mayusculas_clientes()");
	inputext.setAttribute("size", "34");
	inputext.setAttribute("class", "color descripcion margen clientes"); //Añade clase "descripcion" a la etiqueta input

	var linea = document.getElementById("agregaLinea"); // Llama al elemento dónde insertar las etiquetas
	var salto = document.createElement("br"); //Crea una etiqueta de salto de línea	

	//crea campo de tipo "text" para referencia
	var inputext1 = document.createElement("input"); //crea etiqueta de tipo input
	inputext1.setAttribute("type", "text"); //Añade atributo de tipo texto a la etiqueta input
	inputext1.setAttribute("id", "referencia" + elementos.length);
	inputext1.setAttribute("name", "referencia" + elementos.length);
	inputext1.setAttribute("onblur", "buscaDatos(event, this);");
	inputext1.setAttribute("onkeypress", "buscaDatos(event, this)");
	inputext1.setAttribute("onmousedown", "buscaDatos(event, this)");
	inputext1.setAttribute("class", "color clientes showInDesktop");
	inputext1.setAttribute("size", "15");

	//crea campo de tipo "text" para cantidad
	var inputext2 = document.createElement("input"); //crea etiqueta de tipo input
	inputext2.setAttribute("type", "text"); //Añade atributo de tipo texto a la etiqueta input
	inputext2.setAttribute("id", "cantidad" + elementos.length);
	inputext2.setAttribute("name", "cantidad" + elementos.length);
	inputext2.setAttribute("onblur", "buscaDatos(event, this);");
	inputext2.setAttribute("onkeypress", "buscaDatos(event, this);");
	inputext2.setAttribute("class", "color cantidad margen");
	inputext2.setAttribute("size", "4");
	

	//crea campo de tipo "text" para precio
	var inputext3 = document.createElement("input"); //crea etiqueta de tipo input
	inputext3.setAttribute("type", "text"); //Añade atributo de tipo texto a la etiqueta input
	inputext3.setAttribute("id", "precio" + elementos.length);
	inputext3.setAttribute("name", "precio" + elementos.length);
	inputext3.setAttribute("class", "color margen4 clientes");
	inputext3.setAttribute("readonly", 1);
	inputext3.setAttribute("size", "6");

	//crea campo de tipo "text" para dto
	var inputext4 = document.createElement("input"); //crea etiqueta de tipo input
	inputext4.setAttribute("type", "text"); //Añade atributo de tipo texto a la etiqueta input
	inputext4.setAttribute("id", "dto" + elementos.length);
	inputext4.setAttribute("name", "dto" + elementos.length);
	inputext4	.setAttribute("onblur", "buscaDatos(event, this);");
	inputext4.setAttribute("onkeypress", "consultaReferencias(event, this);");
	inputext4.setAttribute("class", "color margen clientes dto");
	inputext4.setAttribute("size", "4");

	//crea campo de tipo "text" para neto
	var inputext5 = document.createElement("input"); //crea etiqueta de tipo input
	inputext5.setAttribute("type", "text"); //Añade atributo de tipo texto a la etiqueta input
	inputext5.setAttribute("id", "neto" + elementos.length);
	inputext5.setAttribute("name", "neto" + elementos.length);
	inputext5.setAttribute("onkeypress", "consultaReferencias(event, this);");
	inputext5.setAttribute("class", "color margen clientes");
	inputext5.setAttribute("readonly", 1);
	inputext5.setAttribute("size", "6");

	//crea campo de tipo "text" para stock
	var inputext6 = document.createElement("input"); //crea etiqueta de tipo input
	inputext6.setAttribute("type", "text"); //Añade atributo de tipo texto a la etiqueta input
	inputext6.setAttribute("id", "instock" + elementos.length);
	inputext6.setAttribute("name", "instock" + elementos.length);
	inputext6.setAttribute("onkeypress", "consultaReferencias(event, this);");
	inputext6.setAttribute("class", "color margen clientes");
	inputext6.setAttribute("readonly", 1);
	inputext6.setAttribute("size", "6");

	/*var label4 = document.createElement("label"); //crea etiqueta para crear espacio entre el campo de texto "precio" y el checkbox para la versión responsive
	var textLabel4 = document.createTextNode("");
	label4.appendChild(textLabel4);	
	label4.setAttribute("class", "newOrderRowsCheck");*/	

	//crea checkbox
	var checkbox = document.createElement("input"); //Crea etiqueta para el checkbox
	checkbox.setAttribute("type", "checkbox"); //Añade atributo de tipo checkbox al input
	checkbox.setAttribute("id", "stock" + elementos.length); // Añade atributo id al input
	checkbox.setAttribute("name", "stock" + elementos.length); // Añade atributo name al input
	checkbox.setAttribute("class", "stock margen5");
	checkbox.setAttribute("value", "0");
	checkbox.setAttribute("onclick", "comprueba_stock()");

	var br = document.createElement("br");
	br.setAttribute("class", "showInMovil");

	var br1 = document.createElement("br");
	br1.setAttribute("class", "showInMovil");

	linea.appendChild(inputext1);
	linea.appendChild(inputext);
	linea.appendChild(br);
	linea.appendChild(inputext2);
	linea.appendChild(inputext3);
	linea.appendChild(inputext4);
	linea.appendChild(inputext5);
	linea.appendChild(inputext6);
	//linea.appendChild(label4);
	linea.appendChild(checkbox);
	linea.appendChild(salto);
	linea.appendChild(br1);
}


function guardar() {
	document.getElementById("date").disabled=false;
}

//función que elimina un registro de la tabla al hacer click en "borrar"
function delete_record(id, cadena) {
	if(confirm("¿Estás seguro de querer eliminar este registro? " + "\nNo podrá deshacer los cambios!")) {
		if(arguments.length != 2) {
			alert("Faltan parámetros para poder llevar a cabo la acción\nPóngase en contacto " + 
					"con el servicio de Atención al Cliente.");
		}

		if(cadena == "cliente") {
			window.location = "/scripts/clientes/delete_record_clientes.php?pedido_id=" + id;
		}

		if(cadena == "taller") {
			window.location = "/scripts/delete_record.php?pedido_id=" + id;
		}
	}
}

//pone filas impares en gris en la tabla "registros" en /spare_parts/view/inputs.php
function odd () {
	var marca = document.getElementsByClassName("marca");
	var ref = document.getElementsByClassName("ref");
	var descr = document.getElementsByClassName("descr");
	var cantidad = document.getElementsByClassName("cantidad");
	var dto = document.getElementsByClassName("dto");
	var pvp = document.getElementsByClassName("pvp");
	var pCompra = document.getElementsByClassName("p_compra");
	var total = document.getElementsByClassName("total");

	if(marca && marca != null) {
		for( var i = 0; i < marca.length; i++) {
			marca[i].onfocus = function() {this.style.background = "#e8d854";} //background amarillo

			if(i % 2 != 0) {
				marca[i].style.background = "#dcd9d7"; //background gris clarito					
				ref[i].style.background = "#dcd9d7"; //background gris clarito					
				descr[i].style.background = "#dcd9d7"; //background gris clarito	
				descr[i].onfocus = function() {this.style.background = "#e8d854";} //background amarillo
				descr[i].onblur = function() {this.style.background = "#dcd9d7";}
				cantidad[i].style.background = "#dcd9d7"; //background gris clarito	
				cantidad[i].onfocus = function() {this.style.background = "#e8d854";} //background amarillo				
				dto[i].style.background = "#dcd9d7"; //background gris clarito	
				dto[i].onfocus = function() {this.style.background = "#e8d854";} //background amarillo				
				pvp[i].style.background = "#dcd9d7"; //background gris clarito	
				pvp[i].onfocus = function() {this.style.background = "#e8d854";} //background amarillo
				pvp[i].onblur = function() {this.style.background = "#dcd9d7";}
				pCompra[i].style.background = "#dcd9d7"; //background gris clarito	
				pCompra[i].onfocus = function() {this.style.background = "#e8d854";} //background amarillo
				pCompra[i].onblur = function() {this.style.background = "#dcd9d7";}
				total[i].style.background = "#dcd9d7"; //background gris clarito	
				total[i].onfocus = function() {this.style.background = "#e8d854";} //background amarillo
				total[i].onblur = function() {this.style.background = "#dcd9d7";}	
				
				// realiza llamadas a través de AJAX para mostrar datos en las celdas de la tabla
				marca[i].onblur = validate_marca;
				ref[i].onblur = showDates;				
				ref[i].onfocus = showDates;								
				//ref[i].onkeydown = showDatesPvp;
				cantidad[i].onblur = showNeto;					
				dto[i].onblur = showNeto;	
				//total[i].onkeypress = desbl_inputs;													
			}
			else {				
				marca[i].onblur = validate_marca;				
				ref[i].onblur = showDates;							
				//ref[i].onfocus = showDates;				
				//ref[i].onkeydown = showDatesPvp;	
				cantidad[i].onblur = showNeto;
				dto[i].onblur = showNeto;	
				//total[i].onkeypress = desbl_inputs;			
			}				
		}	
	}
}

// quita atributo "disabled" en "/spare_parts/view/inputs.php" y gestiona registros
function desbl_inputs() {	
	var div_registros = document.getElementById("registros");
	var inputsRegistros = div_registros.getElementsByTagName("input");
	var inputsDescr = div_registros.getElementsByClassName("descr");
	var inputsNeto = div_registros.getElementsByClassName("p_compra");		

	var y = 8; var count = 0;
	for (var x = 1; x <= y; x++) {	
		inputsRegistros[x-1].disabled = false;				

		if(inputsRegistros[x-1].value != "" && x == y) {
			x = x;
			y += 8;
			count++;		
		}
	}	
}

// calcula el total neto de un albarán y lo muestra al pie de la tabla
function total_alb() {
	var div_registros = document.getElementById("registros");
	var inputsTotal = div_registros.getElementsByClassName("total");	
	var totalNeto = 0;

	for(var i = 0; i < inputsTotal.length; i++) {
		if(inputsTotal[i].value != "") {			
			totalNeto += parseFloat(inputsTotal[i].value);						
		}		
	}
	document.getElementById("total_neto").innerHTML = parseFloat(totalNeto).toFixed(2);	
}

//	Valida datos de la tabla en entradas
function validate_marca() {
	//obtiene el índice del objeto para pasárselo al id del objeto 
	var str = this.id;
	var indice, indiceDecenas = "";
	
	//si el índice contiene decenas
	if(str.length > 6) {
		indice = str.charAt(str.length -2)
		indiceDecenas = str.charAt(str.length -1);
		indice += indiceDecenas;
	}
	else {
		indice = str.charAt(str.length -1);
	}				

	//si el campo está vacío
	if(this.value == "") {
		myAlert("El campo \"M\" no puede estar vacío", str, "");		
		var grey = "rgb(220, 217, 215)";
		
		if(this.style.backgroundColor == grey) {
			this.style.background = "#e8d854";
		}
		else {
			this.style.background = "#dcd9d7";
		}							
	}
	else if(isNaN(this.value) == true) {
		myAlert("El dato en campo \"M\" debe de ser numérico.", str, "");		
		this.value = "";
		if(this.style.backgroundColor == grey) {
			this.style.background = "#e8d854";
		}
		else {
			this.style.background = "#dcd9d7";
		}		
	}
	else {
		if(indice % 2 != 0) {
			this.style.background = "#dcd9d7";			
		}
		else {
			this.style.background = "#ffffff";
		}
	}		
}
	
// Muestra un alert personalizado
function myAlert(cadena, id, indice) {		
	//creamos los elementos necesarios para el modal
	var divMyModal = document.createElement("div");
	var divModalContent = document.createElement("div");
	var span = document.createElement("span");	
	var p = document.createElement("p");	
	var pContent = document.createTextNode(cadena);
	var button = document.createElement("button");
	var buttonText = document.createTextNode("cerrar");

	//añadimos atributos a los elementos
	divMyModal.setAttribute("id", "myModal");
	divMyModal.setAttribute("class", "modal");
	divModalContent.setAttribute("class", "modal-content");
	span.setAttribute("class", "close");
	//span.setAttribute("onclick", "removeAlert(" + indice + ");");
	span.setAttribute("onclick", "removeAlert(" + id + indice + ");");
	button.setAttribute("id", "Cerrar");
	//button.setAttribute("onclick", "removeAlert(" + indice + ");");
	button.setAttribute("onclick", "removeAlert(" + id + indice + ");");

	//añadimos cada elemento a su padre
	p.appendChild(pContent);	
	divModalContent.appendChild(span);
	divModalContent.appendChild(p);	
	divMyModal.appendChild(divModalContent);
	button.appendChild(buttonText);
	//buttonAceptar.appendChild(buttonTextAceptar);
	divModalContent.appendChild(button);
	var container = document.getElementById("contenedor");
	container.appendChild(divMyModal);		

	var times = document.getElementsByClassName("close");
	times[0].innerHTML = "&times;";

	document.getElementById("Cerrar").focus();	
}

// Cierra el alert
function removeAlert(indice) {
	var parent = document.getElementById("contenedor");	
	var divMyModal = document.getElementsByClassName("modal");
	for(var i = 0; i < divMyModal.length; i++) {
		parent.removeChild(divMyModal[i]);
	}	
	//document.getElementById("marca" + indice).focus();
	//document.getElementById("marca" + indice).style.background = "#e8d854";
	document.getElementById(indice.id).value = "";
	document.getElementById(indice.id).focus();
}

//cambia foco en los campos de texto con opción de "check" al hacer click sobre ellos
function cambiaFoco() {
	var changeFocus = document.getElementsByClassName("color");
	changeFocus[this.name].style.background = "#e8d854";
}

// Cambia el foco al salir del campo
function saleFoco() {
	var changeFocus = document.getElementsByClassName("color");
	var stock = document.getElementsByClassName("stock");
	var cadena = this.name;
	var indice = "";

	//busca un número en la "cadena" y lo añade a la variable "indice"
	for(var i = 0; i < cadena.length; i++) {
		if(!isNaN(cadena[i])) {
			indice += cadena[i].toString();
		}
	}

	if(indice.length === 0) indice = 0;

	if(stock[indice].checked == true) {
		changeFocus[this.name].style.background = "lightgreen";
	}
	else {
		changeFocus[this.name].style.background = "white";
	}

	var datos = document.getElementsByClassName("clientes");
	for (var i = 0; i < datos.length; i++) {
		datos[i].value = datos[i].value.toUpperCase();		 
	}

	// si la tecla pulsada es el tabulador o alguna otra que no tenga definido un event termina la función
	if(this.event === undefined) {
		return;
	}

	consultaReferencias(event, this);
}

// Valida campo "Contacto" del formulario "Nuevo Pedido de Call Center"
function clearContactError() {
	var contacto = document.getElementById("contacto");

	if(contacto.value != "") {
		document.getElementById("contact_error").innerHTML = "";
	}
	else {
		document.getElementById("contact_error").innerHTML = "Introduce una persona de contacto";
	}
}

// Envía formulario de "Nuevo Pedido de Call Center"
function enviaForm() {
	document.getElementById("pedidosForm").setAttribute("onsubmit", "return true");
	document.getElementById("pedidosForm").submit();
}

// Valida cualquier campo por su "id"
function validateFieldError(obj) {	
	if(this.value != "") {
		document.getElementById(this.id + "_error").innerHTML = "";
	}
	else {
		document.getElementById(this.id + "_error").innerHTML = "Debes rellenar este campo";
	}
}

// Delete row from "Datos del Pedido de Call Center"
function delete_row(pedidoId, descripcion, id) {
	var pedidoId = pedidoId;
	var descripcion = descripcion;
	var url = "/scripts/clientes/index.php?action=delete_row&&pedido_id=" + pedidoId + "&&descripcion=" + descripcion + "&&id=" + id;

	if(confirm("Está a punto de eliminar este registro. \r\r\t\t" + descripcion + "\r\r¿Quiere continuar?")) {
		location = url;
		return true;
	}
	else {
		return false;
	}	
}

// Función que habilita campos de datos del cliente en el formulario "Ficha del Cliente"
function tipoCliente (obj) {
	if(this.value == 1) {
		//cambia el atributo "readonly"
		document.getElementById("cif").focus();
		document.getElementById("razon_social").readOnly = false;
		document.getElementById("nombre").readOnly = true;
		document.getElementById("apellido1").readOnly = true;
		document.getElementById("apellido2").readOnly = true;

		//cambia el background color
		document.getElementById("nombre").style.background = "lightgray";
		document.getElementById("apellido1").style.background = "lightgray";
		document.getElementById("apellido2").style.background = "lightgray";
		document.getElementById("razon_social").style.background = "white";

		this.value = "";
		this.firstChild.nextSibling.innerHTML = "Razón Social";
	}
	if(this.value == 2) {
		document.getElementById("cif").focus();
		document.getElementById("nombre").readOnly = false;
		document.getElementById("apellido1").readOnly = false;
		document.getElementById("apellido2").readOnly = false;
		document.getElementById("razon_social").readOnly = true;

		document.getElementById("nombre").style.background = "white";
		document.getElementById("apellido1").style.background = "white";
		document.getElementById("apellido2").style.background = "white";
		document.getElementById("razon_social").style.background = "lightgray";
			
		this.value = "";
		this.firstChild.nextSibling.innerHTML = "Pers. Física";
	}
}

// Función que muestra abreviaciones de direcciones
function muestraAbrev() {
	document.getElementById("cliente_tipoVia").value = this.value;
}

// Función que ejecuta la cuenta atrás
var count = 60;

function reloj(){
	if(document.getElementById("segundos") != null) {
		document.getElementById("segundos").innerHTML = count;
		count--;
		if(count < 0) {window.location = "/logout";}
	}	
}

// Función que busca datos mediante AJAX en formulario de PEDIDOS DE CLIENTES al hacer enter
function buscaDatos(event, obj = null) {	
	//recoge el código ASCII de la tecla pulsada y el objeto que llama a la función
	var x = event;
	var object = this;
	if(!object) object = obj;

	mayusculas_clientes(); //pone en mayúsculas el contenido del campo

	//if(x.button === 0) return;
	//if(x.charCode === undefined) return;

	//si el código ASCII es 13 envía el evento y el objeto a la función "consultaReferencias"
	if(x.charCode === 13 || x.button === 0) consultaReferencias(x, object);
}

// Calcula el neto correspondiente en Pedido de Call Center al introducir el descuento
function showReferenceNeto() {
	// almacena el último caracter del id del objeto como índice
	var indice = this.id[this.id.length -1];		
	
	// si el índice necesario tiene que contener 2 dígitos (ej. 10), recalcula el índice. (17) es el número de carácteres correspondiente
	// a la longitud de la cadena "pedido_items_dto1"		
	if(this.id.length > 17) {
		indice = this.id[this.id.length -2] + this.id[this.id.length -1];
	}				
	
	if(indice >= 1) {
		var pvp = parseFloat($('pedido_items_precio' + indice).value).toFixed(2);
		var cantidad = parseFloat($('pedido_items_cantidad' + indice).value).toFixed(2);
		$('pedido_items_dto' + indice).value = parseFloat($('pedido_items_dto' + indice).value).toFixed(2);
		var dto = parseFloat($('pedido_items_dto' + indice).value);				
				
		var neto = pvp - (pvp * dto) / 100;
		
		neto *= cantidad;
		pvp *= cantidad;														
		
		if(cantidad == 0) {
			$('pedido_items_neto' + indice).value = cantidad;
		}
		else {
			$('pedido_items_neto' + indice).value = parseFloat(neto).toFixed(2);	
		}								
	}
	else {
		var pvp = parseFloat($('pedido_items_precio').value).toFixed(2);
		var cantidad = parseFloat($('pedido_items_cantidad').value).toFixed(2);
		$('pedido_items_dto').value = parseFloat($('pedido_items_dto').value).toFixed(2);
		var dto = parseFloat($('pedido_items_dto').value);
		
		pvp *= cantidad;
		var neto = pvp - (pvp * dto) / 100;																		
		
		if(cantidad == 0) {
			$('pedido_items_neto').value = cantidad;	
		}
		else {
			$('pedido_items_neto').value = parseFloat(neto).toFixed(2);	
		}					 		
	}
	
	// Comprueba si estamos en un pedido nuevo o editando uno existente
	var vista = document.getElementsByTagName('h2');
	if(vista[0].innerHTML.match(/editar/i)) {
		// Obtiene el nº de filas existentes en el detalle del pedido
		var filas = [];
		filas[0] = document.getElementById('pedido_items_descripcion');
		
		for(i = 1; i < 11; i++) {
			if(document.getElementById('pedido_items_descripcion' + i)) {
				filas[i] = document.getElementById('pedido_items_descripcion' + i);
			}					
		}
		
		// Calcula los totales
		var cantidad = document.getElementById('pedido_items_cantidad').value;
		var pvp = document.getElementById('pedido_items_precio').value;
		var dto = document.getElementById('pedido_items_dto').value;
		var neto = (pvp * cantidad) - (pvp * cantidad * dto / 100);					
		
		var totalPvp = pvp * cantidad;			
		var totalNeto = neto;
		//var totalDto = totalPvp - totalNeto;
		var totalIva = totalNeto * 21 / 100;							 
			
		for(i = 1; i < filas.length; i++) {
			cantidad = document.getElementById('pedido_items_cantidad' + i).value;
			pvp = document.getElementById('pedido_items_precio' + i).value;
			dto = document.getElementById('pedido_items_dto' + i).value;
			neto = (pvp * cantidad) - (pvp * cantidad * dto / 100);					
							
			totalNeto += neto;
			totalPvp += (pvp * cantidad);
			//totalDto = totalPvp - totalNeto;									
			totalIva = (totalNeto * 21 / 100);																																									
		}
		
		document.getElementById('pedido_items_totalPvp').value = parseFloat(totalPvp).toFixed(2);
		document.getElementById('pedido_items_totalNeto').value = parseFloat(totalNeto).toFixed(2);
		document.getElementById('pedido_items_totalDto').value = parseFloat(totalPvp - totalNeto).toFixed(2);
		document.getElementById('pedido_items_totalIva').value = parseFloat(totalIva).toFixed(2);
		document.getElementById('pedido_items_total').value = parseFloat(totalNeto + totalIva).toFixed(2);
	}
	else {
		var totalNeto = parseFloat(0).toFixed(2);
		var totalIva = parseFloat(0).toFixed(2);
		var totalDto = parseFloat(0).toFixed(2);
		var total = parseFloat(0).toFixed(2);
		
		for(var i = 1; i <= 10; i++) {
			if($('pedido_items_neto' + i).value != "") {			
				totalNeto = parseFloat(totalNeto) + parseFloat($('pedido_items_neto' + i).value);
			}		
		}
			
		totalNeto = parseFloat(totalNeto) + parseFloat($('pedido_items_neto').value);
		totalIva = (parseFloat(totalNeto) * 21) / 100;
		totalDto = $('pedido_items_totalPvp').value - parseFloat(totalNeto);
		total = parseFloat(totalNeto) + parseFloat(totalIva);			
			
		$('pedido_items_totalNeto').value = parseFloat(totalNeto).toFixed(2);
		$('pedido_items_totalIva').value = parseFloat(totalIva).toFixed(2);
		$('pedido_items_totalDto').value = parseFloat(totalDto).toFixed(2);
		$('pedido_items_total').value = parseFloat(total).toFixed(2);
	}		
}

// Calcula el neto correspondiente en Pedido de Call Center al introducir el precio
function showReferenceNetoByQuantity() {	
	// almacena el último caracter del id del objeto como índice
	var indice = this.id[this.id.length -1];			
	
	// si el índice necesario tiene que contener 2 dígitos (ej. 10), recalcula el índice. (22) es el número de carácteres correspondiente
	// a la longitud de la cadena "pedido_items_cantidad1"		
	if(this.id.length > 22) {
		indice = this.id[this.id.length -2] + this.id[this.id.length -1];
	}					
	
	if(indice >= 1) {
		var pvp = parseFloat($('pedido_items_precio' + indice).value).toFixed(2);
		
		// Si el campo PVP no contiene ningún valor inicializa a 0 precio, dto, neto y stock
		if(isNaN(pvp)) {
			pvp = parseFloat(0).toFixed(2);
			$('pedido_items_precio' + indice).value = pvp;
			$("pedido_items_dto" + indice).value = parseFloat(0).toFixed(2);
			$("pedido_items_neto" + indice).value = parseFloat(0).toFixed(2);																	
			$("pedido_items_stock" + indice).value = parseFloat(0).toFixed(2);
		}
		
		var cantidad = parseFloat($('pedido_items_cantidad' + indice).value).toFixed(2);
		$('pedido_items_dto' + indice).value = parseFloat($('pedido_items_dto' + indice).value).toFixed(2);
		var dto = parseFloat($('pedido_items_dto' + indice).value);
		
		var neto = pvp - (pvp * dto) / 100;
		
		neto *= cantidad;
		pvp *= cantidad;																	
		
		if(cantidad == 0) {
			$('pedido_items_neto' + indice).value = cantidad;			
		}
		else {
			$('pedido_items_neto' + indice).value = neto.toFixed(2);			
		}					
	}
	else {			
		var pvp = parseFloat($('pedido_items_precio').value).toFixed(2);
		
		// Si el campo PVP no contiene ningún valor inicializa a 0 precio, dto, neto y stock
		if(isNaN(pvp)) {
			pvp = parseFloat(0).toFixed(2);
			$('pedido_items_precio').value = parseFloat(0).toFixed(2);
			$("pedido_items_dto").value = parseFloat(0).toFixed(2);
			$("pedido_items_neto").value = parseFloat(0).toFixed(2);																		
			$("pedido_items_stock").value = parseFloat(0).toFixed(2);
		}
		
		var cantidad = parseFloat($('pedido_items_cantidad').value).toFixed(2);
		$('pedido_items_dto').value = parseFloat($('pedido_items_dto').value).toFixed(2);
		var dto = parseFloat($('pedido_items_dto').value);		
		
		var neto = pvp - (pvp * dto) / 100;
		pvp *= cantidad;
		neto *= cantidad;
			
		var totalPvp = pvp;
		var totalNeto = neto;					
		
		if(cantidad == 0) {
			$('pedido_items_neto').value = cantidad;	
		}
		else {
			$('pedido_items_neto').value = neto.toFixed(2);				
		}					 		
	}		
	
	// Comprueba si estamos en un pedido nuevo o editando uno existente
	var vista = document.getElementsByTagName('h2');
	if(vista[0].innerHTML.match(/editar/i)) {
		// Obtiene el nº de filas existentes en el detalle del pedido
		var filas = [];
		filas[0] = document.getElementById('pedido_items_descripcion');
		
		for(i = 1; i < 11; i++) {
			if(document.getElementById('pedido_items_descripcion' + i)) {
				filas[i] = document.getElementById('pedido_items_descripcion' + i);
			}					
		}
		
		// Calcula los totales
		var cantidad = document.getElementById('pedido_items_cantidad').value;
		var pvp = document.getElementById('pedido_items_precio').value;
		var dto = document.getElementById('pedido_items_dto').value;
		var neto = (pvp * cantidad) - (pvp * cantidad * dto / 100);					
		
		var totalPvp = pvp * cantidad;			
		var totalNeto = neto;
		//var totalDto = totalPvp - totalNeto;
		var totalIva = totalNeto * 21 / 100;							 
			
		for(i = 1; i < filas.length; i++) {
			cantidad = document.getElementById('pedido_items_cantidad' + i).value;
			pvp = document.getElementById('pedido_items_precio' + i).value;
			dto = document.getElementById('pedido_items_dto' + i).value;
			neto = (pvp * cantidad) - (pvp * cantidad * dto / 100);					
							
			totalNeto += neto;
			totalPvp += (pvp * cantidad);
			//totalDto = totalPvp - totalNeto;									
			totalIva = (totalNeto * 21 / 100);																																									
		}
		
		document.getElementById('pedido_items_totalPvp').value = parseFloat(totalPvp).toFixed(2);
		document.getElementById('pedido_items_totalNeto').value = parseFloat(totalNeto).toFixed(2);
		document.getElementById('pedido_items_totalDto').value = parseFloat(totalPvp - totalNeto).toFixed(2);
		document.getElementById('pedido_items_totalIva').value = parseFloat(totalIva).toFixed(2);
		document.getElementById('pedido_items_total').value = parseFloat(totalNeto + totalIva).toFixed(2);
	}
	else {
		var totalNeto = parseFloat(0).toFixed(2);
		var totalPvp = parseFloat(0).toFixed(2);
		var totalIva = parseFloat(0).toFixed(2);
		var totalDto = parseFloat(0).toFixed(2);
		var total = parseFloat(0).toFixed(2);
		
		for(var i = 1; i <= 10; i++) {
			if($('pedido_items_neto' + i).value != "") {
				totalNeto = parseFloat(totalNeto) + parseFloat($('pedido_items_neto' + i).value);
				totalPvp =	parseFloat(totalPvp) + parseFloat($('pedido_items_precio' + i).value) * $('pedido_items_cantidad' + i).value;
			}		
		}			
		
		totalNeto = parseFloat(totalNeto) + parseFloat($('pedido_items_neto').value);
		totalPvp = parseFloat(totalPvp) + parseFloat($('pedido_items_precio').value) * $('pedido_items_cantidad').value;
		totalIva = (parseFloat(totalNeto) * 21) / 100;
		totalDto = parseFloat(totalPvp) - parseFloat(totalNeto);			
		total = parseFloat(totalNeto) + parseFloat(totalIva);
		
		$('pedido_items_totalPvp').value = parseFloat(totalPvp).toFixed(2);
		$('pedido_items_totalNeto').value = parseFloat(totalNeto).toFixed(2);
		$('pedido_items_totalIva').value = parseFloat(totalIva).toFixed(2);
		$('pedido_items_totalDto').value = parseFloat(totalDto).toFixed(2);
		$('pedido_items_total').value = parseFloat(total).toFixed(2);
	}		
}

/*###########################################################################################
#						AQUÍ EMPIEZA EL window.onload										#
###########################################################################################*/

window.onload = function(){		
	// pone en mayúsculas los datos de los campos de texto con clase "mayusculas"
	var z = document.getElementsByClassName("mayusculas"); //Manejador semántico en array
	
	for(var i = 0; i < z.length; i++) {
		z[i].onblur = mayusculas_text;		
	}				

	// inicia reloj para fin de sesión transcurrido un tiempo
	setInterval(reloj, 1000);
	reloj();
	

	comprueba_check();
	comprueba_stock();
	
	// activa funciones para botones en página de perfil.
	var change_pass = document.getElementsByName("change_passwd")[0];
	var active_buttons = document.getElementById("edita");
	if(change_pass && active_buttons) {
		change_pass.onclick = habilita_password;
		active_buttons.onclick = habilita_campos;
	}

	// activa funciones para botones en página de pedidos de clientes
	var agrega = document.getElementById("agrega");
	if(agrega){
		agrega.onclick = agrega_linea;
		var guardar1 = document.getElementById("guardar1");

		if(guardar1) {
			document.getElementById("guardar1").onclick = guardar;
			document.getElementById("guardar1").onclick = enviaForm;
		}
		
		document.getElementById("guardar").onclick = guardar;
		document.getElementById("guardar").onclick = enviaForm;
	}	

	// desactiva campo con id "ref" en formulario "Maestro de Referencias" si el registro existe tras 
	// haber hecho la consulta a la base de datos
	var fechaAlta = document.getElementById("fecha_alta");
	if(fechaAlta) {
		if(fechaAlta.value != "" && fechaAlta != null) {
			var ref = document.getElementById("ref");
			if(ref) {
				ref.removeAttribute("name");
				ref.disabled = true;
				var ref_exist = document.getElementById("ref_exist");
				ref_exist.setAttribute("name", "ref");
			}			
		}		
	}	
	
	//muestra descripciones de productos en la sección "Entradas" al tabular y desbloquea filas
	var div_registros = document.getElementById("registros");
	if(div_registros) {						
		odd();//cambia background de filas pares a gris en la tabla del <div class="registros">					
		desbl_inputs(); //desbloquea campos en <div id="registros"> en "/spare_parts/view/inputs.php"
		total_alb();		
	}	

	//muestra municipios a través del código postal mediante un JSON
	var cp = document.getElementById("cliente_codigoPostal");
	if(cp) {
		cp.onblur = municipios;
	}

	// Cambia texto de botón "guardar" a "buscar" o viceversa en el formulario "Maestro de referencias"
	var change_text = document.getElementById("ref");
	if(change_text && change_text.value != "") {		
		document.getElementById("guardar").value = "Guardar";					
	}

	// Cambia foco en los campos de texto con opción de "check" al hacer click sobre ellos en "Nuevo Pedido de Call Center"
	var changeFocus = document.getElementsByClassName("color");
	
	if(changeFocus) {
		for(var i = 0; i <= changeFocus.length; i++) {
			if(changeFocus[i] !== undefined) {
				changeFocus[i].onfocus = cambiaFoco;
				changeFocus[i].onblur = saleFoco;
			}			
		}
	}

	// Pone el foco en el campo "Contacto" del formulario "Nuevo Pedido de Call Center" si los demás campos están rellenados
	var numCliente = document.getElementById("numCliente");
	var contacto = document.getElementById("contacto");
 	var vin = document.getElementById("bastidor");

	if(contacto && numCliente && vin) {
		if(numCliente.value != "" && contacto.value === "") {
			contacto.focus();
		}
		else if(vin.value === "" && contacto.value != "") vin.focus();
	}

	//valida campo "Contacto" del formulario "Nuevo Pedido de Call Center" si los demás campos están rellenados
	if(contacto) {
		contacto.onkeyup = clearContactError;
	}
	
	/*###################################################################################################################
	# 			Asigna evento "onchange" a los campos "referencia" y "descuento" en la vista de Pedido de Call			#
	#			Center para hacer consulta mediante AJAX a los datos correspondientes a esa referencia y calcular		#
	#			el valor neto correspondiente																			#
	###################################################################################################################*/
	
	var tipoFormulario = document.getElementsByTagName("h2");
	
	if(tipoFormulario[0].innerHTML.match(/Pedido de Call Center/i)) {
		var ref = [];
		var neto = [];
		var cantidad = [];
		var stock = [];
		
		ref[0] = document.getElementById("pedido_items_referencia");
		neto[0] = document.getElementById("pedido_items_dto");
		cantidad[0] = document.getElementById("pedido_items_cantidad");		
		
		for(i = 1; i <=10; i++) {
			ref[i] = document.getElementById("pedido_items_referencia" + i);
			neto[i] = document.getElementById("pedido_items_dto" + i);
			cantidad[i] = document.getElementById("pedido_items_cantidad" + i);			
		}
		
		for(i = 0; i < ref.length; i++) {
			if(ref[i]) {
				ref[i].onchange = showReferenceDescription;
				neto[i].onblur = showReferenceNeto;
				cantidad[i].onblur = showReferenceNetoByQuantity;
				ref[i].onblur = showReferenceStock;	
			}								
		}						
	}		
	
	//busca datos de referencias mediante AJAX en "Datos del Pedido de Call Center" 
	//var cant = "";
	var tipoFormulario = document.getElementsByTagName("h1");
	var elements = document.getElementsByClassName("descripcion");

	if(tipoFormulario[0].innerHTML == "Datos del Pedido de Call Center") {
		for(var i = 0; i < elements.length; i++) {		
			document.getElementById("referencia" + i).onkeypress = buscaDatos;
			document.getElementById("referencia" + i).onmousedown = buscaDatos;
			document.getElementById("cantidad" + i).onkeypress = buscaDatos;
			document.getElementById("dto" + i).onkeypress = buscaDatos;
			document.getElementById("neto" + i).onkeypress = buscaDatos;
		}
	}

	//valida el campo bastidor en "Pedidos de Call Center"
	var bastidor = document.getElementById("bastidor");
	if(bastidor) {
		bastidor.onkeyup = validateFieldError;
	}

	// Cambia texto de botón "buscar" a "guardar" o viceversa en el formulario "Ficha de Cliente"
	var change_button = document.getElementById("cif");
	if(change_button && change_button.value != "") {		
		document.getElementById("guardar").innerHTML = "Guardar";					
	}

	// Habilita campos de datos del cliente en el formulario "Ficha del Cliente"
	var datosCliente = document.getElementById("tipoCliente");
	if(datosCliente) {
		datosCliente.onclick = tipoCliente;
		datosCliente.onblur = tipoCliente;
		
		//deshabilita campos al inicio y cambia el background hasta que no se seleccione un tipo de cliente
		document.getElementById("nombre").style.background = "lightgray";
		document.getElementById("apellido1").style.background = "lightgray";
		document.getElementById("apellido2").style.background = "lightgray";
		document.getElementById("razon_social").style.background = "lightgray";

		document.getElementById("razon_social").readOnly = true;
		document.getElementById("nombre").readOnly = true;
		document.getElementById("apellido1").readOnly = true;
		document.getElementById("apellido2").readOnly = true;
		
		//deshabilita el campo cif si contiene datos al recargar la página (así evita duplicar el cif)
		if(document.getElementById("cif").value != "") document.getElementById("cif").readOnly = true;
	}

	// Ejecuta la función "muestraAbrev" en el formulario de "Ficha de Cliente" al seleccionar un tipo de dirección
	var showAbrev = document.getElementById("abrevia_abrev")
	if(showAbrev) {
		showAbrev.onclick = muestraAbrev;
		showAbrev.onblur = muestraAbrev;
	}
	
	// Añade evento onclick a los menus de "Postventa"
	var menusPostVenta = document.getElementsByClassName('menusPostVenta');
	if(menusPostVenta) {		
		for(var i = 0; i < menusPostVenta.length; i++) {					
			menusPostVenta[i].onclick = showLinks;
		}
	}
	
	// Añade evento onclick a los menus de "Recambios"
	var menusRecambios = document.getElementsByClassName('menusRecambios');
	if(menusRecambios) {		
		for(var i = 0; i < menusRecambios.length; i++) {					
			menusRecambios[i].onclick = showMenus;
		}
	}
	
	// Añade evento onclick a los botones con atributo class="button"
	/*var botonSubmit = document.getElementsByClassName('button');
	if(botonSubmit) {		
		for(var i = 0; i < botonSubmit.length; i++) {					
			botonSubmit[i].onclick = consultaPedidos;
		}
	}*/
	
	// Añade evento onclick a los menus principales
	var principal = document.getElementsByClassName('principal');
	if(principal) {		
		for(var i = 0; i < principal.length; i++) {					
			principal[i].onclick = consultaPedidos;
		}
	}
}

