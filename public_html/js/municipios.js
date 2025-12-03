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
                    try {
                        if(element.cp == cp) {                             
                            document.getElementById("cliente_localidad").value = element.municipio;
                            document.getElementById("cliente_provincia").value = element.provincia;                                      
                        }
                        else {
                            throw new Error("No se ha encontrado");                            
                        }
                    } catch (error) {
                        document.getElementById("cliente_localidad").value = error.message;
                        document.getElementById("cliente_provincia").value = error.message;
                    }       
                });                
            })
    });
}