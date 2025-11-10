"use strict";

// Añade evento 'onclick' al menú 'Salir' para confirmar la salida
let salirButton = document.getElementById('salir');

if(salirButton) {
    salirButton.addEventListener('click', () => {
        if(confirm("Está a punto de salir de la aplicación. \n¿Estás seguro?")) {
            salirButton.href = '/logout';
            return true;
        }
        else {
            return false;
        }
    });
}