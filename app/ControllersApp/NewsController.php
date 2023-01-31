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

	class  NewsController {		


		public static function getLatestNews(Request $request,$response, $args){
			
			
		
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["menssage"]="";/*Mensaje de error o de exito */
			if(/*empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($_POST["pid"]))*/false){
				$array["message"]="Alumno vacío.";

			}else{


				/*$uid=$_POST["uid"];
				$eid=$_POST["eid"];
				$oid=$_POST["oid"];
				$escid=$_POST["escid"];
				$subid=$_POST["subid"];
				$pid=$_POST["pid"]*/;


				$novedades = Novedades::selectRaw("1 as type_item, title, date_pub, description")->whereRaw('state=true and date(date_pub)>=current_date - interval \'7 days\'')->orderBy('date_pub', 'desc')->get();

				if(count($novedades)<=0){
					$novedades = array(
						array(
							'type_item'=>0,
							'title' =>"" , 
							'message' => "No hay registro de noticias de los últimos 7 días...\n" ,
							'icon'=>2
						),

					 );
					
				}

				$array["state"]=1;
				$array["menssage"]="Selección de datos exitosa";
				$array["data"]=$novedades;
			}


			print(json_encode($array, JSON_UNESCAPED_UNICODE)); 


		}


	}