<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Cabecera del PDF
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'Reporte del Alumno',0,1,'C');
        $this->Ln(5);
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

// Obtener los datos del alumno
$numero = $_GET['numero'];
$matricula = $_GET['matricula'];
$nombre = $_GET['nombre'];
$aPaterno = $_GET['aPaterno'];
$aMaterno = $_GET['aMaterno'];
$idGrado = $_GET['idGrado'];

// Mostrar los datos en el PDF
$pdf->Cell(0,10,'Número: '.$numero,0,1);
$pdf->Cell(0,10,'Matrícula: '.$matricula,0,1);
$pdf->Cell(0,10,'Nombre: '.$nombre,0,1);
$pdf->Cell(0,10,'Apellido Paterno: '.$aPaterno,0,1);
$pdf->Cell(0,10,'Apellido Materno: '.$aMaterno,0,1);
$pdf->Cell(0,10,'Grado y Grupo: '.$idGrado,0,1);

// Salida del PDF
$pdf->Output();
?>
