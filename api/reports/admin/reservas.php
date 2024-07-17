<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['idReserva'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/reserva_data.php');
    // Se instancian las entidades correspondientes.
    $reserva = new reservaData;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($reserva->setIdReserva($_GET['idReserva'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowReserva= $reserva->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos reservados por el cliente ' . $rowReserva['nombre_usuario']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataReservas = $reserva->readDetails()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(50, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(50, 10, 'Cantidad', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Arial', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataReservas as $rowReserva) {
                    ($rowReserva['estado_reserva']) ? $estado = 'Aceptado' : $estado = 'Pendiente';
                    // Se imprimen las celdas con los datos de los productos.
                    
                    $pdf->cell(50, 10, $pdf->encodeString($rowReserva['nombre_producto']), 1, 0);
                    $pdf->cell(50, 10, $rowReserva['cantidad'], 1, 0);
                    $pdf->cell(30, 10, $rowReserva['precio_unitario'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos reservados'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Reservas.pdf');
        } else {
            print('Reservas inexistente');
        }
    } else {
        print('Reservas incorrecta');
    }
} else {
    print('Debe seleccionar una reserva');
}