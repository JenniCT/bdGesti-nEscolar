<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Cabecera del PDF
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'Reporte de Alumnos',0,1,'C');
        $this->Ln(10);
    }

    function Footer()
    {
        // Pie de página
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Creación del objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "i27bg2hhV_", "bd_gestionescolar");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener todos los alumnos
$sql = "SELECT * FROM t_alumnos";
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Crear la tabla de alumnos en el PDF
    $pdf->Cell(10, 10, 'No.', 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode('Matrícula'), 1, 0, 'C');
    $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Apellido Paterno', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Apellido Materno', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Grado y Grupo', 1, 1, 'C');

    // Mostrar los datos de cada alumno en la tabla
    while ($fila = $resultado->fetch_assoc()) {
        $pdf->Cell(10, 10, $fila['numero'], 1, 0, 'C');
        $pdf->Cell(30, 10, utf8_decode($fila['Matricula']), 1, 0, 'C');
        $pdf->Cell(40, 10, utf8_decode($fila['Nombre']), 1, 0, 'C');
        $pdf->Cell(40, 10, utf8_decode($fila['aPaterno']), 1, 0, 'C');
        $pdf->Cell(40, 10, utf8_decode($fila['aMaterno']), 1, 0, 'C');
        $pdf->Cell(30, 10, utf8_decode($fila['idGrado']), 1, 1, 'C');
    }
} else {
    // No se encontraron alumnos
    $pdf->Cell(0, 10, 'No se encontraron alumnos.', 0, 1);
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Salida del PDF
$pdf->Output();
?>
