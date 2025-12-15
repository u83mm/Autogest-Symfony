"use strict";

// Muestra municipios a través del código postal mediante un JSON
let cp = document.getElementById("cliente_codigoPostal");

if(cp) {    	
    cp.addEventListener("blur", () => {        
        fetch("/municipios.json")
            .then(response => response.json())
            .then(data => {                                
                for (let i = 0; i < data.length; i++) {
                    if(data[i].cp == cp.value) {
                        document.getElementById("cliente_localidad").value = data[i].municipio;
                        document.getElementById("cliente_provincia").value = data[i].provincia;
                        break;
                    }
                    else {
                        document.getElementById("cliente_localidad").value = "No se ha encontrado";
                        document.getElementById("cliente_provincia").value = "No se ha encontrado";
                    }
                }
            });
    });
}