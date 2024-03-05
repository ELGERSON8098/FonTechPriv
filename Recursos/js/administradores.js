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
    // Selecciona los campos de nombre, apellido, correo, contraseña y teléfono
    var nombreInput = document.getElementById("nombre");
    var apellidoInput = document.getElementById("apellido");
    var correoInput = document.getElementById("correo");
    var contraseñaInput = document.getElementById("contraseña");
    var telefonoInput = document.getElementById("telefono");

    // Agrega listeners para el evento de teclado (keydown) en los campos de nombre, apellido, correo, contraseña y teléfono
    nombreInput.addEventListener("keydown", function (event) {
        validarLetrasConEspacios(event);
    });
    apellidoInput.addEventListener("keydown", function (event) {
        validarLetrasConEspacios(event);
    });
    correoInput.addEventListener("blur", validarCorreo);
    contraseñaInput.addEventListener("blur", validarContraseña); // Agregamos validación al perder el foco del campo contraseña
    telefonoInput.addEventListener("keydown", function (event) {
        validarNumeros(event);
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

        // Expresión regular para validar solo letras y espacios
        var letrasConEspaciosRegex = /^[A-Za-z\s]+$/;

        // Expresión regular para validar el formato de correo electrónico
        var correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Validación de nombre
        if (nombre === "" || !letrasConEspaciosRegex.test(nombre)) {
            mostrarError('Por favor, ingresa un nombre válido.');
            return;
        }

        // Validación de apellido
        if (apellido === "" || !letrasConEspaciosRegex.test(apellido)) {
            mostrarError('Por favor, ingresa un apellido válido.');
            return;
        }

        // Validación de correo electrónico
        if (correo === "" || !correoRegex.test(correo)) {
            mostrarError('Por favor, ingresa un correo electrónico válido.');
            return;
        }

        // Validación de contraseña
        if (contraseña === "") {
            mostrarError('Por favor, ingresa una contraseña.');
            return;
        }

        // Validación de teléfono
        var numerosRegex = /^[0-9]+$/;
        if (telefono === "" || !numerosRegex.test(telefono)) {
            mostrarError('Por favor, ingresa un número de teléfono válido.');
            return;
        }
        // Si todos los campos están llenos y pasan las validaciones, muestra la alerta de guardado
        mostrarExito('Los cambios se han guardado correctamente.');

        // Limpia los campos del formulario
        limpiarCampos();
    });
});

// Función para validar que solo se ingresen letras (con espacios) en los campos de nombre y apellido
function validarLetrasConEspacios(event) {
    // Obtiene el código de la tecla presionada
    var key = event.key;

    // Expresión regular para validar si la tecla presionada es una letra o un espacio
    var letrasConEspaciosRegex = /^[A-Za-z\s]$/;

    // Si la tecla presionada no es una letra ni un espacio, cancela el evento de teclado
    if (!letrasConEspaciosRegex.test(key) && key !== 'Backspace' && key !== 'Delete') {
        event.preventDefault();
    }
}

// Función para validar el formato de correo electrónico
function validarCorreo() {
    var correoInput = document.getElementById("correo");
    var correo = correoInput.value.trim();
    var correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (correo !== "" && !correoRegex.test(correo)) {
        mostrarError('Por favor, ingresa un correo electrónico válido.');
    }
}

// Función para validar el campo de contraseña
function validarContraseña() {
    var contraseñaInput = document.getElementById("contraseña");
    var contraseña = contraseñaInput.value.trim();

    if (contraseña === "") {
        mostrarError('Por favor, ingresa una contraseña.');
    }
}

// Función para validar que solo se ingresen números en el campo de teléfono
function validarNumeros(event) {
    // Obtiene el código de la tecla presionada
    var key = event.key;

    // Expresión regular para validar si la tecla presionada es un número
    var numerosRegex = /^[0-9]$/;

    // Si la tecla presionada no es un número, cancela el evento de teclado
    if (!numerosRegex.test(key) && key !== 'Backspace' && key !== 'Delete') {
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

