"use strict";

let recambios = document.getElementById('recambios_main_menu');

if(recambios) {
    recambios.addEventListener('click', () => {
        document.querySelector('h2').innerHTML = "Menú de " + recambios.innerHTML;        

        // Inicializa color de fondo y color de texto de los menús principales
        let linkElements = document.getElementById('menus').querySelectorAll('a');

        linkElements.forEach(element => {
            element.style.background = "rgba(200,145,90,0.8)";
            element.style.color = "rgb(155,85,20)";
        });                       
		
		// cambia estilo en función del menú seleccionado								
        recambios.style.background = "rgba(175,100,50,0.8)";
        recambios.style.color = "white";                
        
        fetch("/menus/recambios")            
            .then(response => response.text())
            .then(muestraGif())
            .then(data => {
                restablece();
                document.getElementById("datos").innerHTML = data;
                
                // Add onclick event to Recambios's ajax menus 
				let consultarPedidosLink = document.getElementById('consultar_pedidos');
                let crearPedidoCallCenterLink = document.getElementById('crear_pedido_call');
                let referenciasLink = document.getElementById('menus_referencias');

                // Muestra los menus correspondientes al link 'Consultar Pedidos'
                if(consultarPedidosLink) {
					consultarPedidosLink.addEventListener('click', () => {
                        document.querySelector('h2').innerHTML = consultarPedidosLink.innerHTML;
                        
                        // Inicializa color de fondo y color de texto de los menús principales
                        let linkElements = document.getElementById('menus').querySelectorAll('a');

                        linkElements.forEach(element => {
                            element.style.background = "rgba(200,145,90,0.8)";
                            element.style.color = "rgb(155,85,20)";
                        });  
                            
                        // cambia estilo en función del menú seleccionado
                        document.getElementById('recambios_main_menu').style.background = "rgba(175,100,50,0.8)";
                        document.getElementById('recambios_main_menu').style.color = "white";

                        fetch('/menus/consultar_pedidos')
                            .then(response => response.text())
                            .then(muestraGif())
                            .then(data => {
                                restablece();
                                document.getElementById("datos").innerHTML = data;

                                // Add onclick event to Recambios's ajax menus                
                                let pedidoCallCenterLink = document.getElementById('menus_pedido_call_center');

                                // Muestra los menus correspondientes al link 'Pedidos Call Center'
                                if(pedidoCallCenterLink) {
                                    pedidoCallCenterLink.addEventListener('click', () => {
                                        document.querySelector('h2').innerHTML = pedidoCallCenterLink.innerHTML;
                                        
                                        // Inicializa color de fondo y color de texto de los menús principales
                                        let linkElements = document.getElementById('menus').querySelectorAll('a');

                                        linkElements.forEach(element => {
                                            element.style.background = "rgba(200,145,90,0.8)";
                                            element.style.color = "rgb(155,85,20)";
                                        });  
                                            
                                        // cambia estilo en función del menú seleccionado
                                        document.getElementById('recambios_main_menu').style.background = "rgba(175,100,50,0.8)";
                                        document.getElementById('recambios_main_menu').style.color = "white";

                                        fetch('/menus/consultar_pedidos/pedidos_call_center')
                                            .then(response => response.text())
                                            .then(muestraGif())
                                            .then(data => {
                                                restablece();
                                                document.getElementById("datos").innerHTML = data;

                                                // Add onclick event to diferent ajax menus 
				                                let pedidosCallCenterMenus = document.querySelectorAll('.pedidosCallCenterMenus');

                                                if(pedidosCallCenterMenus) {
                                                    pedidosCallCenterMenus.forEach(menu => {
                                                        menu.addEventListener('click', getDataFromController);
                                                    });
                                                }
                                            });
                                    });
                                }
                            });
                    });					
				}

                // Muestra el formulario 'Crear Pedido Call Center'
                if(crearPedidoCallCenterLink) {
                    crearPedidoCallCenterLink.addEventListener('click', () => {
                        document.querySelector('h2').innerHTML = crearPedidoCallCenterLink.innerHTML;
                        
                        // Inicializa color de fondo y color de texto de los menús principales
                        let linkElements = document.getElementById('menus').querySelectorAll('a');

                        linkElements.forEach(element => {
                            element.style.background = "rgba(200,145,90,0.8)";
                            element.style.color = "rgb(155,85,20)";
                        });  
                            
                        // cambia estilo en función del menú seleccionado
                        document.getElementById('recambios_main_menu').style.background = "rgba(175,100,50,0.8)";
                        document.getElementById('recambios_main_menu').style.color = "white";

                        fetch('/pedido/call/center/pedido')
                            .then(response => response.text())
                            .then(muestraGif())
                            .then(data => {
                                restablece();
                                window.location = '/pedido/call/center/pedido';
                            });
                    });
                }

                // Muestra los menus correspondientes al link 'Referencias'
                if(referenciasLink) {
                    referenciasLink.addEventListener('click', () => {
                        document.querySelector('h2').innerHTML = referenciasLink.innerHTML;
                        
                        // Inicializa color de fondo y color de texto de los menús principales
                        let linkElements = document.getElementById('menus').querySelectorAll('a');

                        linkElements.forEach(element => {
                            element.style.background = "rgba(200,145,90,0.8)";
                            element.style.color = "rgb(155,85,20)";
                        });  
                            
                        // cambia estilo en función del menú seleccionado
                        document.getElementById('recambios_main_menu').style.background = "rgba(175,100,50,0.8)";
                        document.getElementById('recambios_main_menu').style.color = "white";

                        fetch('/menus/referencias')
                            .then(response => response.text())
                            .then(muestraGif())
                            .then(data => {
                                restablece();
                                document.getElementById("datos").innerHTML = data;

                                // Add onclick event to diferent ajax menus 
				                let referenciasMenus = document.querySelectorAll('.referenciasMenus');

                                if(referenciasMenus) {
                                    referenciasMenus.forEach(menu => {
                                        menu.addEventListener('click', getDataFromController);
                                    });
                                }
                            });
                    });
                }
            });                        
    });		
}