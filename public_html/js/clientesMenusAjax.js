const clientesMenusAjax = {
    muestraMenusDeClientes: function muestraMenusDeClientes() {
		document.getElementsByTagName("h2")[0].innerHTML="Menú de " + this.innerHTML;		
		let url = '/main/clientes';						
				
		// inicializa color de fondo y color de texto de los menús principales				
		let menus = document.getElementById('menus').querySelectorAll('a');
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
}

export {clientesMenusAjax};