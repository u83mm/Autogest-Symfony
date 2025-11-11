"use strict";

let clientes = document.getElementById('clientes_main_menu');

if(clientes) {
    clientes.addEventListener('click', () => {
        document.querySelector('h2').innerHTML = "Menú de " + clientes.innerHTML;

        // Inicializa color de fondo y color de texto de los menús principales
        let linkElements = document.getElementById('menus').querySelectorAll('a');

        linkElements.forEach(element => {
            element.style.background = "rgba(200,145,90,0.8)";
            element.style.color = "rgb(155,85,20)";
        });                       
        
        // cambia estilo en función del menú seleccionado
        document.getElementById('clientes_main_menu').style.background = "rgba(175,100,50,0.8)";
        document.getElementById('clientes_main_menu').style.color = "white";

        fetch('/main/clientes')
            .then(response => response.text())
            .then(muestraGif())
            .then(data => {
                restablece();
                document.getElementById("datos").innerHTML = data;

                let clientesLink = document.querySelectorAll('.menusClientesLink');

                if(clientesLink) {
                    clientesLink.forEach(menu => {
                        menu.addEventListener('click', getDataFromController)
                    });
                }
            });
    });		
}