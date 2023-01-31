<?php 
	namespace App\Controllers;
	use \DateTime;
	use App\Entities\Reservation;
	use App\Entities\HistorialReservation;
	use Illuminate\Database\QueryException;
	use Slim\Http\Request;	
	use Carbon\Carbon;

	use App\Helpers\LogActivity;


	use Illuminate\Database\Capsule\Manager as Capsule;

	class  ReservationController {		

		public function getData()
		{
			//selecciona todo sin nigun filtro
			$reservation =Reservation::get();			
			echo $reservation->toJson(); 
		}

		public static function getDataSpecific($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$reservation = Reservation::where([
									'uid' => $_SESSION["users"],
									'eid' => $_SESSION["eid"], 
									'oid' => $_SESSION["oid"], 
									'escid' => $_SESSION["escid"],
									'subid' => $_SESSION["subid"],
									'pid' => $_SESSION["pid"],
									'id_menu' => $_POST['idMenu']  
								])->get();
			echo $reservation->toJson();
		}

		public static function getDataSpecificApp($uid, $eid, $oid, $escid, $subid, $pid, $idMenu)
		{
			//uso para una coleccion completa puede ser un o mas
			$reservation = Reservation::where([
									'uid' => $uid,
									'eid' => $eid, 
									'oid' => $oid, 
									'escid' => $escid,
									'subid' => $subid,
									'pid' => $pid,
									'id_menu' => $idMenu  
								])->get();
			return $reservation;
		}

		public static function setReservation(Request $request, $response, $args)
		{
			$array=array();
			$array["data"]= array();
			$array['state']=0;
			$array['message']="";
			try {
				$id_timetable = ($_POST['idHorary']==-1)?null:$_POST['idHorary'];
				/*$reservation = Reservation::updateOrCreate(
					['id_menu' => $_POST['idMenu'], 'id_user' => $_POST['idUser']],

					['id_timetable' => $id_timetable]	
				);*/

				//Se requiere api para no estar cambiando el periodo

				$reservation = Reservation::updateOrCreate(
					[
						'id_menu' => $_POST['idMenu'], 
						'uid' => $_SESSION["users"],
						'eid' => $_SESSION["eid"], 
						'oid' =>	$_SESSION["oid"], 
						'escid' => $_SESSION["escid"],
						'subid' => $_SESSION["subid"],
						'pid' => $_SESSION["pid"]
					],
					
					[
						'id_timetable' => $id_timetable,
						'period'=>"22B",
						'inserted_from'=>'W'
					]	
				);

				$array['state']=1;
				if ($id_timetable==null) {
					$array["message"]="Su reserva se ha cancelado con exito...! :)";
				}else{
					$array["message"]="Reserva procesada correctamente...! :)";
				}			
			} catch ( QueryException $e) {		

				$arrayError=explode("<MSG>",$e->getMessage());
				if(isset($arrayError[1])){
					$array['message']=$arrayError[1];
				}else{
					$array['message']="Lo sentimos, en estos momentos no pudimos efectuar su reservación. :(";
				}
				$array['state']=0;

				/*
				$array['state']=0;
				if (strcmp($e->getCode(), "P0001")==0) {
					$array['message']="Lo sentimos, en estos momentos no tenemos cupos disponibles. :(";
				}else{
					$array['message']="Lo sentimos, en estos momentos no pudimos efectuar su reservación.".$e->getMessage();
				}*/	
			}

			

			LogActivity::add($_SESSION["users"]." ha realizado o cancelado una reservación ".(($array['state']==1)?"con exito":"sin exito").". [".$array["message"]."]", null,json_encode(['session'=>$_SESSION, 'params'=>$request->getParams()]));
			print(json_encode($array, JSON_UNESCAPED_UNICODE));				
		}

		public static function setReservationApp(Request $request, $response, $args)
		{
			$array=array();
			$array["data"]= array();
			$array['state']=0;
			$array['message']="";
			if (empty($_POST["id_menu"])) {
				$array['message']="Campo menu vacío";
			}else if(empty($_POST["id_timetable"])){
				$array['message']="Horario vacío";
			}else if(empty($_POST["uid"]) || empty($_POST["eid"]) || empty($_POST["oid"]) || empty($_POST["escid"]) || empty($_POST["subid"]) || empty($_POST["pid"])){
				$array['message']="Usuario vacío";
			}else {
				$id_menu=$_POST["id_menu"];
				

				$uid = $_POST["uid"];
				$eid = $_POST["eid"]; 
				$oid =	$_POST["oid"]; 
				$escid = $_POST["escid"];
				$subid = $_POST["subid"];
				$pid = $_POST["pid"];


				$id_timetable=($_POST['id_timetable']==-1/*-1=Represetna vacio o nullo*/)?null:$_POST['id_timetable'];

				try {
					$reservation = Reservation::updateOrCreate(
						[
							'id_menu' => $id_menu, 
							'uid' => $uid,
							'eid' => $eid, 
							'oid' => $oid, 
							'escid' => $escid,
							'subid' => $subid,
							'pid' => $pid
						],
						[
							'id_timetable' => $id_timetable,
							'period'=>"22B",
							'inserted_from'=>'M'
						]	
					);
					
					$array['state']=1;
					if ($id_timetable==null) {
						$array["message"]="Su reserva se ha cancelado con exito. :)";
					}else{
						$array["message"]="Reserva procesada correctamente. :)";
					}
					
				} catch ( QueryException $e) {

					$arrayError=explode("<MSG>",$e->getMessage());
					if(isset($arrayError[1])){
						$array['message']=$arrayError[1];
					}else{
						$array['message']="Lo sentimos, en estos momentos no pudimos efectuar su reservación. :(";
					}
					$array['state']=0;
					
				}
			}

			LogActivity::add($uid.", desde el aplicativo movil,  ha realizado o cancelado una reservación ".(($array['state']==1)?"con exito":"sin exito").". [".$array["message"]."]", null,json_encode(['session'=>[], 'params'=>$request->getParams()]));

			print(json_encode($array, JSON_UNESCAPED_UNICODE));			
		}

		public static function deleteReservation($request)
		{
			//eliminar un registro mediante una columna o mas
			$reservation=Reservation::where('id',$_POST['pid'])->delete();
		}

		public static function getCantReservation(Request $request,$response, $args){
			$reservation = Reservation::selectRaw('count(*) as cantReser')->where([['id_menu','=',$_POST['idMenu']],['id_timetable','=',$_POST['idTimetable']]])->get();
			echo $reservation;
		}


		public static function updateAssist(Request $request,$response, $args){
			$array = array();
			$array["alumno"]=array();/*Data a retornar si es necesarios*/
			$array["reservation"]=array();
			$array["totalAssist"]=array();
			$array["totalRegistry"]=array();
			$array["horary"]="";
			$array["state"]=0 ;/*0=error , 1==no existe ninguna reservacion, 2=la reservacion es de otro hoarario, 3=ya se realizo la reservacion previamente, 4=reservacion existosa*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_POST["select_type_menu"])){
				$array["message"]="El campo Tipo menú vacío.";
			}elseif(empty($_POST['select_horario'])){
				$array["message"]="Horario vacío.";
			}elseif (empty($_POST['cod_dni_alumno'])) {
				$array["message"]="Código o DNI vacío.";
			}elseif (empty($_POST['id_menu'])) {
				$array["message"]="Menú vacío.";
			}
			else{
				$typeMenu=$_POST["select_type_menu"];
				$idHorary=$_POST['select_horario'];
				$codDniAlumno=$_POST['cod_dni_alumno'];
				$idMenu=$_POST['id_menu'];

				$array["totalAssist"]=ReservationController::getAssistRegistryTodayByMenu($idMenu, $idHorary);
				$array["totalRegistry"]=ReservationController::getTotalRegistryTodayByMenu($idMenu, $idHorary);


				$users=LoginController::getUser($codDniAlumno);
				$array["alumno"]=$users;
				if (count($users)==0) {
					$array["state"]=0;
					$array["message"]="El código no existe";
				}else{
					
						//$menu=ReservationController:getIdMenuBySkd_DateAndType($newDataTime, $typeMenu);
				
					$reservation_select = Reservation::where('uid','=',$users[0]["code"])->where('id_menu','=',$idMenu)->get();
						//array_merge($array["data"]);
					
					$array["reservation"]=$reservation_select;
					if(count($reservation_select)==0){
						$array["state"]=0;
						$array["message"]="No tiene ninguna reservación.";
					}elseif ($reservation_select[0]["id_timetable"]==null){
						$array["state"]=0;
						$array["message"]="El alumno ha cancelado su reservación";
					}else if($idHorary!=$reservation_select[0]["id_timetable"]){
						$array["state"]=0;
						$horary=HoraryController::getDataBySpecificIdforAssist($reservation_select[0]["id_timetable"]);
												
						$array["message"]="El alumno reservo en el horario ".$horary[0]["food_start_char"]." a ".$horary[0]["food_end_char"];
						
					}elseif($reservation_select[0]["assist"]==true){
						$array["state"]=0;
						setlocale(LC_TIME, "es_ES");

						$assist_time = new DateTime($reservation_select[0]['assist_time']);
						$horary=HoraryController::getDataBySpecificIdforAssist($reservation_select[0]["id_timetable"]);
						$array["horary"]=$horary[0]["food_start_char"]." a ".$horary[0]["food_end_char"];
						$array["message"]="El alumno ha sido registrado su asistencia a las ". $assist_time->format("G:ia d-M-Y");
					}else {
						$reservation_update_assist=Reservation::where('id',$reservation_select[0]["id"])->update(['assist' =>true]);
						$array["state"]=1;
						$array["message"]="Se registro Correctamente su Asistencia";
						$horary=HoraryController::getDataBySpecificIdforAssist($reservation_select[0]["id_timetable"]);
						$array["horary"]=$horary[0]["food_start_char"]." a ".$horary[0]["food_end_char"];	
					}
				}
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}

		public static function getDataReservationAsisst(){				 
			/*$reservation = Reservation::selectRaw('uid as id_user, assist, assist_time, (select skd_date from menu where id=d_reservation.id_menu) as skd_date')->where('uid','=',$_SESSION["user"])->orderBy('skd_date')->get();*/

			/*$reservation = HistorialReservation::selectRaw('uid as id_user, assist, assist_time, (select skd_date from menu where id=h_d_reservation.id_menu) as skd_date')
				->where([
						'uid' => $_SESSION["users"],
						'eid' => $_SESSION["eid"], 
						'oid' => $_SESSION["oid"], 
						'escid' => $_SESSION["escid"],
						'subid' => $_SESSION["subid"],
						'pid' => $_SESSION["pid"]  
				])->orderBy('skd_date')->get();*/

			$reservation = HistorialReservation::join('menu', 'h_d_reservation.id_menu', '=', 'menu.id')
				->select('assist','assist_time', 'skd_date')
				->where([
					'uid' => $_SESSION["users"],
					'eid' => $_SESSION["eid"], 
					'oid' => $_SESSION["oid"], 
					'escid' => $_SESSION["escid"],
					'subid' => $_SESSION["subid"],
					'pid' => $_SESSION["pid"] 
				])
				->whereRaw('concat(to_char(skd_date::date, \'tmmonth\'),\' \',date_part(\'year\',current_date))=?', array($_POST["mes"]))
				->orderBy('skd_date')->get();

			echo $reservation->toJson(); 
		}

		public static function getDataCantAssistFaults(){				 
			$reservation = Reservation::selectRaw('(SELECT COUNT(*) FROM h_d_reservation INNER JOIN menu ON h_d_reservation.id_menu=menu."id" WHERE assist=TRUE and uid=? and eid=? and oid=? and escid=? and subid=? and pid=? and concat(to_char(skd_date::date, \'tmmonth\'),\' \',date_part(\'year\',current_date))=?) as asistencia, (SELECT COUNT(*) FROM h_d_reservation INNER JOIN menu ON h_d_reservation.id_menu=menu."id" WHERE assist=FALSE and uid=? and eid=? and oid=? and escid=? and subid=? and pid=? and concat(to_char(skd_date::date, \'tmmonth\'),\' \',date_part(\'year\',current_date))=?) as falta, (SELECT COUNT(*) FROM h_d_reservation INNER JOIN menu ON h_d_reservation.id_menu=menu."id" WHERE assist IS NULL and uid=? and eid=? and oid=? and escid=? and subid=? and pid=? and concat(to_char(skd_date::date, \'tmmonth\'),\' \',date_part(\'year\',current_date))=?) as cancelado', array($_SESSION["users"], $_SESSION["eid"], $_SESSION["oid"], $_SESSION["escid"], $_SESSION["subid"], $_SESSION["pid"], $_POST["mes"], $_SESSION["users"], $_SESSION["eid"], $_SESSION["oid"], $_SESSION["escid"], $_SESSION["subid"], $_SESSION["pid"], $_POST["mes"], $_SESSION["users"], $_SESSION["eid"], $_SESSION["oid"], $_SESSION["escid"], $_SESSION["subid"], $_SESSION["pid"], $_POST["mes"]))->limit(1)->get();
			echo $reservation->toJson(); 
		}

		public static function getAssistRegistryTodayByMenu($idMenu, $idTimetable){

			$assistTodayByMenu = Reservation::selectRaw(' count(assist) as assistTodayByMenu ')
				->where([
						'id_menu' => $idMenu,
						'id_timetable' =>$idTimetable, 
						'assist' => TRUE,
				])->get();
				//print_r($assistTodayByMenu);
			
			return $assistTodayByMenu;
		}

		public static function getTotalRegistryTodayByMenu($idMenu, $idTimetable){
			
			$TotalRegistryTodayByMenu = Reservation::selectRaw(' count(id_timetable) as TotalRegistryTodayByMenu ')
				->where([
						'id_menu' => $idMenu,
						'id_timetable' =>$idTimetable,
					
				])->get();
			//print_r($TotalRegistryTodayByMenu);
			return $TotalRegistryTodayByMenu;
		}

		public static function closeMenu(Request $request,$response, $args){
			$array = array();
			$array["data"] = array();
			$array["message"] = "";
			$array["state"]=0;
			try{

				$count= Capsule::select('SELECT count(*) as count FROM d_reservation INNER JOIN menu ON d_reservation.id_menu=menu.id WHERE skd_date=? AND menu.type=? AND  assist=true;', array($_POST["fechaCerrarmenu"], $_POST["typeCerrarMenu"]));

				if($_POST["asistCobert"] == "si" && $count[0]->count==0){
					$array["message"] = "No se ha registrado la asistencia en este menú programado.";	
					$array["state"] = 0;
				}else{
					
					if ($_POST["asistCobert"] == "si") {
					$cobertura = Capsule::update('UPDATE d_reservation SET assist=FALSE FROM menu WHERE skd_date=? AND menu.type=? AND id_timetable IS NOT NULL AND assist IS NULL and d_reservation.id_menu=menu.id', array($_POST["fechaCerrarmenu"], $_POST["typeCerrarMenu"]));	
					}
					
					$close = Capsule::update('DELETE FROM d_reservation USING menu WHERE d_reservation.id_menu=menu.id AND skd_date=? AND menu.type=?', array($_POST["fechaCerrarmenu"], $_POST["typeCerrarMenu"]));

					$array["message"] = "Datos Enviados al Historial";	
					$array["state"] = 1;

				}

				/*
				if ($_POST["asistCobert"] == "si") {
					$cobertura = Capsule::update('UPDATE d_reservation SET assist=FALSE FROM menu WHERE skd_date=? AND menu.type=? AND id_timetable IS NOT NULL AND assist IS NULL and d_reservation.id_menu=menu.id', array($_POST["fechaCerrarmenu"], $_POST["typeCerrarMenu"]));	
				}
				
				$close = Capsule::update('DELETE FROM d_reservation USING menu WHERE d_reservation.id_menu=menu.id AND skd_date=? AND menu.type=?', array($_POST["fechaCerrarmenu"], $_POST["typeCerrarMenu"])); */


				$array["data"] = $close;
				//$array["state"] = 1;
				//$array["message"] = "Datos Enviados al Historial";	
			} catch (QueryException $e) {
				$array['state']=0;
				
				$array['message']="Lo sentimos, Ha ocurrido un Error.".$e->getMessage();
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}

		public static function getCantAllReservationApp(Request $request,$response, $args){

			$array['state']=0;
			$array['message']="";
			if(empty($_POST["uid"]) || empty($_POST["eid"]) || empty($_POST["oid"]) || empty($_POST["escid"]) || empty($_POST["subid"]) || empty($_POST["pid"])){
				$array['message']="Usuario vacío";
			}else {
			

				$uid = $_POST["uid"];
				$eid = $_POST["eid"]; 
				$oid =	$_POST["oid"]; 
				$escid = $_POST["escid"];
				$subid = $_POST["subid"];
				$pid = $_POST["pid"];



				try {
					$reservation = Capsule::select('select
						(SELECT count(*) from h_d_reservation WHERE assist=true and  uid=? and eid=? and oid=? and escid=? and subid=? and pid=?) as asssit_true, 
						(SELECT count(*) from h_d_reservation WHERE assist=false and  uid=? and eid=? and oid=? and escid=? and subid=? and pid=? )  as asssit_false,
						(SELECT count(*) from h_d_reservation WHERE assist is null and id_timetable is  null and  uid=? and eid=? and oid=? and escid=? and subid=? and pid=? )  as asssit_cancel, 
						(SELECT count(*) from h_d_reservation WHERE assist is null and id_timetable is not null and  uid=? and eid=? and oid=? and escid=? and subid=? and pid=? )  as asssit_not_attended ;',[$uid,$eid, $oid, $escid, $subid,$pid, $uid,$eid, $oid, $escid, $subid, $pid, $uid,$eid, $oid, $escid, $subid, $pid, $uid,$eid, $oid, $escid, $subid, $pid]);
					
					$array['data']=$reservation;
					$array['state']=1;
					$array["message"]="Se realizó la selección con exito. :)";
				
					
				} catch ( QueryException $e) {

					$arrayError=explode("<MSG>",$e->getMessage());
					if(isset($arrayError[1])){
						$array['message']=$arrayError[1];
					}else{
						$array['message']="Lo sentimos, en estos momentos no pudimos procesar su solicitud.";
					}
					$array['state']=0;
					
				}
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));	


		}



	

	}



	
