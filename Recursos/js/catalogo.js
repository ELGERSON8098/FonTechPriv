$(document).ready(function () {
    // Escuchar el clic en el botón "Agregar Productos"
    $('#movableContainer2').click(function () {
        // Mostrar el modal de "Agregar Producto"
        $('#agregarProductoModal').modal('show');
    });

    // Escuchar el clic en el botón "Editar"
    $('#icon1').click(function () {
        // Mostrar el modal de "Editar Producto"
        $('#editarProductoModal').modal('show');
    });

    // Escuchar el clic en el botón "Eliminar"
    $('#icon2').click(function () {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "¡Sí, eliminarlo!",
            cancelButtonText: "¡No, cancelar!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                swalWithBootstrapButtons.fire({
                    title: "¡Eliminado!",
                    text: "Tu archivo ha sido eliminado.",
                    icon: "success"
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Tu archivo está seguro :)",
                    icon: "error"
                });
            }
        });
    });

    // Escuchar el clic en el botón "Guardar"
    $('#btnGuardar').click(function () {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",

            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Agregado",
            text: "Tu archivo ha sido agregado con exito.",
            icon: "success",
            confirmButtonText: "OK",

            reverseButtons: true
        })
    });

    $('#btnGuardar1').click(function () {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",

            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Agregado",
            text: "Tu archivo ha sido agregado con exito.",
            icon: "success",
            confirmButtonText: "OK",

            reverseButtons: true
        })
    });



    // Escuchar el cambio en el campo de "Categoría"
    $('#categoriaProducto').change(function () {
        // Obtener el valor seleccionado
        var categoriaSeleccionada = $(this).val();
        // Limpiar los campos adicionales
        $('#camposAdicionales').empty();
        // Si la categoría seleccionada es "Celulares" o "Tablets"
        if (categoriaSeleccionada === 'Celulares' || categoriaSeleccionada === 'Tablets') {
            // Agregar campos adicionales específicos
            $('#camposAdicionales').append(`
                <div class="form-group">
                    <label for="ramProducto">RAM:</label>
                    <input type="text" class="form-control" id="ramProducto">
                </div>
                <div class="form-group">
                    <label for="pantallaProducto">Pantalla:</label>
                    <input type="text" class="form-control" id="pantallaProducto">
                </div>
                <div class="form-group">
                    <label for="camaraTraseraProducto">Cámara Trasera:</label>
                    <input type="text" class="form-control" id="camaraTraseraProducto">
                </div>
                <div class="form-group">
                    <label for="capacidadProducto">Capacidad:</label>
                    <input type="text" class="form-control" id="capacidadProducto">
                </div>
                <div class="form-group">
                    <label for="camaraFrontalProducto">Cámara Frontal:</label>
                    <input type="text" class="form-control" id="camaraFrontalProducto">
                </div>
                <div class="form-group">
                    <label for="procesadorProducto">Procesador:</label>
                    <input type="text" class="form-control" id="procesadorProducto">
                </div>
                <div class="form-group">
                    <label for="sistemaOperativoProducto">Sistema Operativo:</label>
                    <select class="form-control" id="sistemaOperativoProducto">
                        <option value="Android">Android</option>
                        <option value="IOS">IOS</option>
                    </select>
                </div>
            `);
        }
    });

    // Escuchar el cambio en el campo de "Categoría"
    $('#categoriaProducto1').change(function () {
        // Obtener el valor seleccionado
        var categoriaSeleccionada = $(this).val();
        // Limpiar los campos adicionales
        $('#camposAdicionales1').empty();
        // Si la categoría seleccionada es "Celulares" o "Tablets"
        if (categoriaSeleccionada === 'Celulares' || categoriaSeleccionada === 'Tablets') {
            // Agregar campos adicionales específicos
            $('#camposAdicionales1').append(`
                <div class="form-group">
                    <label for="ramProducto">RAM:</label>
                    <input type="text" class="form-control" id="ramProducto">
                </div>
                <div class="form-group">
                    <label for="pantallaProducto">Pantalla:</label>
                    <input type="text" class="form-control" id="pantallaProducto">
                </div>
                <div class="form-group">
                    <label for="camaraTraseraProducto">Cámara Trasera:</label>
                    <input type="text" class="form-control" id="camaraTraseraProducto">
                </div>
                <div class="form-group">
                    <label for="capacidadProducto">Capacidad:</label>
                    <input type="text" class="form-control" id="capacidadProducto">
                </div>
                <div class="form-group">
                    <label for="camaraFrontalProducto">Cámara Frontal:</label>
                    <input type="text" class="form-control" id="camaraFrontalProducto">
                </div>
                <div class="form-group">
                    <label for="procesadorProducto">Procesador:</label>
                    <input type="text" class="form-control" id="procesadorProducto">
                </div>
                <div class="form-group">
                    <label for="sistemaOperativoProducto">Sistema Operativo:</label>
                    <select class="form-control" id="sistemaOperativoProducto">
                        <option value="Android">Android</option>
                        <option value="IOS">IOS</option>
                    </select>
                </div>
            `);
        }
    });

     // Mostrar la vista previa de la imagen seleccionada
    $('#imagenProducto').change(function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            $('#imagenPreview').attr('src', reader.result);
        }
        reader.readAsDataURL(event.target.files[0]);
    });


    // Mostrar la vista previa de la imagen seleccionada en el modal de editar producto
    $('#imagenProductoEdit').change(function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            $('#imagenPreviewEdit').attr('src', reader.result);
        }
        reader.readAsDataURL(event.target.files[0]);
    });
});

function Blanco_PantallaChica() {
    var navbar = document.querySelector('.sidebar');
    var windowWidth = window.innerWidth;

    if (windowWidth < 1200) {
        navbar.classList.add('navbar-white');
    } else {
        navbar.classList.remove('navbar-white');
    }
}

document.addEventListener('DOMContentLoaded', Blanco_PantallaChica);
window.addEventListener('resize', Blanco_PantallaChica);
