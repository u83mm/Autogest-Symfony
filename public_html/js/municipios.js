"use strict";

// Muestra municipios a través del código postal mediante un JSON
let cp = document.getElementById("cliente_codigoPostal");

if(cp) {		
    cp.addEventListener("blur", () => {
        fetch("/municipios.json")
            .then(response => response.json())
            .then(data => {
                const cp = document.getElementById("cliente_codigoPostal").value;        
                
                data.forEach(element => {                       
                    if(element.cp == cp) {                             
                        document.getElementById("cliente_localidad").value = element.municipio;
                        document.getElementById("cliente_provincia").value = element.provincia;                                      
                    }       
                });                
            })
    });
}