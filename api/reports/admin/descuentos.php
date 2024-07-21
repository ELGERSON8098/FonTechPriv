<?php
require_once('../../helpers/report.php');
require_once('../../models/data/producto_data.php');
require_once('../../models/data/descuento_data.php');

// Crear una instancia del objeto Report
$pdf = new Report;
$pdf->startReport('Productos que contienen descuento');

// Crear una instancia de descuentoData
$descuento = new descuentoData;

// Verificar si hay datos de descuentos
if ($dataDescuentos = $descuento->readAll()) {
    // Establecer colores y fuentes para encabezados
    $pdf->SetFillColor(0, 153, 153); // Verde para encabezados
    $pdf->SetTextColor(255, 255, 255); // Texto blanco para encabezados
    $pdf->SetFont('Arial', 'B', 12);

    // Encabezados de la tabla
    $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
    $pdf->Cell(40, 10, 'Descuento (%)', 1, 0, 'C', 1);
    $pdf->Cell(40, 10, 'Precio Final (US$)', 1, 0, 'C', 1);
    $pdf->Cell(30, 10, 'Estado', 1, 1, 'C', 1);

    // Establecer colores y fuentes para datos de productos
    $pdf->SetFillColor(230); // Color de fondo para datos
    $pdf->SetTextColor(0); // Restablecer color de texto a negro
    $pdf->SetFont('Arial', '', 11);

    // Recorrer los descuentos
    foreach ($dataDescuentos as $rowDescuento) {
        // Título de categoría
        $pdf->Cell(180, 10, utf8_decode('Descuento: ' . $rowDescuento['nombre_descuento']), 1, 1, 'L', 1);

        // Crear una instancia de ProductoData
        $producto = new ProductoData;

        // Establecer la categoría
        if ($producto->setCategoria1($rowDescuento['id_oferta'])) {
            // Obtener los productos con descuento
            if ($dataProductos = $producto->productosConDescuento()) {
                // Recorrer los productos
                foreach ($dataProductos as $rowProducto) {
                    // Calcular el estado y el precio final
                    $estado = ($rowProducto['estado_producto']) ? 'Activo' : 'Inactivo';
                    $precioFinal = $rowProducto['precio'] * (1 - ($rowProducto['valor_oferta'] / 100));

                    // Datos de productos
                    $pdf->Cell(40, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0, 'L');
                    $pdf->Cell(30, 10, '$' . number_format($rowProducto['precio'], 2, '.', ','), 1, 0, 'R');
                    $pdf->Cell(40, 10, $rowProducto['valor_oferta'] . '%', 1, 0, 'R');
                    $pdf->Cell(40, 10, '$' . number_format($precioFinal, 2, '.', ','), 1, 0, 'R');
                    $pdf->Cell(30, 10, utf8_decode($estado), 1, 1, 'C');
                }
            } else {
                // Mensaje si no hay productos
                $pdf->Cell(180, 10, utf8_decode('No hay productos para este descuento'), 1, 1, 'C');
            }
        } else {
            // Mensaje si la categoría no existe
            $pdf->Cell(180, 10, utf8_decode('Categoría incorrecta o inexistente'), 1, 1, 'C');
        }
    }

} else {
    // Mensaje si no hay categorías
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, utf8_decode('No hay descuento para mostrar'), 0, 1, 'C');
}

// Salida del documento
$pdf->Output('I', 'descuentos.pdf');
?>
