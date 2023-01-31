<?php 
	namespace App\ControllersApp;
	
	use \DateTime;
	use App\Entities\Menu;	
	use Illuminate\Database\QueryException;
	use Slim\Http\Request;	

	use Carbon\Carbon;
	use Illuminate\Database\Capsule\Manager as Capsule;


	class  MenuController{

	/*Funcion para obtener el menu por semana y por timpo de menu*/
		public static function getDataBySpecificTypeMenuWeek(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["menssage"]="";/*Mensaje de error o de exito */
			if(empty($_POST["typeMenu"])){
				$array["state"]=0;
				$array["message"]="Tipo de menú vacío";
			}else if(empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($pid=$_POST["pid"]))){
				$array["message"]="Alumno vacío.";

			}else{
				$typeMenu=$_POST["typeMenu"];

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

				$menu= Capsule::select("SELECT
					1 as type_item,  
					menu.id, type, skd_date, second, soup, drink, dessert, fruit,  aditional, state_reser, reser_date_start::timestamp, reser_date_end::timestamp ,

						case when state_reser=0 then 2 when reser_date_start<= now() and now()<=reser_date_end then 1 else 3 end as state_menu_reservation, 

						(select concat(to_char(food_start,'HH:MIam'),' a ',to_char(food_end,'HH:MIam'))   from timetable where id=id_timetable) as horary_of_reser, 

						id_timetable, reservation_time, assist, assist_time

				 	FROM menu LEFT JOIN (SELECT * FROM d_reservation where d_reservation.uid=? and d_reservation.eid=? and d_reservation.oid=? and d_reservation.escid=? and d_reservation.subid=? and d_reservation.pid=?) as d_reservation on d_reservation.id_menu=menu.id where skd_date between date_trunc('week',current_date) -'2 days'::interval and date_trunc('week',current_date) + '11 days'::interval and type=? ", 
					array($uid,$eid, $oid, $escid, $subid, $pid, $typeMenu)
				);


				/**Modificacioens posteriores para el app-- Si falla quitar la parte comentada*/
					if(count($menu)>0){
						$whereInPar='';
						foreach ($menu as $key => $value) {
							if(!empty($whereInPar)){
								$whereInPar=$whereInPar.', ';
							}
							$whereInPar=$whereInPar.$value->id;

							
						}

						$reservacionhistorial= Capsule::select('SELECT id_menu,
							CASE WHEN food_start IS NOT NULL AND food_end IS NOT NULL
						       THEN concat(to_char(food_start,\'HH:MIam\'),\' a \',to_char(food_end,\'HH:MIam\')) 
						          ELSE \'--:----a--:----\' 
						    END AS horary_of_reser, 
						    id_timetable, reservation_time, assist, assist_time
								FROM h_d_reservation WHERE uid=? and id_menu in ('.$whereInPar.') ORDER BY assist_time;', [$uid]);
							

						for($i=0;$i<count($menu);$i++) {
							
							foreach ($reservacionhistorial as $key => $value) {
								if($menu[$i]->id===$value->id_menu){
									$menu[$i]->horary_of_reser=$value->horary_of_reser;
									$menu[$i]->id_timetable=$value->id_timetable;
									$menu[$i]->reservation_time=$value->reservation_time;
									$menu[$i]->assist=$value->assist;
									$menu[$i]->assist_time=$value->assist_time;

								}	
							}

						}

					}


					
				/*Fin de modificaciones de app*/


				$array["state"]=1;
				$array["menssage"]="Selección de datos exitosa";
				$array["data"]=$menu;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}
		
		public static function getDataBySpecificTypeActiveReservationApp(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["menssage"]="";/*Mensaje de error o de exito */
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
				$menu = Menu::selectRaw('0 as type_item, id, type, skd_date, second, soup, drink, dessert, fruit,  to_char(skd_date, \'TMDay\') as name_day, date_part(\'day\',  skd_date) as day_month , aditional, to_char(reser_date_start::timestamp,\'TMDay DD, HH:MIam\') as reser_date_start_char , to_char(reser_date_end::timestamp, \'TMDay DD, HH:MIam\') as reser_date_end_char , state_reser,  case when state_reser=0 then 2 when reser_date_start<= now() and now()<=reser_date_end then 1 else 3 end as state_menu_reservation, (select concat(to_char(food_start,\'HH:MIam\'),\' a \',to_char(food_end,\'HH:MIam\'))   from timetable where id=(select id_timetable from d_reservation where uid=? and eid=? and oid=? and escid=? and subid=? and pid=?  and id_menu=menu.id)) as horary_of_reser,  (select assist_time from d_reservation where uid=? and eid=? and oid=? and escid=? and subid=? and pid=?  and id_menu=menu.id ) as assist_time,reser_date_start::timestamp, reser_date_end::timestamp  ')->whereRaw(" case when state_reser=0 then 2 when reser_date_start<= now() and now()<=reser_date_end then 1 else 3 end =1", 
    						array($uid,$eid, $oid, $escid, $subid, $pid, $uid,$eid, $oid, $escid, $subid, $pid)
    					)->orderByRaw('menu.skd_date ASC')->get();



				/**Modificacioens posteriores para el app-- Si falla quitar la parte comentada*/
					if(count($menu)>0){
						$whereInPar='';
						foreach ($menu as $key => $value) {
							if(!empty($whereInPar)){
								$whereInPar=$whereInPar.', ';
							}
							$whereInPar=$whereInPar.$value->id;

							
						}

						$reservacionhistorial= Capsule::select('select id_menu,
							CASE WHEN food_start IS NOT NULL AND food_end IS NOT NULL
						       THEN concat(to_char(food_start,\'HH:MIam\'),\' a \',to_char(food_end,\'HH:MIam\')) 
						          ELSE \'--:----a--:----\' 
						    END AS horary_of_reser, assist_time
								FROM h_d_reservation WHERE uid=? and id_menu in ('.$whereInPar.') ORDER BY assist_time;', [$uid]);
							

						for($i=0;$i<count($menu);$i++) {
							
							foreach ($reservacionhistorial as $key => $value) {
								if($menu[$i]->id===$value->id_menu){
									$menu[$i]->horary_of_reser=$value->horary_of_reser;
									$menu[$i]->assist_time=$value->assist_time;
								}	
							}

						}

					}else{
						$nothing_menu = array(
							array(
								'type_item'=>1,
								'title' =>"" , 
								'message' => "No hay menús activos... :(\n" ,
								'icon'=>1
							),

						 );
						$menu=$nothing_menu;
					}


					
				/*Fin de modificaciones de app*/


				$array["state"]=1;
				$array["menssage"]="Selección de datos exitosa";
				$array["data"]=$menu;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}

		public static function getMenuAll(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["menssage"]="";/*Mensaje de error o de exito */
			if(empty($_POST["typeMenu"])){
				$array["state"]=0;
				$array["message"]="Tipo de menú vacío";

			}else if(empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
				empty($_POST["oid"]) || 	empty($_POST["escid"] ||
				empty($_POST["subid"]) || empty($pid=$_POST["pid"]))){
				$array["message"]="Alumno vacío.";

			}else{
				$typeMenu=$_POST["typeMenu"];

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

				$menu= Capsule::select("SELECT
					3 as type_item,  
					menu.id, menu.type, skd_date, second, soup, drink, dessert, fruit, aditional, state_reser,  case when state_reser=0 then 2 when reser_date_start<= now() and now()<=reser_date_end then 1 else 3 end as state_menu_reservation,  concat(to_char(food_start,'HH:MIam'),' a ',to_char(food_end,'HH:MIam')) as horary_of_reser,  assist_time , reser_date_start::timestamp, reser_date_end::timestamp , just_state, assist, id_timetable, reservation_time

				 	FROM menu LEFT JOIN (SELECT * FROM h_d_reservation where h_d_reservation.uid=? and h_d_reservation.eid=? and h_d_reservation.oid=? and h_d_reservation.escid=? and h_d_reservation.subid=? and h_d_reservation.pid=?) as h_d_reservation on h_d_reservation.id_menu=menu.id where menu.type=? order by skd_date desc", 
					array($uid,$eid, $oid, $escid, $subid, $pid, $typeMenu)
				);


					if(count($menu)>0){
						$whereInPar='';
						foreach ($menu as $key => $value) {
							if(!empty($whereInPar)){
								$whereInPar=$whereInPar.', ';
							}
							$whereInPar=$whereInPar.$value->id;

							
						}

						$reservacion= Capsule::select('SELECT id_menu,
							CASE WHEN id_timetable IS NOT NULL 
						       THEN (SELECT concat(to_char(food_start,\'HH:MIam\'),\' a \',to_char(food_end,\'HH:MIam\'))  FROM timetable where timetable.id=d_reservation.id_timetable)
						          ELSE \'--:----a--:----\' 
						    END AS horary_of_reser, 
						    id_timetable, reservation_time, assist
								FROM d_reservation WHERE uid=? and id_menu in ('.$whereInPar.') ORDER BY assist_time;', [$uid]);
							

						for($i=0;$i<count($menu);$i++) {
							
							foreach ($reservacion as $key => $value) {
								if($menu[$i]->id===$value->id_menu){
									$menu[$i]->horary_of_reser=$value->horary_of_reser;
									$menu[$i]->id_timetable=$value->id_timetable;
									$menu[$i]->reservation_time=$value->reservation_time;
									$menu[$i]->assist=$value->assist;

								}	
							}

						}

					}
				/*Fin de modificaciones de app*/



				$array["state"]=1;
				$array["menssage"]="Selección de datos exitosa";
				$array["data"]=$menu;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}

		public static function getMenu(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["menssage"]="";/*Mensaje de error o de exito */
			if(empty($_POST["id_menu"])){
				$array["state"]=0;
				$array["message"]="Id de menú vacío";

			}else{
				$id_menu=$_POST["id_menu"];


				$menu= Capsule::select("SELECT id, type, soup, second, drink, dessert, fruit, aditional, skd_date, state_reser,  case when state_reser=0 then 2 when reser_date_start<= now() and now()<=reser_date_end then 1 else 3 end as state_menu_reservation, reser_date_start, reser_date_end FROM menu where id=?;", 
					array($id_menu)
				);
					
				/*Fin de modificaciones de app*/


				$array["state"]=1;
				$array["menssage"]="Selección de datos exitosa";
				$array["data"]=$menu;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}


	}	