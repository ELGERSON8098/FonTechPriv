// Constantes para completar las rutas de la API.
const PRODUCTO_API = 'services/admin/producto.php';
const CATEGORIA_API = 'services/admin/categoria.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// Constantes para establecer el contenido de la tabla.
const TABLE_BODY = document.getElementById('tableBody'),
    ROWS_FOUND = document.getElementById('rowsFound');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL = new bootstrap.Modal('#saveModal'),
    MODAL_TITLE = document.getElementById('modalTitle');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    ID_PRODUCTO = document.getElementById('idProducto'),
    NOMBRE_PRODUCTO = document.getElementById('nombreProducto'),
    DESCRIPCION_PRODUCTO = document.getElementById('descripcionProducto'),
    PRECIO_PRODUCTO = document.getElementById('precioProducto'),
    EXISTENCIAS_PRODUCTO = document.getElementById('existenciasProducto'),
    ESTADO_PRODUCTO = document.getElementById('estadoProducto');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Gestionar productos';
    // Llamada a la función para llenar la tabla con los registros existentes.
    fillTable();
});

// Método del evento para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_PRODUCTO.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(PRODUCTO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTable = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND.textContent = '';
    TABLE_BODY.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se establece un icono para el estado del producto.
            (row.estado_producto) ? icon = 'bi bi-eye-fill' : icon = 'bi bi-eye-slash-fill';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
                <tr>
                    <td><img src="${SERVER_URL}images/productos/${row.imagen_producto}" height="50"></td>
                    <td>${row.nombre_producto}</td>
                    <td>${row.precio_producto}</td>
                    <td>${row.nombre_categoria}</td>
                    <td><i class="${icon}"></i></td>
                    <td>
                        <button type="button" class="btn btn-info" onclick="openUpdate(${row.id_producto})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button type="button" class="btn btn-danger" onclick="openDelete(${row.id_producto})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openCreate = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = 'Crear producto';
    // Se prepara el formulario.
    SAVE_FORM.reset();
    EXISTENCIAS_PRODUCTO.disabled = false;
    fillSelect(CATEGORIA_API, 'readAll', 'categoriaProducto');
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idProducto', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(PRODUCTO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Actualizar producto';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        EXISTENCIAS_PRODUCTO.disabled = true;
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_PRODUCTO.value = ROW.id_producto;
        NOMBRE_PRODUCTO.value = ROW.nombre_producto;
        DESCRIPCION_PRODUCTO.value = ROW.descripcion_producto;
        PRECIO_PRODUCTO.value = ROW.precio_producto;
        EXISTENCIAS_PRODUCTO.value = ROW.existencias_producto;
        ESTADO_PRODUCTO.checked = ROW.estado_producto;
        fillSelect(CATEGORIA_API, 'readAll', 'categoriaProducto', ROW.id_categoria);
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openDelete = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idProducto', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(PRODUCTO_API, 'deleteRow', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se muestra un mensaje de éxito.
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}

/*
*   Función para abrir un reporte automático de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openReport = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/productos.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}




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
                    text: "Tu marca ha sido eliminado.",
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
            text: "Tu marca ha sido agregado con exito.",
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
            text: "Tu marca ha sido editada con exito.",
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



