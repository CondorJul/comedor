<?php 
$parametros=null;
if (isset($_GET['parametros'])) {
    $parametros = unserialize($_GET['parametros']);    
}
$arrayAcademico=$parametros['academico'];
$arrayAlumno=$parametros['alumno'];
$mes=null;
switch ($arrayAcademico['mes']) {
    case 1:
       $mes="Enero";
        break;
    case 2:
        $mes="Febrero";
        break;
    case 3:
        $mes="Marzo";
        break;
    case 4:
        $mes="Abril";
        break;
    case 5:
        $mes="Mayo";
        break;    
    case 6:
        $mes="Junio";
        break;
    case 7:
        $mes="Julio";
        break;
    case 8:
        $mes="Agosto";
        break;
    case 9:
        $mes="Septiembre";
        break;
    case 10:
        $mes="Octubre";
        break;
    case 11:
        $mes="Noviembre";
        break;
    case 12:
        $mes="Diciembre";
    break;
}

	//i]mnclude('');
  
  require('fpdf/force_justify.php');
	
  $pdf = new PDF('P','mm','A4');
  $pdf->AddPage();
  
  $pdf->SetAlpha(0.08);
  $pdf->Image('img/nacional.gif',15,60,180);
  $pdf->SetAlpha(1);

  $pdf->SetFont('Helvetica', 'BIU', 13);
  $y=$pdf->GetY();
  $pdf->setXY(40, $y+8);
  $pdf->MultiCell(130, 8, utf8_decode('CONSTANCIA DE DATOS ESTADÍSTICOS PARA MAESTROS'),0,'C',0);

  $pdf->SetFont('Times', '', 13);
  $y=$pdf->GetY();
  $pdf->SetXY(30, $y+5);
  $pdf->Cell(90, 12, utf8_decode('CÓDIGO DE MATRÍCULA : '),0,0,'R');
  $pdf->SetFont('Times', 'BU', 13);
  $pdf->Cell(60, 12, utf8_decode($arrayAcademico['Codigo']),0,1,'L');

  $pdf->SetFont('Times', '', 12);
  $pdf->SetX(30);
  $pdf->Cell(50, 8, utf8_decode('Apellidos y Nombres : '),0,0,'L');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(100, 8, utf8_decode($arrayAlumno['ApellidoPaterno']." ".$arrayAlumno['ApellidoMaterno'].", ".$arrayAlumno['Nombres']),0,1,'L');

  $pdf->SetFont('Times', '', 12);
  $pdf->SetX(30);
  $pdf->Cell(50, 8, utf8_decode('Maestria en : '),0,0,'L');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(100, 8, utf8_decode($arrayAcademico['facultad']),0,1,'L');
  
  $pdf->SetFont('Times', '', 12);
  $pdf->SetX(30);
  $pdf->Cell(50, 8, utf8_decode('Mencion : '),0,0,'L');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(100, 8, utf8_decode($arrayAcademico['nommencion']),0,1,'L');
  
  $pdf->SetFont('Times', '', 12);
  $pdf->SetX(30);
  $pdf->Cell(55, 8, utf8_decode('Año de ingreso a la Maestria: '),0,0,'L');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(20, 8, utf8_decode($arrayAcademico['AnnoIngreso']),0,0,'L');
  
  $pdf->SetFont('Times', '', 12);
  $pdf->Cell(55, 8, utf8_decode('Año de egreso de la Maestria: '),0,0,'R');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(20, 8, utf8_decode($arrayAcademico['AnnoEgreso']),0,1,'R');

  $pdf->SetFont('Times', '', 12);
  $pdf->SetX(30);
  $pdf->Cell(20, 8, utf8_decode('Sede :'),0,0,'L');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(20, 8, utf8_decode($arrayAcademico['filial']),0,0,'L');
  
  $pdf->SetFont('Times', '', 12);
  $pdf->Cell(80, 8, utf8_decode('Fecha de Aprobación del Grado por C.U:'),0,0,'R');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(30, 8, utf8_decode($arrayAcademico['FechaAprobacion']),0,1,'R');

  $pdf->SetFont('Times', '',12);
  $y=$pdf->GetY();
  $pdf->SetXY(30, $y+6);
  $pdf->MultiCell(150, 8, utf8_decode('Ha cumplido con rellenar su ficha de Estadística, requisito indispensable para la entrega del Diploma de Grado de Maestro. '),0,'J',0);
  
  $pdf->SetFont('Times', '', 12);
  $y=$pdf->GetY();
  $pdf->setXY(90,$y+15);
  $pdf->Cell(30,8, utf8_decode('Cerro de Pasco, '),0,0,'R');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(10,8, utf8_decode($arrayAcademico['dia']),0,0,'C');
  $pdf->SetFont('Times', '', 12);
  $pdf->Cell(10,8, utf8_decode('de'),0,0,'C');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(20,8, utf8_decode($mes),0,0,'C');
  $pdf->SetFont('Times', '', 12);
  $pdf->Cell(10,8, utf8_decode('del'),0,0,'C');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(10,8, utf8_decode($arrayAcademico['anio']),0,1,'L');

  $pdf->Line(70, 180, 210-70, 180);
  $pdf->SetFont('Times', '', 12);
  $pdf->setXY(30,180);
  $pdf->Cell(150,6, utf8_decode('V°B° Dirección de Estadística'),0,0,'C');

  $pdf->OutPut();
?>