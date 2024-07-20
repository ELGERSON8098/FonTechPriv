<?php
require_once('../../helpers/reportPublic.php');
require_once('../../models/data/producto_data.php');
require_once('../../models/data/categoria_data.php');

$pdf = new Report;
$pdf->startReport('Productos por categoría');

$categoria = new CategoriaData;

if ($dataCategorias = $categoria->readAll()) {
    // Establecer colores y fuentes para encabezados
    $pdf->setFillColor(0, 153, 153); // Verde para encabezados
    $pdf->setTextColor(255, 255, 255); // Texto blanco para encabezados
    $pdf->setFont('Arial', 'B', 12);

    // Encabezados de la tabla
    $pdf->cell(100, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Precio (US$)', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Estado', 1, 1, 'C', 1);

    // Establecer colores y fuentes para datos de productos
    $pdf->setFillColor(230); // Color de fondo para datos
    $pdf->setTextColor(0); // Restablecer color de texto a negro
    $pdf->setFont('Arial', '', 11);

    foreach ($dataCategorias as $rowCategoria) {
        // Título de categoría
        $pdf->cell(180, 10, utf8_decode('Categoría: ' . $rowCategoria['nombre_categoria']), 1, 1, 'L', 1);

        $producto = new ProductoData;

        if ($producto->setCategoria($rowCategoria['id_categoria'])) {
            if ($dataProductos = $producto->productosCategoria()) {
                foreach ($dataProductos as $rowProducto) {
                    $estado = ($rowProducto['estado_producto']) ? 'Activo' : 'Inactivo';
                    $totalProducto = $rowProducto['precio'] * 1; // Ajustar la lógica según sea necesario

                    // Datos de productos
                    $pdf->cell(100, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0, 'L');
                    $pdf->cell(40, 10, '$' . number_format($rowProducto['precio'], 2, '.', ','), 1, 0, 'R');
                    $pdf->cell(40, 10, utf8_decode($estado), 1, 1, 'C');
                }
            } else {
                // Mensaje si no hay productos
                $pdf->cell(180, 10, utf8_decode('No hay productos para esta categoría'), 1, 1, 'C');
            }
        } else {
            // Mensaje si la categoría no existe
            $pdf->cell(180, 10, utf8_decode('Categoría incorrecta o inexistente'), 1, 1, 'C');
        }
    }

} else {
    // Mensaje si no hay categorías
    $pdf->setFont('Arial', 'B', 14);
    $pdf->cell(0, 10, utf8_decode('No hay categorías para mostrar'), 1, 1, 'C');
}

// Salida del documento
$pdf->output('I', 'factura.pdf');
