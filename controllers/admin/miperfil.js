function validarNumero(input) {
    // Eliminar cualquier caracter que no sea un número
    input.value = input.value.replace(/\D/g, '');
}