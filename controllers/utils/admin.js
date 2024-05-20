/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar la plantilla del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/admin/administrador.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
MAIN.style.paddingTop = '75px';
MAIN.style.paddingBottom = '100px';
MAIN.classList.add('container');
// Constante para establecer el elemento del título principal.
const MAIN_TITLE = document.getElementById('mainTitle');
MAIN_TITLE.classList.add('text-center', 'py-3');

/*  Función asíncrona para cargar el encabezado y pie del documento.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (DATA.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
        <header>
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top">
          <div class="container">
              <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0"
                  href="../admin/dashboard.html">
                  <img src="../../Recursos/img/image 67.png" class="logo img-fluid" alt="site icon">
              </a>
      
              <div class="order-lg-2 nav-btns">
               <a href="../admin/miperfil.html" class="btn position-relative">
                 <i class="fa fa-user"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge bg-primary"></span>
               </a>
              </div>
      
              <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                  <span class="navbar-toggler-icon"></span>
              </button>
      
              <div class="collapse navbar-collapse order-lg-1" id="navMenu">
                  <ul class="navbar-nav mx-auto text-center">
                      <li class="nav-item px-2 py-2">
                          <a class="nav-link text-uppercase text-dark" href="../admin/Catalogo.html">Catalogos</a>
                      </li>
                      <li class="nav-item px-2 py-2 dropdown">
                        <a class="nav-link text-uppercase text-dark dropdown-toggle" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Productos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="productosDropdown">
                        <li><a class="dropdown-item" href="../admin/productos.html">Productos</a></li>
                        <li><a class="dropdown-item" href="../admin/ofertas.html">Descuentos</a></li>
                        </ul>
                    </li>
                      <li class="nav-item px-2 py-2">
                          <a class="nav-link text-uppercase text-dark" href="../admin/Marcas.html">Marcas</a>
                      </li>
                      <li class="nav-item px-2 py-2">
                          <a class="nav-link text-uppercase text-dark" href="../admin/clientes.html">Clientes</a>
                      </li>
                      <li class="nav-item px-2 py-2">
                          <a class="nav-link text-uppercase text-dark" href="../admin/Reservas.html">Reservas</a>
                      </li>
                      <li class="nav-item px-2 py-2">
                      <a class="nav-link text-uppercase text-dark" href="../admin/Valoraciones.html">Valoraciones</a>
                      </li>
                      <li class="nav-item px-2 py-2 dropdown">
                        <a class="nav-link text-uppercase text-dark dropdown-toggle" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Direcciones
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="productosDropdown">
                        <li><a class="dropdown-item" href="../admin/departamentos.html">Departamentos</a></li>
                        <li><a class="dropdown-item" href="../admin/municipios.html">Municipios</a></li>
                        <li><a class="dropdown-item" href="../admin/distritos.html">Distritos</a></li>
                        </ul>
                    </li>
                  </ul>
              </div>
              </a>
          </div>
      </nav>
      <!-- Fin del navbar -->
    </header>
    <br>`);
            // Se agrega el pie de la página web después del contenido principal.
            MAIN.insertAdjacentHTML('afterend', ``);
        } else {
            sweetAlert(3, DATA.error, false, 'index.html');
        }
    } else {
        // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión.
        if (location.pathname.endsWith('index.html')) {
            // Se agrega el pie de la página web después del contenido principal.
            MAIN.insertAdjacentHTML('afterend', `
           `);
        } else {
            location.href = 'index.html';
        }
    }
}
