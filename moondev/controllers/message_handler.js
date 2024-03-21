/* global hidder */

//Esta funcion sirve para decodificar los mensajes de error de PHP y colocarlos en
//su input correspondiente
var display_message;

function message(message, input, json) {
    //Para debuggear establecemos el mensaje recibido
    window.received_message = message;
    //Los mensajes de error estan dentro de secciones en el JSON, con el split separamos cada seccion
    var access_message = message.split(".");
    window.stopforeach = false;
    if (typeof (hidder) == 'function') {
        if (input == "global_error") {
            hidder(true, true);
        } else {
            hidder(true, false);
        }
    }
    //En window.jsonresult se encuentran los mensajes con sus secciones y en message_output
    //se iterara dentro de cada seccion establecida en access_message hasta llegar
    //al mensaje requerido
    //EJ
    //message = coins.empty
    //access message ["coins", "empty"]
    //message_output[access_message[0]]
    //luego
    //message_output[access_message[1]]
    var message_output = json;
    var final_message_output = undefined;
    access_message.forEach(element => {
        if (window.stopforeach !== true) {
            if (element == "prefix") {
                window.stopforeach = true;
                final_message_output = "";
                //Con el lenght-1 accedo al ultimo elemento del array y lo separo con el split
                var split_prefix = access_message[access_message.length - 1].split("");
                split_prefix.forEach(element => {
                    final_message_output += message_output[element] + ", ";
                });
            }
            message_output = message_output[element];
        }
    });
    if (typeof (final_message_output) != 'undefined') {
        message_output += final_message_output;
        var final_message_output = undefined;
    }
    if (input != null) {
        var input_id = document.getElementById(input);
        if (input_id == undefined) {
            console.error("Fallo al imprimir mensaje de error, el input no existe.");
        } else {
            input_id.innerHTML = message_output;
        }
    } else {
        display_message = message_output;
    }
}


function inputHandler(callback) {
    var toggleInput = document.querySelectorAll('.ingresadores');
    window.toggleInput = toggleInput;
    var timer = [];
    var inserted = [];
    //Tiempo de espera para ejecutar el callback entre llamadas a la funcion
    const time = 0;
    toggleInput.forEach(input => {
        function handleKey() {
            clearTimeout(timer[input.id]);
            timer[input.id] = setTimeout(() => {
                if (inserted[input.id] != document.getElementById(input.id).value) {
                    callback(input);
                    inserted[input.id] = document.getElementById(input.id).value;
                }
            }, time);
        }
        if (input.getAttribute('listener') == null) {
            //Este se ejecuta cada vez que el usuario deja de escribir
            //input.addEventListener('keyup', handleKey);
            //Este se ejecuta cada vez que lo que esta dentro del input cambia
            input.addEventListener('input', handleKey);
            input.setAttribute('listener', 'true');
        }
    });
}

//Le extirpamos los "" y los slashes al regex obtenido para poder ejecutarlo en new RegExp
function parseSettings(variable) {
    return variable.substring(1, ((variable).length)-1);
}

export { message, inputHandler, parseSettings, display_message };