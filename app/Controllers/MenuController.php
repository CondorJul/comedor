<?php 
	namespace App\Controllers;
	
	use \DateTime;
	use App\Entities\Menu;	
	use Illuminate\Database\QueryException;
	use Slim\Http\Request;	

	use Carbon\Carbon;
	use Illuminate\Database\Capsule\Manager as Capsule;


	class  MenuController{		

		public function getData()
		{
			//selecciona todo sin nigun filtro
			$menu =Menu::get();			
			echo $menu->toJson(); 
		}

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
				$menu = Menu::selectRaw('id, type, skd_date, second, soup, drink, dessert, fruit,  to_char(skd_date, \'TMDay\') as name_day, date_part(\'day\',  skd_date) as day_month , aditional, to_char(reser_date_start::timestamp,\'TMDay DD, HH:MIam\') as reser_date_start_char , to_char(reser_date_end::timestamp, \'TMDay DD, HH:MIam\') as reser_date_end_char , state_reser,  case when state_reser=0 then 2 when reser_date_start<= now() and now()<=reser_date_end then 1 else 3 end as state_menu_reservation, (select concat(to_char(food_start,\'HH:MIam\'),\' a \',to_char(food_end,\'HH:MIam\'))   from timetable where id=(select id_timetable from d_reservation where uid=? and eid=? and oid=? and escid=? and subid=? and pid=?  and id_menu=menu.id)) as horary_of_reser,  (select assist_time from d_reservation where uid=? and eid=? and oid=? and escid=? and subid=? and pid=?  and id_menu=menu.id ) as assist_time,reser_date_start::timestamp, reser_date_end::timestamp  ')->whereRaw(" skd_date between date_trunc('week',current_date) -'2 days'::interval and 	date_trunc('week',current_date) + '11 days'::interval and type=?", 
    						array($uid,$eid, $oid, $escid, $subid, $pid, $uid,$eid, $oid, $escid, $subid, $pid, $typeMenu )
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

					}


					
				/*Fin de modificaciones de app*/


				$array["state"]=1;
				$array["menssage"]="Selección de datos exitosa";
				$array["data"]=$menu;
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}



		public static function checkMenuReservationEnable(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_POST["typeMenu"])){
				$array["message"]="Tipo de menú vacío";
			}else if(empty($_POST["skd_date"])){
				$array["message"]="Fecha de reservación vacío";
			}else{
				$typeMenu=$_POST["typeMenu"];
				$skd_date=$_POST["skd_date"];
				
				$menu = Menu::selectRaw(' id, type, skd_date, reser_date_start, reser_date_end,state_reser, current_date as datetime_now')->whereRaw(" type=? and skd_date=? ", 
    						array($typeMenu,$skd_date)
    					)->get();

				if(count($menu)!=0){

						$array["state"]=0;
						$array["message"]="";

						$now = new DateTime($menu[0]["datetime_now"]);
						$reser_date_start = new DateTime($menu[0]['reser_date_start']);
						$reser_date_end = new DateTime($menu[0]['reser_date_end']);

						if($menu[0]["state_reser"]=0){
							$array["state"]=0;
							$array["message"]="Esta reservación esta inactivo por el momento.";							
						}else  if($reser_date_start >= $now && $now<=$reser_date_end ){
			 				$array["state"]=1;	
			 				$array["message"]="Por favor seleccione un horario ir a comer.";
						}else if($now<$reser_date_start){
						//select age(timestamp '2019-05-19 12:05' ,timestamp '2019-04-18 18:25')
							$array["state"]=0;	
							$array["message"]="La Reservación Inicia en: "+$diff;
							$diff = $now->diff($reser_date_start);
							//echo  $diff;
						}else if($now>$reser_date_end ){
							$array["state"]=0;	
							$array["message"]="Lo sentimos. Esta reservación esta vencida.";
						}
						//$array["state"]=1;
						//$array["menssage"]="Selección de datos exitosa";
						$array["data"]=$menu;
				}else{
					$array["state"]=0;
					$array["message"]="No existe ninguna reservación programada para esta fecha.";
				}
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));

		}

		public static function getDataBySpecificId(Request $request, $response, $args)
		{
			//buscar un usuario especifico por el id
			//var_dump($_POST); 			
			$menu =  Menu::where('id',$_POST["pid"])->get();
			echo $menu->toJson();
		}

		public static function getMenuToday(Request $request, $response, $args)
		{
			//buscar un usuario especifico por el id 	
			$typeMenu=$_GET['typeMenu'];
				$menu =  Menu::whereRaw(" skd_date=current_date and type=?;", 
    						array($typeMenu)
    					)->get();
				echo $menu->toJson();	
		}

		public static function getDataSpecific($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$menu = Menu::where('soup', $request)
				     ->get();
			echo $menu;

		}

		public static function setMenu(Request $request, $response, $args)
		{			
			$array=array();
			$array["data"]= array();
			$array['state']=0;
			$array['message']="";

			$second = trim($_POST["segundo"]!="")?ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["segundo"])))) : NULL;
			$soup = trim($_POST["sopa"]!="")?ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["sopa"])))) : NULL;
			$drink = trim($_POST["infusion"]!="")?ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["infusion"])))) : NULL;
			$dessert = trim($_POST["postre"]!="")?ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["postre"])))) : NULL;
			$fruit = trim($_POST["fruta"]!="")?ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["fruta"])))) : NULL;
			$aditional = trim($_POST["adicional"]!="")?ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["adicional"])))) : NULL;

			try {
				$menu = Menu::create([
					'type' => $_POST["typeMenu"],
					'second' => $second,
					'soup' => $soup,
					'drink' => $drink,
					'dessert' => $dessert,
					'fruit' => $fruit,
					'aditional' => $aditional,
					'skd_date' => $_POST["fecha"],
					'state_reser' => $_POST["estado"],
					'reser_date_start' => $_POST["fechaInicio"]." ".$_POST["horaInicio"],
					'reser_date_end' => $_POST["fechaFin"]." ".$_POST["horaFin"]
				]);
				
				$array['state']=1;
				$array["message"]=" Agregado con Exito...!";	
				$array['data']=$menu->id;			
			} catch ( QueryException $e) {				
				$array['state']=0;
				if(strcmp($e->getCode(),"23505")==0){
					$array['message']="Error ".$e->getCode().": El Menú de este tipo ya esta programada para esta Fecha.";
				}else{
					$array['message']="Error ".$e->getCode().": Lo sentimos, Comunicase con el Administrador.";
				}				
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));	
		}

		public static function updateMenu($request)
		{
			$array=array();
			$array["data"]= array();
			$array['state']=0;
			$array['message']="";
			try {
				$menu = Menu::where('id', $_POST["pid"])->update([
					'second' => ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["segundo"])))),
					'soup' => ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["sopa"])))),
					'drink' => ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["infusion"])))),
					'dessert' => ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["postre"])))),
					'fruit' => ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["fruta"])))),
					'aditional' => ucfirst(strtolower(trim(preg_replace('/( ){2,}/u',' ',$_POST["adicional"])))),
					'state_reser' => $_POST["estado"],
					'reser_date_start' => $_POST["fechaInicio"]." ".$_POST["horaInicio"],
					'reser_date_end' => $_POST["fechaFin"]." ".$_POST["horaFin"]
				]);
					
				$array['state']=1;
				$array["message"]=" Modificado con Exito...!";			
			}catch ( QueryException $e) {				
				$array['state']=0;

				if(strcmp($e->getCode(),"23505")==0){
					$array['message']="Error ".$e->getCode().": El Menú de este tipo ya esta programada para esta Fecha.";
				}else{
					$array['message']="Error ".$e->getCode().": Lo sentimos, Comunicase con el Administrador.";
				}
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));	
		}

		public static function deleteMenu($request)
		{
			$menu=Menu::where('id',$_POST['pid'])->delete();
		}

		public static function checkMenuEnable(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();
			$array["state"]=0 ;
			$array["message"]="";
			$idMenu=$_POST["idMenu"];
				
			$menu = Menu::selectRaw('id, type, skd_date, reser_date_start, reser_date_end,state_reser, current_timestamp as datetime_now')->whereRaw("id=?", 
    						array($idMenu)
    					)->get();

			if(count($menu)!=0){

					$array["state"]=0;
					$array["message"]="";

					date_default_timezone_set('America/Lima');
					$now = new DateTime($menu[0]['datetime_now']);
					$reser_date_start = new DateTime($menu[0]['reser_date_start']);
					$reser_date_end = new DateTime($menu[0]['reser_date_end']);

					if($menu[0]["state_reser"]==0){
						$array["state"]=0;
						$array["message"]="Esta reservación esta inactivo por el momento.";							
					}else  if($reser_date_start <= $now && $now<=$reser_date_end ){
		 				$array["state"]=1;	
		 				$array["message"]="Por favor seleccione un horario para ir a comer.";
					}else if($now<$reser_date_start){
					//select age(timestamp '2019-05-19 12:05' ,timestamp '2019-04-18 18:25')
						$diffi = $now->diff($reser_date_start);
						$array["state"]=0;	
						$array["message"]="La Reservación Inicia en: ".$diffi->format("%a días %H horas %I minutos %S segundos.");
						//print (json_encode($diff));
					}else if($now>$reser_date_end){
						$array["state"]=0;	
						$array["message"]="Lo sentimos. Esta reservación esta vencida.";
					}
					//$array["state"]=1;
					//$array["menssage"]="Selección de datos exitosa";
					$array["data"]=$menu;
			}else{
				$array["state"]=0;
				$array["message"]="No existe ninguna reservación programada para esta fecha.";
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}

		public static function checkMenuEnableApp(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();
			$array["state"]=0 ;
			$array["message"]="";
			$idMenu=$_POST["id_menu"];
				
			$menu = Menu::selectRaw('id, type, skd_date, reser_date_start, reser_date_end,state_reser, current_timestamp as datetime_now')->whereRaw("id=?", 
    						array($idMenu)
    					)->get();

			if(count($menu)!=0){

					$array["state"]=0;
					$array["message"]="";

					date_default_timezone_set('America/Lima');
					$now = new DateTime($menu[0]['datetime_now']);
					$reser_date_start = new DateTime($menu[0]['reser_date_start']);
					$reser_date_end = new DateTime($menu[0]['reser_date_end']);

					if($menu[0]["state_reser"]==0){
						$array["state"]=0;
						$array["message"]="Esta reservación esta inactivo por el momento.";							
					}else  if($reser_date_start <= $now && $now<=$reser_date_end ){
		 				$array["state"]=1;	
		 				$array["message"]="Por favor seleccione un horario para ir a comer.";
					}else if($now<$reser_date_start){
					//select age(timestamp '2019-05-19 12:05' ,timestamp '2019-04-18 18:25')
						$diffi = $now->diff($reser_date_start);
						$array["state"]=0;	
						$array["message"]="La Reservación Inicia en: ".$diffi->format("%a días %H horas %I minutos %S segundos.");
						//print (json_encode($diff));
					}else if($now>$reser_date_end){
						$array["state"]=0;	
						$array["message"]="Lo sentimos, esta reservación vencío  el ".$reser_date_end->format('d-m-Y H:ia').".";

						/**/
					}
					//$array["state"]=1;
					//$array["menssage"]="Selección de datos exitosa";
					$array["data"]=$menu;
			}else{
				$array["state"]=0;
				$array["message"]="No existe ninguna reservación programada para esta fecha.";
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}

		public static function listSecond(){
			$list = Menu::select('second')
			->whereNotNull('second')
			->orderByRaw('second ASC')
			->distinct()
			->get();
			echo $list->toJson();
		}

		public static function listSoup(){
			$list = Menu::select('soup')
			->whereNotNull('soup')
			->orderByRaw('soup ASC')
			->distinct()
			->get();
			echo $list->toJson();
		}

		public static function listDrink(){
			$list = Menu::select('drink')
			->whereNotNull('drink')
			->orderByRaw('drink ASC')
			->distinct()
			->get();
			echo $list->toJson();
		}

		public static function listFruit(){
			$list = Menu::select('fruit')
			->whereNotNull('fruit')
			->orderByRaw('fruit ASC')
			->distinct()
			->get();
			echo $list->toJson();
		}

		public static function listDessert(){
			$list = Menu::select('dessert')
			->whereNotNull('dessert')
			->orderByRaw('dessert ASC')
			->distinct()
			->get();
			echo $list->toJson();
		}

		public static function listAditional(){
			$list = Menu::select('aditional')
			->whereNotNull('aditional')
			->orderByRaw('aditional ASC')
			->distinct()
			->get();
			echo $list->toJson();
		}






	}



	