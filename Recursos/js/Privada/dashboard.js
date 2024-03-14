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