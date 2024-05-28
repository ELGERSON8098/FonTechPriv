// Constante para completar la ruta de la API.
const CATEGORIA_API = 'services/public/categoria.php';
// Constante para establecer el contenedor de categorías.
const CATEGORIAS = document.getElementById('special');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Productos por categoría';
    // Petición para obtener las categorías disponibles.
    const DATA = await fetchData(CATEGORIA_API, 'readAll');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se inicializa el contenedor de categorías.
        CATEGORIAS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se establece la página web de destino con los parámetros.
            let url = `products.html?id=${row.id_categoria}&nombre=${row.nombre_categoria}`;
            // Se crean y concatenan las tarjetas con los datos de cada categoría.
            CATEGORIAS.innerHTML += `
        <div class="col-md-6 col-lg-4 col-xl-3 p-2">
                <div class="special-img position-relative overflow-hidden">
                    <img src="${SERVER_URL}images/categorias/${row.imagen}" class="card-img-top" alt="${row.nombre_categoria}" class="w-100">
                </div>
            <div class="text-center">
                <p class="fw-bold d-block mt-3 mb-1"> ${row.nombre_categoria}</p>
                <a href="${url}" class="btn btn-primary mt-3">Ver productos</a>
            </div>
        </div>
            `;
        });
    } else {
        // Se asigna al título del contenido de la excepción cuando no existen datos para mostrar.
        document.getElementById('mainTitle').textContent = DATA.error;
    }
});