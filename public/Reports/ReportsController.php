<?php
	namespace App\Controllers;

	use Illuminate\Database\QueryException;
	use App\Entities\Person;
	use App\Entities\Reservation;
	use App\Entities\HistorialReservation;

	use Slim\Http\Request;

	use Illuminate\Database\Eloquent\Model;

	use Carbon\Carbon;

	use Illuminate\Database\Capsule\Manager as Capsule;

	require('../fpdf/force_justify.php');

	class  ReportsController{		

		public static function getPrueba(){
		
			//include('fpdf/fpdf.php');
			$pdf=new FPDF();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);
			$pdf->Cell(40,10,'¡Hola, Mundo!');
			$pdf->Output();
			  	
		}

	}

	
        

