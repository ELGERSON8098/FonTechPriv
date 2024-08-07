<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idMarca'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/marca_data.php');
    require_once('../../models/data/producto_data.php');
    // Se instancian las entidades correspondientes.
    $marca = new marcaData;
    $producto = new ProductoData;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($marca->setId($_GET['idMarca']) && $producto->setCategorias($_GET['idMarca'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowMarca = $marca->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de la marca ' . $rowMarca['marca']);

            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosMarca()) {
                // Se establece un color de relleno para los encabezados y color de texto blanco.
                $pdf->setFillColor(0, 153, 153);
                $pdf->setTextColor(255, 255, 255); // Blanco para el texto de los encabezados
                $pdf->setFont('Arial', 'B', 11);
                $pdf->cell(125, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

                // Se establece la fuente para los datos de los productos y color de texto negro.
                $pdf->setTextColor(0, 0, 0); // Negro para el texto de los datos
                $pdf->setFont('Arial', '', 11);
                
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    $estado = ($rowProducto['estado_producto']) ? 'Activo' : 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(125, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                // No hay productos para mostrar
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la marca'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Marca.pdf');
        } else {
            // Marca inexistente
            print('Marca inexistente');
        }
    } else {
        // Marca incorrecta
        print('Marca incorrecta');
    }
} else {
    // Debe seleccionar una marca
    print('Debe seleccionar una marca');
}
?>
