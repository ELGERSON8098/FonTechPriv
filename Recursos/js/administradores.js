// Función para mostrar una ventana de confirmación al intentar eliminar un empleado
$(document).ready(function () {
    $(".deleteEmployeeBtn").click(function () {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí iría el código para eliminar el empleado si se confirma la acción
                // De momento mostraremos un mensaje en la consola
                console.log("Empleado eliminado");
                Swal.fire(
                    '¡Eliminado!',
                    'Tu archivo ha sido eliminado.',
                    'success'
                );
            }
        });
    });
});

// Espera a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {
    // Selecciona los campos de nombre y apellido
    var nombreInput = document.getElementById("nombre");
    var apellidoInput = document.getElementById("apellido");

    // Agrega listeners para el evento de teclado (keydown) en los campos de nombre y apellido
    nombreInput.addEventListener("keydown", function (event) {
        validarLetras(event);
    });
    apellidoInput.addEventListener("keydown", function (event) {
        validarLetras(event);
    });

    // Selecciona el botón de guardar cambios
    var guardarCambiosBtn = document.getElementById("guardarCambiosBtn");

    // Agrega un listener para el evento de clic
    guardarCambiosBtn.addEventListener("click", function (event) {
        // Previene el comportamiento predeterminado del formulario (enviarlo)
        event.preventDefault();

        // Validar que todos los campos estén llenos y cumplan con las validaciones
        var nombre = document.getElementById("nombre").value.trim();
        var apellido = document.getElementById("apellido").value.trim();
        var correo = document.getElementById("correo").value.trim();
        var contraseña = document.getElementById("contraseña").value.trim();
        var telefono = document.getElementById("telefono").value.trim();
        var cargo = document.getElementById("cargo").value.trim();

        // Expresión regular para validar solo letras
        var letrasRegex = /^[A-Za-z]+$/;

        // Validación de nombre
        if (nombre === "" || !letrasRegex.test(nombre)) {
            mostrarError('Por favor, ingresa un nombre válido.');
            return;
        }

        // Validación de apellido
        if (apellido === "" || !letrasRegex.test(apellido)) {
            mostrarError('Por favor, ingresa un apellido válido.');
            return;
        }

        // Resto de validaciones...

        // Si todos los campos están llenos y pasan las validaciones, muestra la alerta de guardado
        mostrarExito('Los cambios se han guardado correctamente.');

        // Limpia los campos del formulario
        limpiarCampos();
    });
});

// Función para validar que solo se ingresen letras en los campos de nombre y apellido
function validarLetras(event) {
    // Obtiene el código de la tecla presionada
    var key = event.key;

    // Expresión regular para validar si la tecla presionada es una letra
    var letrasRegex = /^[A-Za-z]$/;

    // Si la tecla presionada no es una letra, cancela el evento de teclado
    if (!letrasRegex.test(key) && key !== 'Backspace' && key !== 'Delete') {
        event.preventDefault();
    }
}

// Función para mostrar una alerta de error
function mostrarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    });
}

// Función para mostrar una alerta de éxito
function mostrarExito(mensaje) {
    Swal.fire({
        icon: 'success',
        title: '¡Guardado!',
        text: mensaje,
        showConfirmButton: false,
        timer: 1500 // Cierra automáticamente después de 1.5 segundos
    });
}

// Función para limpiar los campos del formulario
function limpiarCampos() {
    document.getElementById("nombre").value = "";
    document.getElementById("apellido").value = "";
    document.getElementById("correo").value = "";
    document.getElementById("contraseña").value = "";
    document.getElementById("telefono").value = "";
    document.getElementById("cargo").selectedIndex = 0; // Selecciona la primera opción en el select
}
