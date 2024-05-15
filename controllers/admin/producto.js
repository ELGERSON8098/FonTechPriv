// Constantes para completar las rutas de la API.
const PRODUCTO_API = 'services/admin/producto.php';
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
IMG_PRODUCTO = document.getElementById('ImagenP'),
NOMBRE_PRODUCTO = document.getElementById('nombreP'),
CodigoI_Producto = document.getElementById('CodigoI');

const SAVE_MODALS = new bootstrap.Modal('#saveModalS'),
    MODAL_TITLES = document.getElementById('modalTitleS');
// Constantes para establecer los elementos del formulario de guardar.
    const SAVE_FORMS = document.getElementById('saveFormS'),
    ID_Modals = document.getElementById('idProducto1'),
    IMAGEN_PRODUCTOS = document.getElementById('ImagenPs'),
    CATEGORIAS_PRODUCTOS = document.getElementById('Categorias'),
    MARCAS_PRODUCTOS = document.getElementById('Marcas'),
    NOMBRE_PRODUCTOS = document.getElementById('Name'),
    PRECIO_PRODUCTO = document.getElementById('PrecioP'),
    EXISTENCIA_PRODUCTO = document.getElementById('Exist'),
    DESCRIPCION_PRODUCTO = document.getElementById('Descrp'),
    MEMORIA_INTERNA_PRODUCTO = document.getElementById('MemoriaP'),
    RAM_PRODUCTO = document.getElementById('RamP'),
    TAMAÑO_PRODUCTO = document.getElementById('TamañoP'),
    CAMARA_TRASERA_PRODUCTO = document.getElementById('CamP'),
    CAMARA_FRONTAL_PRODUCTO = document.getElementById('CamsP'),
    SISTEMA_PRODUCTO = document.getElementById('SisP'),
    PROCESADOR_PRODUCTO = document.getElementById('SistP'),
    DESCUENTO_PRODUCTO = document.getElementById('Oferta'),
    ID_PRODUCTOS1 = document.getElementById('idProsub'),
    ESTADO_PRODUCTO1 = document.getElementById('estadoProducto1'),
    ESTADO_PRODUCTO2 = document.getElementById('estadoProducto');

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
        ID_PRODUCTO.value=null;
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

SAVE_FORMS.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    console.log(ID_Modals.value);

    (ID_Modals.value) ? action = 'updateRow' : action = 'createRowS';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORMS);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(PRODUCTO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODALS.hide();
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
        for (const row of DATA.dataset) {
            const FORM2 = new FormData();
            FORM2.append('idProsub', row.id_producto);
            const DATA2 = await fetchData(PRODUCTO_API, 'readOne', FORM2);
            console.log(row.estado_producto);
            icon = (parseInt(row.estado_producto) === 1) ? 'bi bi-eye-fill' : 'bi bi-eye-slash-fill';

            if (DATA2.status) {

                TABLE_BODY.innerHTML += `
                <tr>
                <td><img src="${SERVER_URL}images/productos/${row.imagen}" height="50"></td>
                    <td>${row.nombre_producto}</td>
                    <td>${row.marca}</td>
                    <td>${row.nombre_categoria}</td>
                    <td><i class="${icon}"></i></td>
                    <td>
                        
                        <button type="button" class="btn btn-info me-2 mb-2 mb-sm-2" onclick="openUpdate(${row.id_producto})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button type="button" class="btn btn-danger me-2 mb-2 mb-sm-2" onclick="openDelete(${row.id_producto})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            `;
            } else {
                TABLE_BODY.innerHTML += `
                <tr>
                <td><img src="${SERVER_URL}images/productos/${row.imagen}" height="50"></td>
                    <td>${row.nombre_producto}</td>
                    <td>${row.marca}</td>
                    <td>${row.nombre_categoria}</td>
                    <td><i class="${icon}"></i></td>
                    <td>
                        <button type="button" class="btn btn-info me-2 mb-2 mb-sm-2" onclick="openCREATES(${row.id_producto}, '${row.nombre_producto}')">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>

                        </button>
                        <button type="button" class="btn btn-danger me-2 mb-2 mb-sm-2" onclick="openDelete(${row.id_producto})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            `;
            }
        }
            
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
    fillSelect(PRODUCTO_API, 'readAllSS', 'Marca');
    fillSelect(PRODUCTO_API, 'readAllS', 'Categoria');

}

const openCREATES = (id, nombre) => {
    //console.log
    SAVE_MODALS.show();
    MODAL_TITLES.textContent = 'Crear el detalle del producto';
    SAVE_FORMS.reset();
    NOMBRE_PRODUCTOS.disabled = true;
    IMAGEN_PRODUCTOS.disabled = true;
    CATEGORIAS_PRODUCTOS.disabled = true;
    MARCAS_PRODUCTOS.disabled = true;
    ID_PRODUCTOS1.value = id;
    NOMBRE_PRODUCTOS.value = nombre;
    //Se prepara el formulario
    fillSelect(PRODUCTO_API, 'readAllSSS', 'Oferta');
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdate = async (id) => {
     // Se define una constante tipo objeto con los datos del registro seleccionado.
     const FORM = new FormData();
     FORM.append('idProsub', id);
     // Petición para obtener los datos del registro solicitado.
     const DATA = await fetchData(PRODUCTO_API, 'readOne', FORM);
     // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
     if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODALS.show();
        MODAL_TITLES.textContent = 'Actualizar producto';
        // Se prepara el formulario.
        SAVE_FORMS.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        NOMBRE_PRODUCTOS.disabled = false;
        IMAGEN_PRODUCTOS.disabled = false;
        CATEGORIAS_PRODUCTOS.disabled = false;
        MARCAS_PRODUCTOS.disabled = false;
        ID_Modals.value = ROW.id_detalle_producto;
        ID_PRODUCTOS1.value = ROW.id_producto;
        NOMBRE_PRODUCTOS.value = ROW.nombre_producto;
        PRECIO_PRODUCTO.value = ROW.precio;
        EXISTENCIA_PRODUCTO.value = ROW.existencias;
        DESCRIPCION_PRODUCTO.value = ROW.descripcion;
        MEMORIA_INTERNA_PRODUCTO.value = ROW.capacidad_memoria_interna_celular;
        RAM_PRODUCTO.value = ROW.ram_celular;
        TAMAÑO_PRODUCTO.value = ROW.pantalla_tamaño;
        CAMARA_TRASERA_PRODUCTO.value = ROW.camara_trasera_celular;
        CAMARA_FRONTAL_PRODUCTO.value = ROW.camara_frontal_celular;
        SISTEMA_PRODUCTO.value = ROW.sistema_operativo_celular;
        PROCESADOR_PRODUCTO.value = ROW.procesador_celular;
        ESTADO_PRODUCTO2.checked = parseInt(ROW.estado_producto);
        fillSelect(PRODUCTO_API, 'readAllS', 'Marcas',  ROW.id_marca);
        fillSelect(PRODUCTO_API, 'readAllSS', 'Categorias', ROW.id_categoria);
        fillSelect(PRODUCTO_API, 'readAllSSS', 'Oferta', ROW.id_oferta);
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
    console.log(id);
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

