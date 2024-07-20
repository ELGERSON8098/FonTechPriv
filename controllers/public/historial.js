const PEDIDO_API = 'services/public/pedido.php';

// Constantes para el cuerpo de la tabla y elementos del formulario.
const TABLE_BODY = document.getElementById('tableBody');
const INPUTSEARCH = document.getElementById('inputsearch');
const ID_RESERVA = document.getElementById('idReserva');

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
INPUTSEARCH.addEventListener('input', function () {
    clearTimeout(timeout_id);
    timeout_id = setTimeout(async function () {
        readDetail();
    }, 50); // Delay de 50ms
});

const openReport = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/public/factura.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}

/*
*   Función para obtener el detalle del carrito de compras.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function readDetail() {
    // Petición para obtener los datos del pedido en proceso.
    const FORM = new FormData();
    FORM.append('valor', INPUTSEARCH.value); //

    const DATA = await fetchData(PEDIDO_API, 'readHistorials', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se inicializa el cuerpo de la tabla.
        TABLE_BODY.innerHTML = '';
        // Se declara e inicializa una variable para calcular el importe por cada producto.
        let subtotal = 0;
        // Se declara e inicializa una variable para sumar cada subtotal y obtener el monto final a pagar.
        let total = 0;
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(async row => {
            subtotal = row.precio_unitario * row.cantidad;
            total += subtotal;

            TABLE_BODY.innerHTML += `
<div class="container">
<div class="row justify-content-center">
<!-- Comienzo de las tarjetas -->
<div class="col-8 mb-4">
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
<!-- Puedes duplicar este bloque div.col-8 mb-4 para cada tarjeta adicional -->
</div>
</div>
`;
        });
    } else {
        sweetAlert(4, DATA.error, false);
    }
}