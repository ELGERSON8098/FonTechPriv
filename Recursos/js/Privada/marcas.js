// Definir la función fetchData para realizar la llamada a la API
const fetchData = async (url) => {
    try {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error al obtener datos:', error);
        return { status: 0, error: 'Error al obtener datos' };
    }
};

// Función para eliminar una marca
// Función para eliminar una marca
const deleteBrand = async (brandId) => {
    try {
        if (!brandId) {
            throw new Error('ID de marca no proporcionado');
        }

        const url = `http://localhost/FonTechPriv/api/Privada/Marcas.PHP?id=${brandId}`;
        
        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json', // Asegúrate de ajustar el tipo de contenido según tu API
            },
        });

        if (!response.ok) {
            throw new Error(`Error al eliminar la marca con ID ${brandId}: ${response.statusText}`);
        }

        const data = await response.json();

        if (data.status === 1) {
            console.log(`Marca con ID ${brandId} eliminada correctamente.`);
            // Si la eliminación es exitosa, puedes hacer alguna acción adicional aquí si es necesario
        } else {
            console.error(`Error al eliminar la marca con ID ${brandId}: ${data.error || 'Error desconocido'}`);
        }
    } catch (error) {
        console.error('Error al eliminar la marca:', error.message);
    }
};

// Maneja el evento 'DOMContentLoaded' del documento
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la sección de marcas.
    fillBrands();
});

const fillBrands = async () => {
    // Realiza la llamada a la API para obtener las marcas
    const brandsData = await fetchData('http://localhost/FonTechPriv/api/Privada/Marcas.PHP');

    // Verifica si la llamada a la API fue exitosa
    if (brandsData.status === 1) {
        // Obtiene el contenedor de información de las marcas
        const brandsContainer = document.getElementById('brandsContainer');

        // Muestra el nombre y botones de cada marca
        brandsData.data.forEach((brand, index) => {
            // Crea un nuevo div para cada marca
            const brandDiv = createBrandDiv(brand, index);

            // Agrega el div de la marca al contenedor
            brandsContainer.appendChild(brandDiv);
        });

        // Configura el manejador de eventos para el botón "Eliminar" en la ventana modal
        setupDeleteButton();
    } else {
        // Manejar el caso en que la llamada a la API no sea exitosa
        console.error('Error al obtener datos de marcas');
    }
};

// En la función createBrandDiv
// En el método createBrandDiv, asegúrate de que el data-brand-id se establezca correctamente
const createBrandDiv = (brand, index) => {
    const brandDiv = document.createElement('div');
    brandDiv.className = 'col-md-6 col-lg-4 col-xl-3 p-2';

    // Llena el contenido del div de la marca
    brandDiv.innerHTML = `
        <div class="special-img position-relative overflow-hidden">
            <img src="https://img-prd-pim.poorvika.com/prodvarval/Apple-iphone-15-pro-Max-Natural-titanium-Front-Back-View-Thumbnail.png" class="w-100">
        </div>
        <div class="text-center text-capitalize mt-3 mb-1">
            <p id="nombreMarca${index + 1}">${brand.nombre_Marca}</p>
            <a href="#" class="btn btn-primary mt-3 delete-brand" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-brand-id="${brand.id_Marca_Fon}" data-container-id="nombreMarca${index + 1}">Eliminar</a>
        </div>
    `;

    return brandDiv;
};


// En la función setupDeleteButton
// En la función setupDeleteButton
const setupDeleteButton = () => {
    const deleteButtons = document.querySelectorAll('.delete-brand');

    deleteButtons.forEach((deleteButton) => {
        deleteButton.addEventListener('click', async () => {
            const brandId = deleteButton.getAttribute('data-brand-id');
            const containerId = deleteButton.getAttribute('data-container-id');

            // Verifica que brandId tenga un valor antes de realizar la solicitud DELETE
            if (brandId) {
                // Actualiza el ID de la marca en el botón de confirmación de eliminación
                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                confirmDeleteBtn.setAttribute('data-brand-id', brandId);

                // Remueve la marca del contenedor en la página
                const brandContainer = document.getElementById(containerId);
                if (brandContainer) {
                    brandContainer.remove();
                } else {
                    console.error(`No se encontró el contenedor con ID ${containerId}`);
                }
            } else {
                console.error('ID de marca no proporcionado');
            }
        });
    });
};

// Actualiza el evento click del botón de confirmación de eliminación
document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
    const brandId = document.getElementById('confirmDeleteBtn').getAttribute('data-brand-id');

    if (brandId) {
        // Llamada a la función para eliminar la marca
        await deleteBrand(brandId);
    } else {
        console.error('ID de marca no proporcionado');
    }
});



const deleteBrand1 = async (brandId) => {
    try {
        if (!brandId) {
            throw new Error('ID de marca no proporcionado');
        }

        // Resto del código...
    } catch (error) {
        console.error('Error al eliminar la marca:', error.message);
    }
};

