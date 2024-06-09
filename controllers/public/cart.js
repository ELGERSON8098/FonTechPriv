// Constante para completar la ruta de la API.
const PEDIDO_API = 'services/public/pedido.php';
// Constante para establecer el cuerpo de la tabla.
const TABLE_BODY = document.getElementById('tableBody');
// Constante para establecer la caja de diálogo de cambiar producto.
const ITEM_MODAL = new bootstrap.Modal('#itemModal');
// Constante para establecer el formulario de cambiar producto.
const ITEM_FORM = document.getElementById('itemForm');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Carrito de compras';
    // Llamada a la función para mostrar los productos del carrito de compras.
    readDetail();
});

// Método del evento para cuando se envía el formulario de cambiar cantidad de producto.
ITEM_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(ITEM_FORM);
    // Petición para actualizar la cantidad de producto.
    const DATA = await fetchData(PEDIDO_API, 'updateDetail', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se actualiza la tabla para visualizar los cambios.
        readDetail();
        // Se cierra la caja de diálogo del formulario.
        ITEM_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función para obtener el detalle del carrito de compras.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function readDetail() {
    const DATA = await fetchData(PEDIDO_API, 'readDetail');
    if (DATA.status) {
        TABLE_BODY.innerHTML = '';
        let total = 0;
        DATA.dataset.forEach(row => {
            let subtotal;
            if (row.valor_oferta !== null) {
                subtotal = (row.precio_unitario - row.valor_oferta) * row.cantidad; // Calcular subtotal con oferta
            } else {
                subtotal = row.precio_unitario * row.cantidad; // Calcular subtotal sin oferta
            }
            total += subtotal;
            // Crear y concatenar las filas de la tabla con los datos de cada registro
            TABLE_BODY.innerHTML += `
                <tr>
                    <td>${row.nombre_producto}</td>
                    <td>${row.precio_unitario}</td>
                    <td>${row.cantidad}</td>
                    <td>${row.valor_oferta !== null ? row.valor_oferta : 'No tiene oferta'}</td>
                    <td>${subtotal.toFixed(2)}</td>
                    <td>
                        <button type="button" onclick="openUpdate(${row.id_detalle_reserva}, ${row.cantidad}, ${row.id_producto})" class="btn btn-info">
                            <i class="bi bi-plus-slash-minus"></i>
                        </button>
                        <button type="button" onclick="openDelete(${row.id_detalle_reserva})" class="btn btn-danger">
                            <i class="bi bi-cart-dash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        // Mostrar el total a pagar con dos decimales
        document.getElementById('pago').textContent = total.toFixed(2);
    } else {
        sweetAlert(4, DATA.error, false, 'index.html');
    }
}

/*
*   Función para abrir la caja de diálogo con el formulario de cambiar cantidad de producto.
*   Parámetros: id (identificador del producto), quantity (cantidad actual del producto), productId (identificador del producto).
*   Retorno: ninguno.
*/
function openUpdate(id, quantity) {
    // Se abre la caja de diálogo que contiene el formulario.
    ITEM_MODAL.show();
    // Se inicializan los campos del formulario con los datos del registro seleccionado.
    document.getElementById('idDetalle').value = id;
    document.getElementById('cantidadProducto').value = quantity;
}

/*
*   Función asíncrona para mostrar un mensaje de confirmación al momento de finalizar el pedido.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function finishOrder() {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de finalizar el pedido?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Petición para finalizar el pedido en proceso.
        const DATA = await fetchData(PEDIDO_API, 'finishOrder');
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            sweetAlert(1, DATA.message, true, 'index.html');
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}

/*
*   Función asíncrona para mostrar un mensaje de confirmación al momento de eliminar un producto del carrito.
*   Parámetros: id (identificador del producto).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de remover el producto?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define un objeto con los datos del producto seleccionado.
        const FORM = new FormData();
        FORM.append('idDetalle', id);
        // Petición para eliminar un producto del carrito de compras.
        const DATA = await fetchData(PEDIDO_API, 'deleteDetail', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            readDetail();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}

