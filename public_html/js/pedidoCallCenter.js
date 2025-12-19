const marcaSelect = document.querySelector('#pedido_call_center_marca');
if(marcaSelect) {
    marcaSelect.addEventListener("change", function(event) {        
        fetch('/logo/marca/')
            .then(response => response.json())            
            .then(data => {
                const logoContainer = document.getElementById("logoMarca");
                const match = data.find(element => element.id == event.target.value);
                if (match) {
                    logoContainer.innerHTML = "<img class='logoMarcaOrderShow' src='/uploads/logo_marca/" + match.logo + "' alt='logo marca'>";
                } else {
                    logoContainer.innerHTML = "No hay resultado";
                }
            });
    });
}