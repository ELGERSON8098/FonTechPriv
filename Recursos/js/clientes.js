// Función para mostrar una ventana de confirmación al intentar eliminar un empleado
$(document).ready(function () {
    $(".deleteClientBtn").click(function () {
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