function confirmarCompra() {
    Swal.fire({
        title: '¿Estás seguro de comprar?',
        text: 'Una vez confirmada, no podrás cancelar esta acción.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, comprar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes agregar la lógica para procesar la compra
            // Por ejemplo, redireccionar a una página de confirmación de compra
            window.location.href = '../publica/HistorialDeCompras.html';
        }
    });
}