window.onload = function() {
    var taDiv = document.getElementById("ta");
    taDiv.scrollTop = taDiv.scrollHeight;
}
function chat() {
    var csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    var hiddenInputs = document.querySelectorAll('input[name="mensaje_id"]');
    if (hiddenInputs.length === 0) {
        var id = '';
    }
    else{
        var id = hiddenInputs[hiddenInputs.length - 1].value; // Asegúrate de obtener el valor del input
    }
    if (id!=''){
        var formData = new FormData();
        formData.append('id', id);
        formData.append('_token', csrfToken);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/chat', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        xhr.onload = function() {
            if (xhr.status == 200) {
                // Agrega la respuesta del servidor al div con id "ta"
                if (xhr.responseText!=''){
                    document.getElementById("ta").innerHTML += xhr.responseText;
                    var taDiv = document.getElementById("ta");
                    taDiv.scrollTop = taDiv.scrollHeight;
                    // console.log(xhr.responseText);
                }
            } else {
                console.log('Error al editar incidencia:', xhr.responseText);
            }
        };

        xhr.onerror = function(error) {
            console.error('Error de red al intentar editar incidencia:', error);
        };
        xhr.send(formData);
    }
}
function chat2() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/chat2', true);

    xhr.onload = function() {
        if (xhr.status == 200) {
            // Agrega la respuesta del servidor al div con id "ta"
            if (xhr.responseText!=''){
                document.getElementById("ta").innerHTML = xhr.responseText;
                var taDiv = document.getElementById("ta");
                taDiv.scrollTop = taDiv.scrollHeight;
            }
        } else {
            console.log('Error al editar incidencia:', xhr.responseText);
        }
    };

    xhr.onerror = function(error) {
        console.error('Error de red al intentar editar incidencia:', error);
    };
    xhr.send();
}

// Ejecutar la función chat cada 5 segundos
setInterval(chat, 5000);


function men() {
    if (document.getElementById("mensaje").value!=''){
        var mensaje = document.getElementById("mensaje").value;
        var csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
        var formData = new FormData();
        formData.append('mensaje', mensaje);
        formData.append('_token', csrfToken);
        if (mensaje!=''){
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/enviarMen', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            
            xhr.onload = function() {
                if (xhr.status == 200) {
                    limpiar();
                    if (document.getElementById("ta").children.length === 0){
                        chat2();
                    }
                    else{
                        chat();
                    }
                } else {
                    console.log('Error al editar incidencia:', xhr.responseText);
                }
            };
            xhr.onerror = function(error) {
                console.error('Error de red al intentar editar incidencia:', error);
            };
            
            xhr.send(formData);
        }
    }
}
function limpiar(){
    document.getElementById("mensaje").value = "";
}