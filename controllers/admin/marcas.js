document.addEventListener('DOMContentLoaded', () => {
    fillMarcas();
});

async function fillMarcas() {
    try {
        // Aquí debes realizar una solicitud fetch para obtener las marcas desde tu API
        // Reemplaza 'ruta_del_php' con la ruta correcta a tu archivo PHP que obtiene las marcas
        const response = await fetch('../../api/models/data/marca_data.php?action=readAll');
        const data = await response.json();
        if (data.status === 1) {
            const marcas = data.dataset;
            const specialList = document.querySelector('.special-list');
            specialList.innerHTML = ''; // Limpiamos el contenido anterior para evitar duplicados

            for (const marca of marcas) {
                specialList.innerHTML += `
                    <div class="col-md-6 col-lg-4 col-xl-3 p-2">
                        <div class="special-img position-relative overflow-hidden">
                            <img src="${marca.imagen}" class="w-100">
                        </div>
                        <div class="text-center">
                            <p class="text-capitalize mt-3 mb-1">${marca.nombre}</p>
                            <button class="btn btn-primary mt-3" onclick="openUpdate(${marca.id})">Editar</button>
                            <button class="btn btn-primary mt-3" onclick="openDelete(${marca.id})">Eliminar</button>
                        </div>
                    </div>
                `;
            }
        } else {
            console.error('Error al cargar las marcas:', data.error);
        }
    } catch (error) {
        console.error('Error al obtener las marcas:', error.message);
    }
}

// Función para abrir el modal de edición
function openUpdate(id) {
    // Aquí puedes abrir el modal de edición y realizar cualquier acción necesaria
    console.log('Abrir modal de edición para el ID:', id);
}

// Función para abrir el modal de eliminación
function openDelete(id) {
    // Aquí puedes abrir el modal de eliminación y realizar cualquier acción necesaria
    console.log('Abrir modal de eliminación para el ID:', id);
}
