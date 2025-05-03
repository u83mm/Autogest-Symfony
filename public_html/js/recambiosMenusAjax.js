// Recambios Menus Ajax
const recambiosMenusAjax =  {
    // Muestra los menús del menú principal de 'Recambios'
    muestraMenusDeRecambios: function muestraMenusDeRecambios() {
        document.getElementsByTagName("h2")[0].innerHTML = "Menú de " + this.innerHTML;        

        // Inicializa color de fondo y color de texto de los menús principales
        let linkElements = document.getElementById('menus').querySelectorAll('a');

        linkElements.forEach(element => {
            element.style.background = "rgba(200,145,90,0.8)";
            element.style.color = "rgb(155,85,20)";
        });                       
		
		// cambia estilo en función del menú seleccionado								
		this.style.background = "rgba(175,100,50,0.8)";
		this.style.color = "white";

        let peticion = getXMLHTTPRequest();
        let url = "/menus/recambios";        
        
        peticion.onreadystatechange = consulta;
        peticion.open('GET', url, true);	
        peticion.send();    
    
        function consulta() {                        
            if(peticion.readyState == 1) {
                muestraGif();			
            }
            else if(peticion.readyState == 4 && peticion.status == 200) {
                restablece();                    
                document.getElementById("datos").innerHTML = peticion.responseText;
                
                // Add onclick event to Recambios's ajax menus 
				let consultarPedidosLink = document.getElementById('consultar_pedidos');
				let crearPedidoCallCenterLink = document.getElementById('/pedido/call/center/pedido');
				let referenciasLink = document.getElementById('menus_referencias');

                if(consultarPedidosLink || referenciasLink) {
					consultarPedidosLink.addEventListener('click', recambiosMenusAjax.menusDeConsultarPedidos);
					referenciasLink.addEventListener('click', recambiosMenusAjax.menusDeReferencias);
				}

				if(crearPedidoCallCenterLink) {
					crearPedidoCallCenterLink.addEventListener('click', getDataFromController);
				}
            } 
        }	
    },

    // Muestra los menús del menú 'Consultar pedidos'
    menusDeConsultarPedidos : function muestraMenusDeConsultarPedidos() {
        document.getElementsByTagName("h2")[0].innerHTML = this.innerHTML;
        
        // Inicializa color de fondo y color de texto de los menús principales
        let linkElements = document.getElementById('menus').querySelectorAll('a');

        linkElements.forEach(element => {
            element.style.background = "rgba(200,145,90,0.8)";
            element.style.color = "rgb(155,85,20)";
        });  
               
        // cambia estilo en función del menú seleccionado
        document.getElementById('recambios_main_menu').style.background = "rgba(175,100,50,0.8)";
        document.getElementById('recambios_main_menu').style.color = "white";

        let peticion = getXMLHTTPRequest();
        let url = "/menus/consultar_pedidos";

        peticion.onreadystatechange = consulta;
        peticion.open('GET', url, true);
        peticion.send();
        function consulta() {
            if(peticion.readyState == 1) {
                muestraGif();
            }
            else if(peticion.readyState == 4 && peticion.status == 200) {
                restablece();
                document.getElementById("datos").innerHTML = peticion.responseText;
                
                // Add onclick event to Recambios's ajax menus                
                let pedidoCallCenterLink = document.getElementById('menus_pedido_call_center');

                if(pedidoCallCenterLink) {
                    pedidoCallCenterLink.addEventListener('click', recambiosMenusAjax.menusDePedidosDeCallCenter);
                }
            }
        }
    },

    // Muestra los menús del menú 'Referencias'
    menusDeReferencias : function muestraMenusDeReferencias() {
        document.getElementsByTagName("h2")[0].innerHTML = this.innerHTML;              

        // Inicializa color de fondo y color de texto de los menús principales
        let linkElements = document.getElementById('menus').querySelectorAll('a');        

        // cambia estilo en función del menú seleccionado
        document.getElementById('recambios_main_menu').style.background = "rgba(175,100,50,0.8)";
        document.getElementById('recambios_main_menu').style.color = "white";

        let peticion = getXMLHTTPRequest();
        let url = "/menus/referencias";

        peticion.onreadystatechange = consulta;
        peticion.open('GET', url, true);
        peticion.send();
        function consulta() {
            if(peticion.readyState == 1) {
                muestraGif();
            }
            else if(peticion.readyState == 4 && peticion.status == 200) {
                restablece();
                document.getElementById("datos").innerHTML = peticion.responseText; 

                // Add onclick event to diferent ajax menus 
				let referenciasMenus = document.querySelectorAll('.referenciasMenus');														

				if(referenciasMenus) {
					referenciasMenus.forEach(menu => {
						menu.addEventListener('click', getDataFromController);
					});
				}                                              
            }
        }
    },

    // Muestra los menús del menú 'Pedidos de Call Center'
    menusDePedidosDeCallCenter : function muestraMenusDePedidosDeCallCenter() {
        document.getElementsByTagName("h2")[0].innerHTML = this.innerHTML;              

        // Inicializa color de fondo y color de texto de los menús principales
        let linkElements = document.getElementById('menus').querySelectorAll('a');        

        // cambia estilo en función del menú seleccionado
        document.getElementById('recambios_main_menu').style.background = "rgba(175,100,50,0.8)";
        document.getElementById('recambios_main_menu').style.color = "white";

        let peticion = getXMLHTTPRequest();
        let url = "/menus/consultar_pedidos/pedidos_call_center";

        peticion.onreadystatechange = consulta;
        peticion.open('GET', url, true);
        peticion.send();
        function consulta() {
            if(peticion.readyState == 1) {
                muestraGif();
            }
            else if(peticion.readyState == 4 && peticion.status == 200) {
                restablece();
                document.getElementById("datos").innerHTML = peticion.responseText;
                
                // Add onclick event to diferent ajax menus 
				let pedidosCallCenterMenus = document.querySelectorAll('.pedidosCallCenterMenus');														

				if(pedidosCallCenterMenus) {
					pedidosCallCenterMenus.forEach(menu => {
						menu.addEventListener('click', getDataFromController);
					});
				}
            }
        }
    }
}

export { recambiosMenusAjax }