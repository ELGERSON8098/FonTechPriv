<?php
require_once('../../helpers/report.php');
require_once('../../models/data/producto_data.php');
require_once('../../models/data/descuento_data.php');

$pdf = new Report;
$pdf->startReport('Productos que contienen descuento');

$descuento = new descuentoData;

if ($dataDescuentos = $descuento->readAll()) {
    // Establecer colores y fuentes para encabezados
    $pdf->setFillColor(0, 153, 153); // Verde para encabezados
    $pdf->setTextColor(255, 255, 255); // Texto blanco para encabezados
    $pdf->setFont('Arial', 'B', 12);

    // Encabezados de la tabla
    $pdf->cell(40, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Descuento (%)', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Precio Final (US$)', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Establecer colores y fuentes para datos de productos
    $pdf->setFillColor(230); // Color de fondo para datos
    $pdf->setTextColor(0); // Restablecer color de texto a negro
    $pdf->setFont('Arial', '', 11);

    foreach ($dataDescuentos as $rowDescuento) {
        // Título de categoría
        $pdf->cell(180, 10, utf8_decode('Descuento: ' . $rowDescuento['nombre_descuento']), 1, 1, 'L', 1);

        $producto = new ProductoData;

        if ($producto->setCategoria1($rowDescuento['id_oferta'])) {
            if ($dataProductos = $producto->productosConDescuento()) {
                foreach ($dataProductos as $rowProducto) {
                    $estado = ($rowProducto['estado_producto']) ? 'Activo' : 'Inactivo';
                    $precioFinal = $rowProducto['precio'] * (1 - ($rowProducto['valor_oferta'] / 100));

                    // Datos de productos
                    $pdf->cell(40, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0, 'L');
                    $pdf->cell(30, 10, '$' . number_format($rowProducto['precio'], 2, '.', ','), 1, 0, 'R');
                    $pdf->cell(40, 10, $rowProducto['valor_oferta'] . '%', 1, 0, 'R');
                    $pdf->cell(40, 10, '$' . number_format($precioFinal, 2, '.', ','), 1, 0, 'R');
                    $pdf->cell(30, 10, utf8_decode($estado), 1, 1, 'C');
                }
            } else {
                // Mensaje si no hay productos
                $pdf->cell(180, 10, utf8_decode('No hay productos para este descuento'), 1, 1, 'C');
            }
        } else {
            // Mensaje si la categoría no existe
            $pdf->cell(180, 10, utf8_decode('Categoría incorrecta o inexistente'), 1, 1, 'C');
        }
    }

} else {
    // Mensaje si no hay categorías
    $pdf->setFont('Arial', 'B', 14);
    $pdf->cell(0, 10, utf8_decode('No hay descuento para mostrar'), 1, 1, 'C');
}

// Salida del documento
$pdf->output('I', 'descuentos.pdf');
