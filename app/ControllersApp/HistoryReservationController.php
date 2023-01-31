<?php 
	namespace App\ControllersApp;
	use \DateTime;
	use App\Entities\Reservation;
	use App\Entities\HistorialReservation;
	use Illuminate\Database\QueryException;
	use Slim\Http\Request;	
	use Carbon\Carbon;

	use Illuminate\Database\Capsule\Manager as Capsule;

	class  HistoryReservationController {

		public static function getListForJustification(Request $request,$response, $args){

			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($_POST["pid"]))){
				$array["message"]="Alumno vacío.";

			}else if(empty($_POST["typeMenu"])){
				$array["message"]="Tipo de Menú vacío";
			}else{

				$uid=$_POST["uid"];
				$eid=$_POST["eid"];
				$oid=$_POST["oid"];
				$escid=$_POST["escid"];
				$subid=$_POST["subid"];
				$pid=$_POST["pid"];
				$type=$_POST["typeMenu"];
				/*state_menu_reservation: 
					1=activo
					2=bloqueado
					3=inactivo
				*/

				$historial=HistorialReservation::join('menu', 'h_d_reservation.id_menu', '=','menu.id')
					->selectRaw(' 2 as type_item, menu.id, h_d_reservation.type, skd_date, second, soup, drink, dessert, fruit,   aditional,   state_reser,  case when state_reser=0 then 2 when reser_date_start<= now() and now()<=reser_date_end then 1 else 3 end as state_menu_reservation,  concat(to_char(food_start,\'HH:MIam\'),\' a \',to_char(food_end,\'HH:MIam\')) as horary_of_reser, assist, just_state,  id_timetable,reservation_time::timestamp, assist_time,reser_date_start::timestamp, reser_date_end::timestamp ')
					->whereRaw(" h_d_reservation.uid=? and h_d_reservation.eid=? and h_d_reservation.oid=? and h_d_reservation.escid=? and h_d_reservation.subid=? and h_d_reservation.pid=? and h_d_reservation.type=? and just_state='JP'",
    						array($uid,$eid, $oid, $escid, $subid, $pid,$type)
    					)->orderByRaw('menu.skd_date asc')->get();
				$array["state"]=1;
				$array["message"]="Selección de datos exitosa";
				$array["data"]=$historial;

			}

			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}

		public static function getListForAll(Request $request,$response, $args){

			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_GET["uid"]) ||  empty($_GET["eid"]) || 
				empty($_GET["oid"]) || 	empty($_GET["escid"] ||
				empty($_GET["subid"]) || empty($_GET["pid"]))){
				$array["message"]="Alumno vacío.";

			}else if(empty($_GET["typeMenu"])){
				
				$array["message"]="Tipo de Menú vacío";

			}else{
				$uid=$_GET["uid"];
				$eid=$_GET["eid"];
				$oid=$_GET["oid"];
				$escid=$_GET["escid"];
				$subid=$_GET["subid"];
				$pid=$_GET["pid"];
				$type=$_GET["typeMenu"];
				/*state_menu_reservation: 
					1=activo
					2=bloqueado
					3=inactivo
				*/
				$historial=HistorialReservation::join('menu', 'h_d_reservation.id_menu', '=','menu.id')
					->selectRaw(' 1 as type_item, id_menu, h_d_reservation.type, skd_date, second, soup, drink, dessert, fruit,  to_char(skd_date, \'TMDay\') as name_day, date_part(\'day\',  skd_date) as day_month , aditional, to_char(reser_date_start::timestamp,\'TMDay DD, HH:MIam\') as reser_date_start_char , to_char(reser_date_end::timestamp, \'TMDay DD, HH:MIam\') as reser_date_end_char , state_reser,  case when state_reser=0 then 2 when reser_date_start<= now() and now()<=reser_date_end then 1 else 3 end as state_menu_reservation,  concat(to_char(food_start,\'HH:MIam\'),\' a \',to_char(food_end,\'HH:MIam\')) as horary_of_reser, assist, just_state,  assist_time,reser_date_start::timestamp, reser_date_end::timestamp ')
					->whereRaw(" h_d_reservation.uid=? and h_d_reservation.eid=? and h_d_reservation.oid=? and h_d_reservation.escid=? and h_d_reservation.subid=? and h_d_reservation.pid=? and h_d_reservation.type=? and just_state='JP'",
    						array($uid,$eid, $oid, $escid, $subid, $pid,$type)
    					)->orderByRaw('menu.type asc')->get();
				$array["state"]=1;
				$array["message"]="Selección de datos exitosa";
				$array["data"]=$historial;

			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}


		public static function getReservation(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["menssage"]="";/*Mensaje de error o de exito */
			if(empty($_POST["id_menu"])){
				$array["state"]=0;
				$array["message"]="Id de menú vacío";

			}else if(empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($pid=$_POST["pid"]))){
				$array["message"]="Alumno vacío.";

			}else{
				$id_menu=$_POST["id_menu"];

				$uid=$_POST["uid"];
				$eid=$_POST["eid"];
				$oid=$_POST["oid"];
				$escid=$_POST["escid"];
				$subid=$_POST["subid"];
				$pid=$_POST["pid"];

				$menu= Capsule::select("SELECT *,  concat(to_char(food_start,'HH:MIam'),' a ',to_char(food_end,'HH:MIam')) as horary_of_reser FROM h_d_reservation WHERE id_menu=? AND uid=? AND eid=? AND oid=? AND escid=? AND subid=? AND pid=?", 
					array($id_menu, $uid, $eid,$oid,$escid,$subid,$pid)
				);
					

				if(count($menu)==0){
					$menu=Capsule::select("SELECT *,  (SELECT concat(to_char(food_start,'HH:MIam'),' a ',to_char(food_end,'HH:MIam')) FROM timetable where timetable.id=d_reservation.id_timetable) as horary_of_reser FROM d_reservation WHERE id_menu=? AND uid=? AND eid=? AND oid=? AND escid=? AND subid=? AND pid=?", 
					array($id_menu, $uid, $eid,$oid,$escid,$subid,$pid)
					);
				}
					




				/*Fin de modificaciones de app*/


				$array["state"]=1;
				$array["menssage"]="Selección de datos exitosa";
				$array["data"]=$menu;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}

	}		

		

