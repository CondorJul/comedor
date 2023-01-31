<?php 
	namespace App\ControllersApp;
	use \DateTime;
	use App\Entities\Reservation;
	use App\Entities\HistorialReservation;
	use Illuminate\Database\QueryException;
	use Slim\Http\Request;	
	use Carbon\Carbon;

	use Illuminate\Database\Capsule\Manager as Capsule;

	class  ReservationController {		

		


		public static function getMenuReservationsToday(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($_POST["pid"]))){
				$array["message"]="Alumno vacío.";

			}else{

				$uid=$_POST["uid"];
				$eid=$_POST["eid"];
				$oid=$_POST["oid"];
				$escid=$_POST["escid"];
				$subid=$_POST["subid"];
				$pid=$_POST["pid"];
				/*state_menu_reservation: 
					1=activo
					2=bloqueado
					3=inactivo
				*/
				
				$reservation=Reservation::join('menu', 'd_reservation.id_menu', '=','menu.id')
					->selectRaw(' 1 as type_item, id_menu, menu.type, id_timetable,skd_date, reser_date_start, reser_date_end, assist,  state_reser,assist, assist_time, reservation_time, score, comment, (select concat(to_char(food_start,\'HH:MIam\'),\' a \',to_char(food_end,\'HH:MIam\'))   from timetable where id=id_timetable) as horary_of_reser, id_timetable ,reservation_time')
					->whereRaw(" d_reservation.uid=? and d_reservation.eid=? and d_reservation.oid=? and d_reservation.escid=? and d_reservation.subid=? and d_reservation.pid=? and menu.skd_date=date(now())",
    						array($uid,$eid, $oid, $escid, $subid, $pid)
    					)->orderByRaw('menu.type asc')->get();


				$historial=HistorialReservation::join('menu', 'h_d_reservation.id_menu', '=','menu.id')
					->selectRaw(' 1 as type_item, id_menu, menu.type, id_timetable,skd_date, reser_date_start, reser_date_end, assist,  state_reser, assist, assist_time, reservation_time, score, comment, concat(to_char(food_start,\'HH:MIam\'),\' a \',to_char(food_end,\'HH:MIam\')) as horary_of_reser , id_timetable, reservation_time')
					->whereRaw(" h_d_reservation.uid=? and h_d_reservation.eid=? and h_d_reservation.oid=? and h_d_reservation.escid=? and h_d_reservation.subid=? and h_d_reservation.pid=? and menu.skd_date=date(now())",
    						array($uid,$eid, $oid, $escid, $subid, $pid)
    					)->orderByRaw('menu.type asc')->get();

					for ($i=0; $i <count($reservation) ; $i++) { 
						$historial[]=$reservation[$i];
					}
					
		
					if(count($historial)>0){
						

					}else{
						$empty = array(
							array(
								'type_item'=>0,
								'title' =>"" , 
								'message' => "No hay reservas de hoy... :(\n",
								'icon'=>1 
							),

						 );
						$historial=$empty;
					}


					
				/*Fin de modificaciones de app*/


				$array["state"]=1;
				$array["message"]="Selección de datos exitosa";
				$array["data"]=$historial;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}


		public static function setScore(Request $request,$response, $args){

			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($_POST["pid"]))){
				$array["message"]="Alumno vacío.";

			}else if(empty($_POST["id_menu"])){
				$array["message"]="Menú Vacio";

			}else if(empty($_POST["score"])){
				$array["message"]="Puntuación Vacío";

			}else{

				$uid=$_POST["uid"];
				$eid=$_POST["eid"];
				$oid=$_POST["oid"];
				$escid=$_POST["escid"];
				$subid=$_POST["subid"];
				$pid=$_POST["pid"];
				$id_menu=$_POST["id_menu"];
				$score=$_POST["score"];
				/*state_menu_reservation: 
					1=activo
					2=bloqueado
					3=inactivo
				*/

				$reservation = Reservation::where([
                    'uid' => $uid,
                    'eid'=> $eid,
                    'oid'=> $oid,
                    'escid'=> $escid,
                    'subid'=>$subid,
                    'pid' => $pid,
                    'id_menu'=>$id_menu
                ])->update(
                            array(
                                "score" => $score,
                            )
                        );				

                $historial = HistorialReservation::where([
                    'uid' => $uid,
                    'eid'=> $eid,
                    'oid'=> $oid,
                    'escid'=> $escid,
                    'subid'=>$subid,
                    'pid' => $pid,
                    'id_menu'=>$id_menu
                ])->update(
                            array(
                                "score" => $score,
                            )
                        );				


				$array["state"]=1;
				$array["message"]="Puntuación enviada...";
				$array["data"]=$reservation;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}

		public static function setComment(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($_POST["pid"]))){
				$array["message"]="Alumno vacío.";

			}else if(empty($_POST["id_menu"])){
				$array["message"]="Menú Vacio";

			}else if(empty($_POST["comment"])){
				$array["message"]="Comentario Vacío";

			}else{

				$uid=$_POST["uid"];
				$eid=$_POST["eid"];
				$oid=$_POST["oid"];
				$escid=$_POST["escid"];
				$subid=$_POST["subid"];
				$pid=$_POST["pid"];
				$id_menu=$_POST["id_menu"];
				$comment=$_POST["comment"];
				/*state_menu_reservation: 
					1=activo
					2=bloqueado
					3=inactivo
				*/

				$reservation = Reservation::where([
                    'uid' => $uid,
                    'eid'=> $eid,
                    'oid'=> $oid,
                    'escid'=> $escid,
                    'subid'=>$subid,
                    'pid' => $pid,
                    'id_menu'=>$id_menu
                ])->update(
                            array(
                                "comment" => $comment,
                            )
                        );		

                $reservation = HistorialReservation::where([
                    'uid' => $uid,
                    'eid'=> $eid,
                    'oid'=> $oid,
                    'escid'=> $escid,
                    'subid'=>$subid,
                    'pid' => $pid,
                    'id_menu'=>$id_menu
                ])->update(
                            array(
                                "comment" => $comment,
                            )
                        );			


				$array["state"]=1;
				$array["message"]="Comentario enviado...";
				$array["data"]=$reservation;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}


	}
