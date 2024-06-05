// Constante para completar la ruta de la API.
const PEDIDO_API = 'services/public/pedido.php',
    MODELOTALLAS_API = 'services/public/modelotallas.php',
    COMENTARIO_API = 'services/public/comentario.php',
    DETALLEPEDIDO_API = 'services/public/detallepedido.php';
// Constante para establecer el cuerpo de la tabla.
const TABLE_BODY = document.getElementById('tableBody');

const ID_DETALLE = document.getElementById('idDetalle'),
    IDGUARDAR = document.getElementById('idGuardar');

const SAVE_MODAL2 = new bootstrap.Modal('#saveModal'),
    SAVE_FORM2 = document.getElementById('saveForm'),
    INPUTSEARCH = document.getElementById('inputsearch'),
    MODAL_TITLE2 = document.getElementById('modalTitle'),
    COMENTARIO = document.getElementById('contenidoComentario'),
    FECHA_COMENTARIO = document.getElementById('fechaComentario'),
    DIVSTARS = document.getElementById('divstars');
    let timeout_id;

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Historial de compras';
    // Llamada a la función para mostrar los productos del carrito de compras.
    readDetail();
});

// Método del evento para cuando se envía el formulario de agregar un producto al carrito.
SAVE_FORM2.addEventListener('submit', async (event) => {
    event.preventDefault();

    // Obtener el valor de las estrellas seleccionadas
    const selectedStars = document.querySelector('input[name="star-radio"]:checked');
    const starValue = selectedStars ? selectedStars.value : null;

    const FORM = new FormData(SAVE_FORM2);
    // Agregar el valor de las estrellas al FormData
    FORM.append('starValue', 6-starValue);

    const DATA = await fetchData(COMENTARIO_API, 'createRow', FORM);
    

    if (DATA.status) {
        SAVE_MODAL2.hide();
        sweetAlert(1, DATA.message, false);
        readDetail();
        
    } else if (DATA.session) {
        console.log(2);
        sweetAlert(2, DATA.error, false);
    } else {
        console.log(3);
        sweetAlert(3, DATA.error, true);
    }
});

INPUTSEARCH.addEventListener('input', function () {
    clearTimeout(timeout_id);
    timeout_id = setTimeout(async function () {
        readDetail();
    }, 50); // Delay de 50ms
});



/*
*   Función para obtener el detalle del carrito de compras.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function readDetail() {
    const searchInput = document.getElementById('inputsearch').value;

    // Crear un FormData y agregar el valor de búsqueda.
    const formData = new FormData();
    formData.append('valor', searchInput);

    // Petición para obtener los datos del historial.
    const data = await fetchData(PEDIDO_API, 'readHistorials', formData);

    // Se comprueba si la respuesta es satisfactoria.
    if (data.status) {
        // Se inicializa el contenedor de las tarjetas.
        const tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = ''; // Limpiar el contenedor de las tarjetas.

        // Recorrer el conjunto de registros y crear las tarjetas.
        data.dataset.forEach(row => {
            const cardHTML = `
                <div class="col-md-8 mb-4">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-4">
                                <img src="${SERVER_URL}images/productos/${row.imagen}" class="img-fluid rounded" alt="${row.nombre_producto}" style="max-height: 150px; object-fit: cover;">
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <input type="hidden" id="idModelo" name="idModelo" value="${row.id_producto}">
                                    <h5 class="card-title">${row.nombre_producto}</h5>
                                    <p class="card-text">
                                        <strong>Precio:</strong> $${row.precio_unitario}<br>
                                        <strong>Cantidad:</strong> ${row.cantidad}<br>
                                        <strong>Fecha:</strong> ${row.fecha_registro}<br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            tableBody.innerHTML += cardHTML;
        });
    } else {
        sweetAlert(4, data.error, false);
    }
}

// Llamar a la función de búsqueda al hacer clic en el botón de búsqueda.
document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional.
    readDetail(); // Llamar a la función de búsqueda.
});

// Inicializar la búsqueda al cargar la página.
document.addEventListener('DOMContentLoaded', function() {
    readDetail();
});

/*
*   Función para abrir la caja de diálogo con el formulario de cambiar cantidad de producto.
*   Parámetros: id (identificador del producto) y quantity (cantidad actual del producto).
*   Retorno: ninguno.
*/

