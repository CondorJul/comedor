<?php 
	namespace App\ControllersApp;
	use \DateTime;
	use App\Entities\Reservation;
	use App\Entities\Menu;	
	use App\Entities\HistorialReservation;
	use Illuminate\Database\QueryException;
	use Slim\Http\Request;	
	use Carbon\Carbon;
	use App\Entities\Novedades;	

	use Illuminate\Database\Capsule\Manager as Capsule;

	class  JustificationController {		


		public static function getStateMessage(Request $request,$response, $args){
			
			
		
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["message"]="Función en desarrollo. Espera del \"Reglamento de Servicio de Asistencia Alimentaria\" actualizado.";/*Mensaje de error o de exito */
			
			print(json_encode($array, JSON_UNESCAPED_UNICODE)); 


		}

		public static function getCountForJustification(Request $request,$response, $args){
		
			
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["menssage"]="";/*Mensaje de error o de exito */
			if(empty($_POST["typeMenu"])){
				$array["state"]=0;
				$array["message"]="Id de menú vacío";

			}else if(empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($pid=$_POST["pid"]))){
				$array["message"]="Alumno vacío.";

			}else{
				$type_menu=$_POST["typeMenu"];

				$uid=$_POST["uid"];
				$eid=$_POST["eid"];
				$oid=$_POST["oid"];
				$escid=$_POST["escid"];
				$subid=$_POST["subid"];
				$pid=$_POST["pid"];


				$menu= Capsule::select("SELECT count(*) as count FROM h_d_reservation WHERE uid=? AND eid=? AND oid=? AND escid=? AND subid=? AND pid=? and type=? and just_state='JP'", 
					array($uid, $eid,$oid,$escid,$subid,$pid,$type_menu)
				);

				/*Fin de modificaciones de app*/


				$array["state"]=1;
				$array["menssage"]="Selección de datos exitosa";
				$array["data"]=$menu;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));



		}

	}