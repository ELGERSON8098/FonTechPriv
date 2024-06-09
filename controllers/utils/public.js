/*
*   Controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/public/cliente.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
MAIN.style.paddingTop = '75px';
MAIN.style.paddingBottom = '100px';
MAIN.classList.add('container');
// Se establece el título de la página web.
document.querySelector('title').textContent = 'Fontech';
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
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (DATA.session) {
        // Se verifica si la página web no es el inicio de sesión, de lo contrario se direcciona a la página web principal.
        if (!location.pathname.endsWith('login.html')) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top">
        <div class="container">
        <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0"
        href="../public/index.html">
        <img src="../../resources/img/image 67.png" class="logo img-fluid" alt="site icon">
    </a>
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
               <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.html"><i class="bi bi-shop"></i> Catálogo</a>
                <a class="nav-link" href="cart.html"><i class="bi bi-cart"></i> Carrito</a>
                <a class="nav-link" href="historial.html"><i class="bi bi-clock-history"></i> Historial</a>
                <br>
                <div class="order-lg-2 nav-btns">
                    <a href="../public/miperfil.html" class="btn position-relative mb-3">
                    <i class="bi bi-person-circle"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-primary"></span>
                </a>
                </div>
                <a class="nav-link" href="#" onclick="logOut()"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a>
                </div>
            </div>
        </div>
    </nav>
    </header>
            `);
        } else {
            location.href = 'index.html';
        }
    } else {
        // Se agrega el encabezado de la página web antes del contenido principal.
        MAIN.insertAdjacentHTML('beforebegin', `
            <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top">
                    <div class="container">
                    <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0"
                    href="../public/index.html">
                    <img src="../../resources/img/image 67.png" class="logo img-fluid" alt="site icon">
                </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav ms-auto">
                                <a class="nav-link" href="index.html"><i class="bi bi-shop"></i> Catálogo</a>
                                <a class="nav-link" href="signup.html"><i class="bi bi-person"></i> Crear cuenta</a>
                                <a class="nav-link" href="login.html"><i class="bi bi-box-arrow-right"></i> Iniciar sesión</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
        `);
    }
    // Se agrega el pie de la página web después del contenido principal.
    MAIN.insertAdjacentHTML('afterend', `
        <footer class="bg-dark py-5">
            <div class="container">
                <div class="row text-white g-4">
                    <div class="col-md-6 col-lg-3">
                        <h5 class="fw-light text-white">Información</h5>
                        <ul class="list-unstyled">
                            <li class="my-3">
                                <a href="#" class="text-white text-decoration-none">
                                    <i class="me-1"></i> Sobre Nosotros
                                </a>
                            </li>
                            <li class="my-3">
                                <a href="#" class="text-white text-decoration-none">
                                    <i class="me-1"></i> Términos y Condiciones
                                </a>
                            </li>
                        </ul>
                    </div>
    
                    <div class="col-md-6 col-lg-3">
                        <h5 class="fw-light mb-3 text-white">Contáctanos</h5>
                        <div class="d-flex justify-content-start align-items-start my-2">
                            <span class="me-3 text-white">
                                <i class="fas fa-map-marked-alt"></i>
                            </span>
                            <span class="fw-light text-white">
                                San Salvador, Colonia Escalon, Edificio Don Pepe
                            </span>
                        </div>
                        <div class="d-flex justify-content-start align-items-start my-2">
                            <span class="me-3 text-white">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <span class="fw-light text-white">
                                Fontech503@gmail.com.sv
                            </span>
                        </div>
                        <div class="d-flex justify-content-start align-items-start my-2">
                            <span class="me-3 text-white">
                                <i class="fas fa-phone-alt"></i>
                            </span>
                            <span class="fw-light text-white">
                                63058048
                            </span>
                        </div>
                    </div>
    
                    <div class="col-md-6 col-lg-3">
                        <h5 class="fw-light mb-3 text-white">Síguenos en nuestras redes sociales</h5>
                        <div>
                            <ul class="list-unstyled d-flex">
                                <li>
                                    <a href="#" class="text-white text-decoration-none fs-4 me-4">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-white text-decoration-none fs-4 me-4">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-white text-decoration-none fs-4 me-4">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    `);    
}