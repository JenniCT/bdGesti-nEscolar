<?php
require_once('tcpdf/tcpdf.php');

// Crear instancia de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Title');
$pdf->SetSubject('Subject');

// Agregar una página
$pdf->AddPage();

// Conexión a la base de datos
$$conexion = new mysqli("localhost", "root", "i27bg2hhV_", "bd_gestionescolar");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener los registros de la tabla
$sql = "SELECT * FROM tu_tabla";
$resultado = $conexion->query($sql);

// Crear tabla en el PDF
$pdf->SetFont('times', '', 12);
$pdf->Cell(10, 10, 'Número', 1, 0, 'C');
$pdf->Cell(30, 10, 'Matrícula', 1, 0, 'C');
$pdf->Cell(50, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(40, 10, 'Apellido Paterno', 1, 0, 'C');
$pdf->Cell(40, 10, 'Apellido Materno', 1, 0, 'C');
$pdf->Cell(20, 10, 'Grado y Grupo', 1, 1, 'C');

// Recorrer los resultados de la consulta y agregar cada fila a la tabla del PDF
while ($fila = $resultado->fetch_assoc()) {
    $pdf->Cell(10, 10, $fila['numero'], 1, 0, 'C');
    $pdf->Cell(30, 10, $fila['Matricula'], 1, 0, 'C');
    $pdf->Cell(50, 10, $fila['Nombre'], 1, 0, 'C');
    $pdf->Cell(40, 10, $fila['aPaterno'], 1, 0, 'C');
    $pdf->Cell(40, 10, $fila['aMaterno'], 1, 0, 'C');
    $pdf->Cell(20, 10, $fila['idGrado'], 1, 1, 'C');
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Salida del PDF
$pdf->Output('example.pdf', 'I');
