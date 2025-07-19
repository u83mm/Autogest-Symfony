const tallerMenusAjax = {
    muestraMenusDeTaller: function muestraMenusDeTaller() {
		document.getElementsByTagName("h2")[0].innerHTML="Menú de " + this.innerHTML;		
		let url = '/main/taller';						
				
		// inicializa color de fondo y color de texto de los menús principales				
		let linkElements = document.getElementById('menus').querySelectorAll('a');

		linkElements.forEach(element => {
            element.style.background = "rgba(200,145,90,0.8)";
            element.style.color = "rgb(155,85,20)";
        });
		
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
			} 
		}
	}
}

export {tallerMenusAjax};