	//Función que crea objeto XMLHttpRequest para todos los navegadores
	function getXMLHTTPRequest() {
		var peticion = false;
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

	//Función que muestra gif
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

	/*###############################################################
	#	 Función que muestra los links de los menús principales  	#
	###############################################################*/
	
	function showLinks() {
		document.getElementsByTagName("h2")[0].innerHTML="Menú de " + this.innerHTML;		
		let url = this.id;						
				
		// inicializa color de fondo y color de texto de los menús principales				
		let menus = document.getElementsByClassName('menusPostVenta');
		for(var i = 0; i < menus.length; i++) {
			menus[i].style.background = "rgba(200,145,90,0.8)";
			menus[i].style.color = "rgb(155,85,20)";
		}
		
		// cambia estilo en función del menú seleccionado								
		this.style.background = "rgba(175,100,50,0.8)";
		this.style.color = "white";
		
		// inicia la petición 		
		let peticion1 = getXMLHTTPRequest();
		peticion1.onreadystatechange = muestraClientes;
		peticion1.open('GET', url, true);
		peticion1.send(null);

		function muestraClientes() {
			if(peticion1.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion1.readyState == 4 && peticion1.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion1.responseText;
				
				let clientesLink = document.querySelectorAll('.menusClientesLink');				

				if(clientesLink) {
					clientesLink.forEach(menu => {
						menu.addEventListener('click', getDataFromController)
					});
				}
			} 
		}
	}
	
	/*###########################################################################################
	#	 Función que muestra los menus correspondiente a los links de los menús principales  	#
	###########################################################################################*/
	
	function showMenus() {		
		let params = new FormData();
		let url = this.id;		

		document.querySelector("h2").innerHTML=this.innerHTML;		
		
		params.append("tipo", this.innerHTML);										
		
		// inicia la petición 		
		let peticion1 = getXMLHTTPRequest();
		peticion1.onreadystatechange = consulta;
		peticion1.open('POST', url, true);
		peticion1.send(params);

		function consulta() {
			if(peticion1.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion1.readyState == 4 && peticion1.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion1.responseText;							
			} 
		}
	}

	// Función que muestra formulario de pedidos de taller
	function pedidosTaller() {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller";
		var peticion2 = getXMLHTTPRequest();
		peticion2.onreadystatechange = hojaPedidosTaller;
		peticion2.open('POST', '/scripts/ajax/pedidosTaller.php', true);
		peticion2.send(null);

		function hojaPedidosTaller() {
			if(peticion2.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion2.readyState == 4 && peticion2.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion2.responseText;
			} 
		}
	}

	// Función que muestra formulario de selección de consulta de pedidos
	function consultaPedidos() {	
		var peticion = getXMLHTTPRequest();
		peticion.onreadystatechange = consulta;
		peticion.open('POST', '/scripts/seleccionaConsulta.php', true);
		peticion.send();

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}
	}

	// Función que muestra el menú de consulta de pedidos de taller
	function menuPedidos() {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller";
		var peticion = getXMLHTTPRequest();
		peticion.onreadystatechange = consulta;
		peticion.open('POST', '/scripts/ajax/menuPedidos.php', true);
		peticion.send();

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}
	}

	// Función que muestra el menú de consulta de pedidos de clientes
	function menuPedidosClientes() {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Clientes";
		var peticion = getXMLHTTPRequest();
		peticion.onreadystatechange = consulta;
		peticion.open('POST', '/scripts/ajax/menuPedidosClientes.php', true);
		peticion.send();

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}
	}

	// Función que muestra el listado completo de pedidos de taller
	function listadoCompleto(s,p) {
		document.getElementsByTagName("h2")[0].innerHTML="Listado Completo de Taller";

		var peticion = getXMLHTTPRequest();
		var url = "/scripts/listadoCompletoTaller.php";
		var params = new FormData();

		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);	
		peticion.send(params);	

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}
	}

	// Función que muestra el listado completo de pedidos de clientes
	function listadoCompletoClientes(s,p) {
		document.getElementsByTagName("h2")[0].innerHTML="Listado Pedido de Clientes";

		var peticion = getXMLHTTPRequest();
		var url = "/scripts/clientes/listado_completo_clientes.php";
		var params = new FormData();
		
		params.append("s", s);
		params.append("p", p);

		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);		
		peticion.send(params);			
			
		function consulta() {			
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código			
				muestraGif();			
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}		
	}


	// Función que muestra listado de pedidos de taller
	function listadoTaller() {
		document.getElementsByTagName("h2")[0].innerHTML="prueba";
		var peticion = getXMLHTTPRequest();
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', 'listadoPedidoTaller.php', true);
		peticion.send(null);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}


	// Función que muestra actualiza pedidos de taller
	function actualizaPedidosTaller() {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller";
		var peticion = getXMLHTTPRequest();
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', '/scripts/muestraRegistro.php', true);
		peticion.send(null);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// Función que muestra registros por Orden
	function pedido_orden(x,s,p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller por Orden de Reparación";
		var peticion = getXMLHTTPRequest();
		var params = new FormData();

		params.append("orden", x);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', '/scripts/pedido_orden.php', true);	
		peticion.send(params);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// Función que muestra registros por Marca
	function pedido_marca(x,s,p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller por Marca";

		var peticion = getXMLHTTPRequest();
		var url = "/scripts/pedido_marca.php";
		var params = new FormData();

		params.append("marca", x);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', url, true);	
		peticion.send(params);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// Función que muestra registros por tipo de pedido
	function pedido_tipo(x,s,p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller por Tipo de Pedido";
		var peticion = getXMLHTTPRequest();
		var params = new FormData();

		params.append("tipo", x);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', '/scripts/pedido_tipo.php', true);	
		peticion.send(params);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// Función que muestra registros por fecha de pedido
	function pedido_fecha(x,s,p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller por Fecha";
		var peticion = getXMLHTTPRequest();
		var params = new FormData();

		params.append("fecha", x);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', '/scripts/pedido_fecha.php', true);	
		peticion.send(params);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// Función que muestra registros por matrícula
	function pedido_matricula(x,s,p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller por matrícula";
		var peticion = getXMLHTTPRequest();
		var params = new FormData();

		params.append("matricula", x);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', '/scripts/pedido_matricula.php', true);	
		peticion.send(params);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// Función que muestra registros por estado
	function pedido_estado(x,s,p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller por Estado";
		var peticion = getXMLHTTPRequest();
		var params = new FormData();

		params.append("estado", x);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', '/scripts/pedido_estado.php', true);	
		peticion.send(params);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// Función que muestra registros por número de pedido
	function pedido_num(x, s, p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller por nº de pedido";
		var peticion = getXMLHTTPRequest();
		var params = new FormData();

		params.append("pedido", x);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', '/scripts/pedido_num.php', true);	
		peticion.send(params);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// Función que muestra registros por tipo de sección
	function pedido_seccion(x,s,p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos de Taller por Sección";
		var peticion = getXMLHTTPRequest();
		var params = new FormData();

		params.append("seccion", x);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = hojaPedidosTaller;
		peticion.open('POST', '/scripts/pedido_seccion.php', true);	
		peticion.send(params);

		function hojaPedidosTaller() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// Función que muestra los links del menú principal de Marcas
	function marcas() {
		document.getElementsByTagName("h2")[0].innerHTML="Menú de Marcas";
		document.getElementById("marcas").style.background = "rgba(175,100,50,0.8)";
		document.getElementById("marcas").style.color = "white";
		//document.getElementById("link").style.background = "rgba(200,145,90,0.8)";
		//document.getElementById("link").style.color = "rgb(155,85,20)";
		var peticion = getXMLHTTPRequest();
		peticion.onreadystatechange = funcion;
		peticion.open('GET', 'ajax/menuMarcas.php', true);
		peticion.send(null);

		function funcion() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}
	}

	// Función que muestra formulario de creación de Marcas
	function creaMarca() {
		document.getElementsByTagName("h2")[0].innerHTML="Crea una Marca";
		var peticion = getXMLHTTPRequest();
		peticion.onreadystatechange = funcion;
		peticion.open('POST', '/view/formulario_crea_marcas.php', true);
		peticion.send();

		function funcion() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}
	}

	// Función que muestra listado de Marcas
	function muestraMarcas(s, p) {
		document.getElementsByTagName("h2")[0].innerHTML="Listado de Marcas";
		var peticion = getXMLHTTPRequest();
		var params = new FormData();
		
		//peticion.open('POST', 'muestra_marcas.php', true);	
		//peticion.send();

		params.append("s", s);
		params.append("p", p);

		peticion.onreadystatechange = funcion;
		peticion.open('POST', '/scripts/ajax/index.php?action=muestra_marcas', true);
		peticion.send(params);

		function funcion() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}
	}

	// Función que muestra el menú de consulta de pedidos de Taller
	function getDataFromController() {		
		let peticion = getXMLHTTPRequest();	
		let url = this.id;		
		
		peticion.onreadystatechange = consulta;
		peticion.open('GET', url, true);
		peticion.send();		

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código				
				muestraGif();				
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				window.location = url;
			} 
		}
	}

	// Muestra el formulario de consulta general de Taller, Clientes o Referencias
	function consultaGeneral(url) {
		document.getElementsByTagName("h2")[0].innerHTML="Búsqueda General";
		var peticion = getXMLHTTPRequest();
		var url = url;

		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);
		peticion.send();

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}
	}

	// muestra registros por estado de los pedidos de clientes
	function pedido_estado_clientes(estado, s, p) {
		var estadoPedido = "";
		//Asigna una cadena de texto al estado del pedido, ya que la variable estado es un número
		if(estado == 1) {
			estadoPedido = "Por mirar";
		}
		if(estado == 2) {
			estadoPedido = "Presupuestado";
		}
		if(estado == 3) {
			estadoPedido = "Pedido";
		}
		if(estado == 4) {
			estadoPedido = "Servido";
		}
		if(estado == 5) {
			estadoPedido = "Enviado despiece";
		}
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos en estado: " + estadoPedido;
		var peticion = getXMLHTTPRequest();	
		var url = "/scripts/clientes/pedido_estado.php";
		var params = new FormData();

		params.append("estado", estado);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);	
		peticion.send(params);

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// muestra registros por fecha de los pedidos de clientes
	function pedido_fecha_clientes(fecha, s, p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos a fecha: " + fecha;
		var peticion = getXMLHTTPRequest();	
		var url = "/scripts/clientes/pedido_fecha.php";
		var params = new FormData();

		params.append("fecha", fecha);
		params.append("s", s);
		params.append("p", p);

		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);	
		peticion.send(params);

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}
	}

	// muestra datos del pedido de un cliente
	function pedido_numero_clientes(pedido, s, p) {	
		var peticion = getXMLHTTPRequest();	
		//var url = "/scripts/clientes/pedido_fecha.php";
		var url = "/scripts/clientes/muestra_registro.php?pedido=" + pedido;
		/*var params = new FormData();

		params.append("pedido", pedido);
		params.append("s", s);
		params.append("p", p);*/

		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);	
		peticion.send();

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				//restablece();			
				//document.getElementById("datos").innerHTML = peticion.responseText;
				location = url;			
			} 
		}
	}

	// muestra registros por nombre de cliente
	function pedido_cliente(cliente, s, p) {
		document.getElementsByTagName("h2")[0].innerHTML="Pedidos del cliente: " + cliente;
		var peticion = getXMLHTTPRequest();	
		var url = "/scripts/clientes/pedido_cliente.php";
		var params = new FormData();

		params.append("cliente", cliente);
		params.append("s", s);
		params.append("p", p);

		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);	
		peticion.send(params);

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}

	// muestra registros de una "Consulta general" de clientes o de taller
	function consulta_general(campo, criterio, marca, tipo, estado, dpto, s, p) {
		if(campo != "") campo = campo.value;
		if(criterio != "") criterio = criterio.value;
		if(marca != "") marca = marca.value;
		if(tipo != "") tipo = tipo.value;
		if(estado != "") estado = estado.value;
		if(dpto != "") dpto = dpto.value;
		
		if(dpto == "taller") {
			var ruta = "/scripts/listadoPedidoTaller.php";
		}
		else if(dpto == "clientes") {
			ruta = "/scripts/clientes/listado_pedido_clientes.php";
		}
		else {
			ruta = "/products/view/listado_referencias_criterio.php";
		}
		
		document.getElementsByTagName("h2")[0].innerHTML="Resultado de la consulta";
		var peticion = getXMLHTTPRequest();
		url = ruta;
		var params = new FormData();

		params.append("campo", campo);
		params.append("criterio", criterio);
		params.append("marca", marca);
		params.append("tipo", tipo);
		params.append("estado", estado);
		params.append("s", s);
		params.append("p", p);
		
		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);	
		peticion.send(params);

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			}
		}
	}		

	/*function showDatesPvp() {
		// obtiene la referencia del objeto que llama a la función showDates();
		var referencia = document.getElementById(this.id).value;	

		// crea una petición	para el campo "PVP" de la hoja de "ENTRADAS DE ALMACÉN"
		var peticion = getXMLHTTPRequest();
		var params = new FormData();

		params.append("referencia", referencia);

		peticion.open('POST', "/spare_parts/view/inputs_request_pvp.php", true);
		peticion.onreadystatechange = consulta;
		peticion.send(params);

		// obtiene el índice del objeto para pasárselo al id del objeto que contendrá la descripción del producto
		var str = this.id;
		var indice = str.charAt(3);
		var indice_decenas = str.charAt(4);
		if(indice_decenas) indice += indice_decenas;

		function consulta() {
			if(peticion.readyState == 1) {
				alert("No se ha encontrado la referencia");
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {						
				document.getElementById("pvp" + indice).value = peticion.responseText;			
			}
		}		
	}*/

	function showNeto() {
		// obtiene el índice del objeto para pasárselo al id del objeto que contendrá la descripción del producto
		var str = this.id;	

		if(str.length > 4) {
			var indice = str.charAt(8);	
			var indice_decenas = str.charAt(9);
			if(indice_decenas) indice += indice_decenas;
		}
		else {
			var indice = str.charAt(3);	
			var indice_decenas = str.charAt(4);
			if(indice_decenas) indice += indice_decenas;
		}

		// cambia background de la celda "Referencias" a gris si es par
		if(indice % 2 != 0) this.style.background = "#dcd9d7";		
		
		// obtiene valores para pasarlos al script que realizará los cálculos;
		var cant = document.getElementById("cantidad" + indice).value;		
		var dto = document.getElementById("dto" + indice).value;
		var pvp = document.getElementById("pvp" + indice).value;

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
				var neto = pvp;		
			}						
			else {
				var neto = pvp - (pvp * dto / 100);		
			}

			var total = neto * cant;
			document.getElementById("total" + indice).value = parseFloat(total).toFixed(2);																		

			// crea una petición	para el campo "Descripción" de la hoja de "ENTRADAS DE ALMACÉN"
			var peticion = getXMLHTTPRequest();
			var params = new FormData();

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
	//#						MUESTRA MUNICIPIOS EN FORMULARIOS DONDE SE PIDE CÓDIGO POSTAL		#
	//###########################################################################################

	function municipios() {
		var cp = document.getElementById("cliente_codigoPostal").value;				
		var peticion = getXMLHTTPRequest();

		peticion.onreadystatechange = consulta;
		peticion.open("GET", "/municipios.txt", true);	
		peticion.send();							

		function consulta() {				
			if(peticion.readyState == 1) {
				//muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				var myObj = JSON.parse(peticion.responseText);				
				
				for(var i = 0; i < myObj.length; i++) {				
					if(myObj[i].cp == cp) {
						document.getElementById("cliente_localidad").value = myObj[i].municipio;
						document.getElementById("cliente_provincia").value = myObj[i].provincia;
						i = myObj.length;
					}
					else {
						document.getElementById("cliente_localidad").value = "No hay resultado";					
					}				
				}						
			}					
		}		
	}


	//###########################################################################################
	//#						MUESTRA DATOS DE REFERENCIAS EN NUEVO PEDIDO DE CALL CENTER 		#
	//###########################################################################################

	function consultaReferencias(event, obj = null) {
		//recoge el código ASCII de la tecla pulsada, el "id" del objeto que llama a la función y calcula el índice para usarlo
		var x = event;
		var id = this.id;
		var indice = 0;
		var totalPvp = totalDto = totalNeto = numRegistros = 0;

		// calcula el nº de registros que hay en el formulario para calcular los totales que se muestran al pie del formulario
		numRegistros = document.getElementsByClassName("descripcion");

		//a partir de la fila 30 no funciona this.id, por eso le pasamos el objeto directamente
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

		//si es la tecla "ENTER" cambia el atributo "onsubmit" del formulario a "false" para parar el envío
		if((x.charCode == 13 && id == "referencia") || (x.button === 0 && id == "referencia")) {
			document.getElementById("pedidosForm").setAttribute("onsubmit", "return false");		
		
			//recoge el valor del campo "referencia"
			if(this.value) var valor = this.value.toUpperCase();
			if(!valor) var valor = obj.value.toUpperCase();

			//crea una petición	para el campo "Descripción" de la hoja de "Nuevo Pedido de Call Center"
			var peticion = getXMLHTTPRequest();
			var params = new FormData();

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

			//crea una petición	para el campo "Precio" de la hoja de "Nuevo Pedido de Call Center"
			var peticion1 = getXMLHTTPRequest();
			var params1 = new FormData();

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

			//crea una petición	para el campo "Stock" de la hoja de "Nuevo Pedido de Call Center"
			var peticion2 = getXMLHTTPRequest();
			var params2 = new FormData();

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

			//pone el foco en el campo "cantidad"
			document.getElementById("cantidad" + indice).focus();	
		}
		else if((x.charCode == 13 && id == "cantidad") || (x.charCode == undefined && id == "cantidad")) {
			document.getElementById("pedidosForm").setAttribute("onsubmit", "return false");	

			//recoge el valor del campo "cantidad"
			if(this.value) var cantidad = parseFloat(this.value).toFixed(2);
			if(!cantidad) var cantidad = parseFloat(obj.value).toFixed(2);
			
			if(!cantidad || isNaN(cantidad)) cantidad = parseFloat(0).toFixed(2);

			document.getElementById("cantidad" + indice).value = cantidad;
		
			//recoge el valor del campo "precio"
			var pvp = document.getElementById("precio" + indice).value;		
			//pvp = parseFloat(pvp.replace(",", "."));
			pvp = pvp.replace(".", "").replace(",",".");
			if(!pvp) pvp = parseFloat(0).toFixed(2);
			document.getElementById("precio" + indice).value = pvp;	

			//recoge el valor del campo "dto"
			var dto = document.getElementById("dto" + indice).value;
			dto = parseFloat(dto.replace(",", "."));
			if(!dto) dto = parseFloat(0).toFixed(2);		

			// muestra el valor en el campo dto
			//document.getElementById("dto" + indice).value = dto;

			totalPvp = pvp * cantidad;
			totalDto = ((totalPvp * dto) / 100);
			totalNeto = totalPvp - totalDto;

			//calcula el valor para el campo "neto"
			document.getElementById("neto" + indice).value =  parseFloat(totalNeto).toFixed(2);

			//pone el fondo en verde si hay existencias
			if(document.getElementById("instock" + indice).value > 0) {
				document.getElementById("stock" + indice).checked = true;
			}
			else {
				document.getElementById("stock" + indice).checked = false;
			}

			comprueba_stock();

			//pone el foco en el campo "dto"
			document.getElementById("dto" + indice).focus();

			totalPvp = totalDto = totalNeto = 0;
		
			indice = 0;

			// suma totales para mostrarlos al final
			for(var i = 0; i < numRegistros.length; i++) {
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
			var iva = document.getElementById("iva").value;
			var totalIva = (totalNeto * iva) / 100;		
			
			// pone totales en la parte inferior del formulario
			document.getElementById("totalPvp").value = parseFloat(totalPvp).toFixed(2);
			document.getElementById("totalDto").value = parseFloat(totalDto).toFixed(2);
			document.getElementById("totalNeto").value = parseFloat(totalNeto).toFixed(2);
			document.getElementById("totalIva").value = parseFloat(totalIva).toFixed(2);
			document.getElementById("total").value = parseFloat(totalNeto + totalIva).toFixed(2);		
		}
		else if((x.charCode == 13 && id == "dto") || (x.charCode == undefined && id == "dto")) {
			document.getElementById("pedidosForm").setAttribute("onsubmit", "return false");
			
			//recoge el valor del campo "cantidad"
			var cantidad = document.getElementById("cantidad" + indice).value;
			cantidad = parseFloat(cantidad.replace(",", "."));
			if(!cantidad) cantidad = parseFloat(0).toFixed(2);

			//recoge el valor del campo "precio"
			var pvp = document.getElementById("precio" + indice).value;
			pvp = parseFloat(pvp.replace(",", "."));
			if(!pvp) pvp = 0;

			//recoge el valor del campo "dto"
			var dto = document.getElementById("dto" + indice).value;		
			dto = parseFloat(dto.replace(",", ".")).toFixed(2);
			if(!dto || isNaN(dto)) dto = parseFloat(0).toFixed(2);

			// muestra el valor en el campo dto
			document.getElementById("dto" + indice).value = dto;

			totalPvp = pvp * cantidad;
			totalDto = ((totalPvp * dto) / 100);
			totalNeto = totalPvp - totalDto;

			//calcula el valor para el campo "neto"
			document.getElementById("neto" + indice).value =  parseFloat(totalNeto).toFixed(2);

			//pone el foco en el campo "neto"
			document.getElementById("neto" + indice).focus();

			totalPvp = totalDto = totalNeto = 0;

			indice = 0;
			
			// suma los totales para mostrarlos al final
			for(var i = 0; i < numRegistros.length; i++) {			
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
			var iva = document.getElementById("iva").value;
			var totalIva = (totalNeto * iva) / 100;			

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

	//###########################################################################################
	//#						Muestra una página mediante AJAX 									#
	//###########################################################################################

	function muestraPagAjax(url) {	
		var peticion = getXMLHTTPRequest();	
		var url = url;

		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);	
		peticion.send();

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				location = url;			
			} 
		}
	}

	//###########################################################################################
	//#						Muestra menús mediante AJAX		 									#
	//###########################################################################################

	function muestraMenAjax(url) {
		document.getElementsByTagName("h2")[0].innerHTML="Menú Referencias";
		var peticion = getXMLHTTPRequest();	
		var url = url;

		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);	
		peticion.send();

		function consulta() {
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código
				muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;			
			} 
		}
	}		

	//###########################################################################################
	//#										Muestra un listado paginando	   					#
	//###########################################################################################
	function pasaPagina(s, p, url, cadena) {
		document.getElementsByTagName("h2")[0].innerHTML="Listado de " + cadena;

		var peticion = getXMLHTTPRequest();
		var url = url;
		var params = new FormData();
		
		params.append("s", s);
		params.append("p", p);

		peticion.onreadystatechange = consulta;
		peticion.open('POST', url, true);		
		peticion.send(params);			
			
		function consulta() {			
			if(peticion.readyState == 1) {//función que se repite y se puede optimizar reduciendo código			
				muestraGif();			
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				restablece();
				document.getElementById("datos").innerHTML = peticion.responseText;
			} 
		}		
	}
	
	/*###########################################################################################
	#	 			Función que muestra logo en formulario de Pedido de Call Center			  	#
	###########################################################################################*/		
	
	function showLogoMarca(value) {	
		var id = value;			
		var peticion = getXMLHTTPRequest();

		peticion.onreadystatechange = consulta;
		peticion.open("GET", "/logo/marca", true);	
		peticion.send();							

		function consulta() {						
			if(peticion.readyState == 1) {
				//muestraGif();
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				var myObj = JSON.parse(peticion.responseText);
												
				for(var i = 0; i < myObj.length; i++) {				
					if(myObj[i].id == id) {
						$("logoMarca").innerHTML = "<img class='logoMarcaNew' src='/uploads/logo_marca/" + myObj[i].logo + "' alt='logo marca'>";						
						i = myObj.length;
					}
					else {
						$("logoMarca").innerHTML = "No hay resultado";					
					}				
				}						
			}					
		}		
	}
	
	/*###########################################################################################
	#	 						Muestra datos de una referencia		  							#
	###########################################################################################*/
	
	function showReferenceDescription() {
		this.value = this.value.toUpperCase();
		var ref = this.value;					
		var peticion = getXMLHTTPRequest();				
		
		// almacena el último caracter del id del objeto como índice
		var indice = this.id[this.id.length -1];				
		
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
					$("pedido_items_precio" + indice).value = parseFloat(0).toFixed(2);
					$("pedido_items_dto" + indice).value = 0;
					$("pedido_items_neto" + indice).value = 0;										
										
					$("pedido_items_stock" + indice).value = 0;
					
					/*$("pedido_items_descripcion" + indice).value = "No hay resultado";
					$("pedido_items_precio" + indice).value = 0;
					$("pedido_items_dto" + indice).value = 0;*/						
				}
				else {
					$("pedido_items_precio" + indice).value = parseFloat(0).toFixed(2);
					$("pedido_items_dto" + indice).value = 0;
					$("pedido_items_neto" + indice).value = 0;										
										
					$("pedido_items_stock" + indice).value = 0;
					
					/*$("pedido_items_descripcion").value = "No hay resultado";
					$("pedido_items_precio").value = 0;
					$("pedido_items_dto").value = 0*/					
				}	
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				var myObj = JSON.parse(peticion.responseText);												
				
				for(var i = 0; i < myObj.length; i++) {				
					if(myObj[i].referencia == ref) {						
						if(indice >= 1) {
							$("pedido_items_descripcion" + indice).value = myObj[i].descripcion;
							$("pedido_items_precio" + indice).value = parseFloat(myObj[i].pvp).toFixed(2);
							$("pedido_items_dto" + indice).value = myObj[i].dto;							
						}
						else {
							$("pedido_items_descripcion").value = myObj[i].descripcion;
							$("pedido_items_precio").value = myObj[i].pvp;
							$("pedido_items_dto").value = myObj[i].dto;								
						}
											
						i = myObj.length;
					}
					else {
						if(indice >= 1) {
							$("pedido_items_descripcion" + indice).value = "No hay resultado";
							$("pedido_items_precio" + indice).value = 0;
							$("pedido_items_dto" + indice).value = 0;							
						}
						else {
							$("pedido_items_descripcion").value = "No hay resultado";
							$("pedido_items_precio").value = 0;
							$("pedido_items_dto").value = 0;								
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
		var ref = this.value;					
		var peticion = getXMLHTTPRequest();							
		
		// almacena el último caracter del id del objeto como índice
		var indice = this.id[this.id.length -1];				
		
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
					$("pedido_items_precio" + indice).value = parseFloat(0).toFixed(2);
					$("pedido_items_dto" + indice).value = 0;
					$("pedido_items_neto" + indice).value = 0;									
										
					$("pedido_items_stock" + indice).value = 0;					
				}
				else {					
					$("pedido_items_precio").value = parseFloat(0).toFixed(2);
					$("pedido_items_dto").value = 0;
					$("pedido_items_neto").value = 0;										
										
					$("pedido_items_stock").value = 0;					
				}	
			}
			else if(peticion.readyState == 4 && peticion.status == 200) {
				var myObj = JSON.parse(peticion.responseText);												
				
				for(var i = 0; i < myObj.length; i++) {				
					if(myObj[i].referencia == ref) {						
						if(indice >= 1) {
							$("pedido_items_stock" + indice).value = myObj[i].stock;													
						}
						else {
							$("pedido_items_stock").value = myObj[i].stock;														
						}
											
						i = myObj.length;
					}
					else {
						if(indice >= 1) {							
							$("pedido_items_stock" + indice).value = 0;							
						}
						else {							
							$("pedido_items_stock").value = 0;							
						}											
					}				
				}																										
			}
			
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
	}
