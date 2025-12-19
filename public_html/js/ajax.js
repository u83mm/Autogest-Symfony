	// Función que crea objeto XMLHttpRequest para todos los navegadores
	function getXMLHTTPRequest() {
		let peticion = false;
		try {
			/* for Firefox */
			peticion = new XMLHttpRequest();
		} catch (err) {
			try {
				/* for some versions of IE */
				peticion = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (err) {
				try {
					/* for some other versions of IE */
					peticion = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (err) {
					peticion = false;
				}	
			}
		}
		return peticion;
	}

	// Función que muestra gif
	function muestraGif() {
		document.getElementById("datos").style.textAlign = 'center';
		document.getElementById("datos").style.background = 'none';
		document.getElementById("datos").style.marginTop = '150px';
		document.getElementById("datos").innerHTML = "<img id='gifmovil' src='/images/gif-load-grande.gif'>";
	}

	function restablece() {
		document.getElementById("datos").style.marginTop = '0px';
		document.getElementById("datos").style.textAlign = 'left';
		document.getElementById("datos").style.background = 'rgba(175,100,50,0.8)';
		document.getElementById("datos").innerHTML = "";
	}																	

	// Función que muestra el menú de consulta de pedidos de Taller
	function getDataFromController() {		
		let peticion = getXMLHTTPRequest();	
		let url = this.id;		
		
		peticion.onreadystatechange = consulta;
		peticion.open('GET', url, true);
		peticion.send();		

		function consulta() {
			if(peticion.readyState == 1) {// función que se repite y se puede optimizar reduciendo código				
				muestraGif();				
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				window.location = url;
			} 
		}
	}							

	function showNeto() {
		// obtiene el índice del objeto para pasárselo al id del objeto que contendrá la descripción del producto
		let str = this.id;	

		if(str.length > 4) {
			let indice = str.charAt(8);	
			let indice_decenas = str.charAt(9);
			if(indice_decenas) indice += indice_decenas;
		}
		else {
			let indice = str.charAt(3);	
			let indice_decenas = str.charAt(4);
			if(indice_decenas) indice += indice_decenas;
		}

		// cambia background de la celda "Referencias" a gris si es par
		if(indice % 2 != 0) this.style.background = "#dcd9d7";		
		
		// obtiene valores para pasarlos al script que realizará los cálculos;
		let cant = document.getElementById("cantidad" + indice).value;		
		let dto = document.getElementById("dto" + indice).value;
		let pvp = document.getElementById("pvp" + indice).value;

		// si no hay datos sobre la referencia a consultar, vacía campos
		if(document.getElementById("descr" + indice).value === "") {
			document.getElementById("total" + indice).value = null;
			document.getElementById("p_compra" + indice).value = null;
			document.getElementById("dto" + indice).value = null;
			document.getElementById("cantidad" + indice).value = null;
		}
		else {
			// muestra el total
			if(dto === null || dto === 0 || dto === "") {
				dto = parseFloat(0).toFixed(2);
				let neto = pvp;		
			}						
			else {
				let neto = pvp - (pvp * dto / 100);		
			}

			let total = neto * cant;
			document.getElementById("total" + indice).value = parseFloat(total).toFixed(2);																		

			// crea una petición para el campo "Descripción" de la hoja de "ENTRADAS DE ALMACÉN"
			let peticion = getXMLHTTPRequest();
			let params = new FormData();

			params.append("catidad", cant);
			params.append("dto", dto);
			params.append("pvp", pvp);

			peticion.onreadystatechange = consulta;
			peticion.open('POST', "/spare_parts/view/inputs_request_neto.php", true);		
			peticion.send(params);				

			function consulta() {
				if(peticion.readyState == 1) {
					//muestraGif();
				}
				else if(peticion.readyState == 4 && peticion.status == 200) {																
					document.getElementById("p_compra" + indice).value = peticion.responseText;													
				}
			}	
		}
		total_alb(); // llama a la función que muestra el total neto en el pie de la tabla en Entradas o Salidas
		desbl_inputs();
	}	


	//###########################################################################################
	//#						MUESTRA DATOS DE REFERENCIAS EN NUEVO PEDIDO DE CALL CENTER 		#
	//###########################################################################################

	function consultaReferencias(event, obj = null) {
		// recoge el código ASCII de la tecla pulsada, el "id" del objeto que llama a la función y calcula el índice para usarlo
		let x = event;
		let id = this.id;
		let indice = 0;
		let totalPvp = totalDto = totalNeto = numRegistros = 0;

		// calcula el nº de registros que hay en el formulario para calcular los totales que se muestran al pie del formulario
		numRegistros = document.getElementsByClassName("descripcion");

		// a partir de la fila 30 no funciona this.id, por eso le pasamos el objeto directamente
		if(!id) id = obj.id;

		if(id.substr(0, 10) == "referencia") {
			indice = id.substr(10);
			id = "referencia";		
		}
		else if(id.substr(0, 8) == "cantidad") {
			indice = id.substr(8);
			id = "cantidad";
		}
		else if(id.substr(0, 3) == "dto"){
			indice = id.substr(3);
			id = "dto";
		}
		else {
			indice = id.substr(4);
			id = "neto";
		}

		// si es la tecla "ENTER" cambia el atributo "onsubmit" del formulario a "false" para parar el envío
		if((x.charCode == 13 && id == "referencia") || (x.button === 0 && id == "referencia")) {
			document.getElementById("pedidosForm").setAttribute("onsubmit", "return false");
			let valor = null;		
		
			// recoge el valor del campo "referencia"
			if(this.value) valor = this.value.toUpperCase();
			if(!valor) valor = obj.value.toUpperCase();

			// crea una petición	para el campo "Descripción" de la hoja de "Nuevo Pedido de Call Center"
			let peticion = getXMLHTTPRequest();
			let params = new FormData();

			params.append("referencia", valor);

			peticion.onreadystatechange = consulta;
			peticion.open('POST', "/spare_parts/view/inputs_request_description.php", true);	
			peticion.send(params);		
			
			function consulta() {
				if(peticion.readyState == 1) {
					//muestraPausa("lineas");
				}
				else if(peticion.readyState == 4 && peticion.status == 200) {
					// si no se encuentra ningún valor en la base de datos, devuelve una advertencia
					if(peticion.responseText == 0) {
						if(x.button !== 0) myAlert("La referencia no existe!.", id, indice);	
					}
					else {
						document.getElementById("descripcion" + indice).value = peticion.responseText;			
					}													
				}
			}

			// crea una petición	para el campo "Precio" de la hoja de "Nuevo Pedido de Call Center"
			let peticion1 = getXMLHTTPRequest();
			let params1 = new FormData();

			params1.append("referencia", valor);

			peticion1.onreadystatechange = consulta1;
			peticion1.open('POST', "/spare_parts/view/inputs_request_pvp.php", true);	
			peticion1.send(params1);		
			
			function consulta1() {
				if(peticion1.readyState == 1) {
					//muestraPausa("lineas");
				}
				else if(peticion1.readyState == 4 && peticion1.status == 200) {								
					document.getElementById("precio" + indice).value = peticion1.responseText;			
				}
			}

			// crea una petición	para el campo "Stock" de la hoja de "Nuevo Pedido de Call Center"
			let peticion2 = getXMLHTTPRequest();
			let params2 = new FormData();

			params2.append("referencia", valor);

			peticion2.onreadystatechange = consulta2;
			peticion2.open('POST', "/spare_parts/view/inputs_request_instock.php", true);	
			peticion2.send(params2);		
			
			function consulta2() {
				if(peticion2.readyState == 1) {
					//muestraPausa("lineas");
				}
				else if(peticion2.readyState == 4 && peticion2.status == 200) {								
					document.getElementById("instock" + indice).value = peticion2.responseText;								
				}						
			}														

			// pone el foco en el campo "cantidad"
			document.getElementById("cantidad" + indice).focus();	
		}
		else if((x.charCode == 13 && id == "cantidad") || (x.charCode == undefined && id == "cantidad")) {
			document.getElementById("pedidosForm").setAttribute("onsubmit", "return false");
			let cantidad = 0;	

			// recoge el valor del campo "cantidad"
			if(this.value) cantidad = parseFloat(this.value).toFixed(2);
			if(!cantidad) cantidad = parseFloat(obj.value).toFixed(2);
			
			if(!cantidad || isNaN(cantidad)) cantidad = parseFloat(0).toFixed(2);

			document.getElementById("cantidad" + indice).value = cantidad;
		
			// recoge el valor del campo "precio"
			let pvp = document.getElementById("precio" + indice).value;					
			pvp = pvp.replace(".", "").replace(",",".");
			if(!pvp) pvp = parseFloat(0).toFixed(2);
			document.getElementById("precio" + indice).value = pvp;	

			// recoge el valor del campo "dto"
			let dto = document.getElementById("dto" + indice).value;
			dto = parseFloat(dto.replace(",", "."));
			if(!dto) dto = parseFloat(0).toFixed(2);		

			// muestra el valor en el campo dto			
			totalPvp = pvp * cantidad;
			totalDto = ((totalPvp * dto) / 100);
			totalNeto = totalPvp - totalDto;

			// calcula el valor para el campo "neto"
			document.getElementById("neto" + indice).value =  parseFloat(totalNeto).toFixed(2);

			//pone el fondo en verde si hay existencias
			if(document.getElementById("instock" + indice).value > 0) {
				document.getElementById("stock" + indice).checked = true;
			}
			else {
				document.getElementById("stock" + indice).checked = false;
			}

			comprueba_stock();

			// pone el foco en el campo "dto"
			document.getElementById("dto" + indice).focus();

			totalPvp = totalDto = totalNeto = 0;
		
			indice = 0;

			// suma totales para mostrarlos al final
			for(let i = 0; i < numRegistros.length; i++) {
				pvp = document.getElementById("precio" + indice).value;		
				pvp = parseFloat(pvp.replace(",", ".")).toFixed(2);
				cantidad = document.getElementById("cantidad" + indice).value;
				cantidad = parseFloat(cantidad.replace(",", ".")).toFixed(2);
				if(isNaN(cantidad)) cantidad = parseFloat(0).toFixed(2);
				dto = document.getElementById("dto" + indice).value;
				dto = parseFloat(dto.replace(",", ".")).toFixed(2);
				if(isNaN(dto)) dto = parseFloat(0).toFixed(2);

				if(!isNaN(pvp)) {
					totalPvp += (pvp * cantidad);
					totalDto += (((pvp * cantidad) * dto) / 100);
				}
		
				indice++;
			}
			
			totalNeto += totalPvp - totalDto;
			let iva = document.getElementById("iva").value;
			let totalIva = (totalNeto * iva) / 100;		
			
			// pone totales en la parte inferior del formulario
			document.getElementById("totalPvp").value = parseFloat(totalPvp).toFixed(2);
			document.getElementById("totalDto").value = parseFloat(totalDto).toFixed(2);
			document.getElementById("totalNeto").value = parseFloat(totalNeto).toFixed(2);
			document.getElementById("totalIva").value = parseFloat(totalIva).toFixed(2);
			document.getElementById("total").value = parseFloat(totalNeto + totalIva).toFixed(2);		
		}
		else if((x.charCode == 13 && id == "dto") || (x.charCode == undefined && id == "dto")) {
			document.getElementById("pedidosForm").setAttribute("onsubmit", "return false");
			
			// recoge el valor del campo "cantidad"
			let cantidad = document.getElementById("cantidad" + indice).value;
			cantidad = parseFloat(cantidad.replace(",", "."));
			if(!cantidad) cantidad = parseFloat(0).toFixed(2);

			// recoge el valor del campo "precio"
			let pvp = document.getElementById("precio" + indice).value;
			pvp = parseFloat(pvp.replace(",", "."));
			if(!pvp) pvp = 0;

			// recoge el valor del campo "dto"
			let dto = document.getElementById("dto" + indice).value;		
			dto = parseFloat(dto.replace(",", ".")).toFixed(2);
			if(!dto || isNaN(dto)) dto = parseFloat(0).toFixed(2);

			// muestra el valor en el campo dto
			document.getElementById("dto" + indice).value = dto;

			totalPvp = pvp * cantidad;
			totalDto = ((totalPvp * dto) / 100);
			totalNeto = totalPvp - totalDto;

			// calcula el valor para el campo "neto"
			document.getElementById("neto" + indice).value =  parseFloat(totalNeto).toFixed(2);

			// pone el foco en el campo "neto"
			document.getElementById("neto" + indice).focus();

			totalPvp = totalDto = totalNeto = 0;

			indice = 0;
			
			// suma los totales para mostrarlos al final
			for(let i = 0; i < numRegistros.length; i++) {			
				pvp = document.getElementById("precio" + indice).value;		
				pvp = parseFloat(pvp.replace(",", ".")).toFixed(2);
				cantidad = document.getElementById("cantidad" + indice).value;
				cantidad = parseFloat(cantidad.replace(",", ".")).toFixed(2);
				if(isNaN(cantidad)) cantidad = parseFloat(0).toFixed(2);
				dto = document.getElementById("dto" + indice).value;
				dto = parseFloat(dto.replace(",", ".")).toFixed(2);
				if(isNaN(dto)) dto = parseFloat(0).toFixed(2);

				if(!isNaN(pvp)) {
					totalPvp += pvp * cantidad;
					totalDto += ((pvp * cantidad) * dto) / 100;
				}
						
				indice++;
			}

			totalNeto += totalPvp - totalDto;
			let iva = document.getElementById("iva").value;
			let totalIva = (totalNeto * iva) / 100;			

			// pone totales en la parte inferior del formulario
			document.getElementById("totalPvp").value = parseFloat(totalPvp).toFixed(2);
			document.getElementById("totalDto").value = parseFloat(totalDto).toFixed(2);
			document.getElementById("totalNeto").value = parseFloat(totalNeto).toFixed(2);
			document.getElementById("totalIva").value = parseFloat(totalIva).toFixed(2);
			document.getElementById("total").value = parseFloat(totalNeto + totalIva).toFixed(2);
		}
		else if(document.getElementById("referencia" + (++indice)) !== null){		
			document.getElementById("referencia" + (indice )).focus();					
		}
		else {
			return;
		}
	}		
	
	/*###########################################################################################
	#	 						Muestra datos de una referencia		  							#
	###########################################################################################*/
	
	function showReferenceDescription() {
		this.value = this.value.toUpperCase();
		let ref = this.value;					
		let peticion = getXMLHTTPRequest();				
		
		// almacena el último caracter del id del objeto como índice
		let indice = this.id[this.id.length -1];				
		
		// si el índice necesario tiene que contener 2 dígitos (ej. 10), recalcula el índice. (24) es el número de carácteres correspondiente
		// a la longitud de la cadena "pedido_items_referencia1"		
		if(this.id.length > 24) {
			indice = this.id[this.id.length -2] + this.id[this.id.length -1];
		}										
				
		peticion.onreadystatechange = consulta;
		peticion.open("GET", "/referencia/" + ref, true);	
		peticion.send();							

		function consulta() {						
			if(peticion.readyState == 1) {
				//muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 404) {
				if(indice >= 1) {
					document.getElementById("pedido_items_precio" + indice).value = parseFloat(0).toFixed(2);
					document.getElementById("pedido_items_dto" + indice).value = 0;
					document.getElementById("pedido_items_neto" + indice).value = 0;										
										
					document.getElementById("pedido_items_stock" + indice).value = 0;															
				}
				else {
					document.getElementById("pedido_items_precio" + indice).value = parseFloat(0).toFixed(2);
					document.getElementById("pedido_items_dto" + indice).value = 0;
					document.getElementById("pedido_items_neto" + indice).value = 0;										
										
					document.getElementById("pedido_items_stock" + indice).value = 0;														
				}	
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				let myObj = JSON.parse(peticion.responseText);												
				
				for(let i = 0; i < myObj.length; i++) {				
					if(myObj[i].referencia == ref) {						
						if(indice >= 1) {
							document.getElementById("pedido_items_descripcion" + indice).value = myObj[i].descripcion;
							document.getElementById("pedido_items_precio" + indice).value = parseFloat(myObj[i].pvp).toFixed(2);
							document.getElementById("pedido_items_dto" + indice).value = myObj[i].dto;							
						}
						else {
							document.getElementById("pedido_items_descripcion").value = myObj[i].descripcion;
							document.getElementById("pedido_items_precio").value = myObj[i].pvp;
							document.getElementById("pedido_items_dto").value = myObj[i].dto;								
						}
											
						i = myObj.length;
					}
					else {
						if(indice >= 1) {
							document.getElementById("pedido_items_descripcion" + indice).value = "No hay resultado";
							document.getElementById("pedido_items_precio" + indice).value = 0;
							document.getElementById("pedido_items_dto" + indice).value = 0;							
						}
						else {
							document.getElementById("pedido_items_descripcion").value = "No hay resultado";
							document.getElementById("pedido_items_precio").value = 0;
							document.getElementById("pedido_items_dto").value = 0;								
						}											
					}				
				}											
			}					
		}		
	}
	
	/*###########################################################################################
	#	 						Muestra stock de una referencia		  							#
	###########################################################################################*/
	
	function showReferenceStock() {
		this.value = this.value.toUpperCase();
		let ref = this.value;					
		let peticion = getXMLHTTPRequest();							
		
		// almacena el último caracter del id del objeto como índice
		let indice = this.id[this.id.length -1];				
		
		// si el índice necesario tiene que contener 2 dígitos (ej. 10), recalcula el índice. (24) es el número de carácteres correspondiente
		// a la longitud de la cadena "pedido_items_referencia1"		
		if(this.id.length > 24) {
			indice = this.id[this.id.length -2] + this.id[this.id.length -1];
		}										
				
		peticion.onreadystatechange = consulta;
		peticion.open("GET", "/end/point/stock/" + ref, true);	
		peticion.send();							

		function consulta() {						
			if(peticion.readyState == 1) {
				//muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 404) {
				if(indice >= 1) {					
					document.getElementById("pedido_items_precio" + indice).value = parseFloat(0).toFixed(2);
					document.getElementById("pedido_items_dto" + indice).value = 0;
					document.getElementById("pedido_items_neto" + indice).value = 0;									
										
					document.getElementById("pedido_items_stock" + indice).value = 0;					
				}
				else {					
					document.getElementById("pedido_items_precio").value = parseFloat(0).toFixed(2);
					document.getElementById("pedido_items_dto").value = 0;
					document.getElementById("pedido_items_neto").value = 0;										
										
					document.getElementById("pedido_items_stock").value = 0;					
				}	
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {				
				let myObj = JSON.parse(peticion.responseText);																						

				if(myObj.referencia == ref) {						
					if(indice >= 1) {
						document.getElementById("pedido_items_stock" + indice).value = myObj.stock;													
					}
					else {
						document.getElementById("pedido_items_stock").value = myObj.stock;														
					}															
				}
				else {
					if(indice >= 1) {							
						document.getElementById("pedido_items_stock" + indice).value = 0;							
					}
					else {							
						document.getElementById("pedido_items_stock").value = 0;							
					}											
				}																										
			}
			
			// Obtiene el nº de filas existentes en el detalle del pedido
			let filas = [];
			filas[0] = document.getElementById('pedido_items_descripcion');
			
			for(i = 1; i < 11; i++) {
				if(document.getElementById('pedido_items_descripcion' + i)) {
					filas[i] = document.getElementById('pedido_items_descripcion' + i);
				}					
			}
			
			// Calcula los totales
			let cantidad = document.getElementById('pedido_items_cantidad').value;
			let pvp = document.getElementById('pedido_items_precio').value;
			let dto = document.getElementById('pedido_items_dto').value;
			let neto = (pvp * cantidad) - (pvp * cantidad * dto / 100);					
			
			let totalPvp = pvp * cantidad;			
			let totalNeto = neto;			
			let totalIva = totalNeto * 21 / 100;							 
				
			for(i = 1; i < filas.length; i++) {
				cantidad = document.getElementById('pedido_items_cantidad' + i).value;
				pvp = document.getElementById('pedido_items_precio' + i).value;
				dto = document.getElementById('pedido_items_dto' + i).value;
				neto = (pvp * cantidad) - (pvp * cantidad * dto / 100);					
								
				totalNeto += neto;
				totalPvp += (pvp * cantidad);												
				totalIva = (totalNeto * 21 / 100);																																									
			}
			
			document.getElementById('pedido_items_totalPvp').value = parseFloat(totalPvp).toFixed(2);
			document.getElementById('pedido_items_totalNeto').value = parseFloat(totalNeto).toFixed(2);
			document.getElementById('pedido_items_totalDto').value = parseFloat(totalPvp - totalNeto).toFixed(2);
			document.getElementById('pedido_items_totalIva').value = parseFloat(totalIva).toFixed(2);
			document.getElementById('pedido_items_total').value = parseFloat(totalNeto + totalIva).toFixed(2);					
		}		
	}
