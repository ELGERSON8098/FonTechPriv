/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idusuarioC', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(USUARIO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Actualizar cliente';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_USUARIO.value = ROW.id_usuario;
        NOMBRE_USUARIO.value = ROW.nombre;
        ALIAS_USUARIO.value = ROW.usuario;
        CORREO_USUARIO.value = ROW.correo;
        ;
    } else {
        sweetAlert(2, DATA.error, false);
    }
};
