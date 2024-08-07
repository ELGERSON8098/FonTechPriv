<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idCategoria'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/categoria_data.php');
    require_once('../../models/data/producto_data.php');
    // Se instancian las entidades correspondientes.
    $categoria = new CategoriaData;
    $producto = new ProductoData;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($categoria->setId($_GET['idCategoria']) && $producto->setCategoria($_GET['idCategoria'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowCategoria = $categoria->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de la categoría ' . $rowCategoria['nombre_categoria']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosCategoria()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->SetFillColor(0, 153, 153); // Color RGB (153, 153, 153)
                // Se establece la fuente para los encabezados.
                $pdf->SetFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->SetTextColor(255, 255, 255); // Color blanco
                $pdf->Cell(125, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->Cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->Cell(30, 10, 'Estado', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->SetFont('Arial', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se establece el color del texto a negro para los datos de productos.
                    $pdf->SetTextColor(0, 0, 0); // Color negro
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->Cell(125, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->Cell(30, 10, $rowProducto['precio'], 1, 0);
                    $pdf->Cell(30, 10, $estado, 1, 1);
                }
            } else {
                // No hay productos para la categoría
                $pdf->SetTextColor(0, 0, 0); // Color negro
                $pdf->Cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->Output('I', 'categoria.pdf');
        } else {
            // Categoría inexistente
            print('Categoría inexistente');
        }
    } else {
        // Categoría incorrecta
        print('Categoría incorrecta');
    }
} else {
    // Debe seleccionar una categoría
    print('Debe seleccionar una categoría');
}
?>
