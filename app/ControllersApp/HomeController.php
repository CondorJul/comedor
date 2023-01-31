<?php 
	namespace App\ControllersApp;
	use \DateTime;
	use App\Entities\Reservation;
	use App\Entities\Menu;	
	use App\Entities\HistorialReservation;
	use Illuminate\Database\QueryException;
	use Slim\Http\Request;	
	use Carbon\Carbon;

	use Illuminate\Database\Capsule\Manager as Capsule;

	class  HomeController {		


		public static function getListItemsView(Request $request,$response, $args){
			
			
		
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["menssage"]="";/*Mensaje de error o de exito */
			if(/*empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($_POST["pid"]))*/false){
				$array["message"]="Alumno vacío.";

			}else{

				$uid=$_POST["uid"];
				$eid=$_POST["eid"];
				$oid=$_POST["oid"];
				$escid=$_POST["escid"];
				$subid=$_POST["subid"];
				$pid=$_POST["pid"];

				$arr = array ( 
						"7",
						"4",
						"0",
						"5",
						"2",
						"1",
						"6"
				); 

				$array["state"]=1;
				$array["menssage"]="Selección de datos exitosa";
				$array["data"]=$arr;
			}


			print(json_encode($array, JSON_UNESCAPED_UNICODE)); 


		}



	}