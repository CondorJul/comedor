<?php 
	namespace App\Controllers;
	use Illuminate\Database\QueryException;

	
	use App\Entities\Horary;	
	use Slim\Http\Request;	

	class  HoraryController{		

		public function getData()
		{
			$search=$_POST['search'];

			//selecciona todo sin nigun filtro
			$menu =Horary::whereRaw(" concat(' ', id,' ') like ? or case when type=1 then 'desayuno' when type=2 then 'almuerzo' when type=3 then 'cena' else 'otro' end like LOWER(?)", 
    						array("%$search%","%$search%")
    					)->get();			
			echo $menu->toJson(); 
		}

		public static function getDataBySpecificId(Request $request, $response, $args)
		{
			//buscar un usuario especifico por el id 			
				$menu =  Horary::find($_POST["id"]);
				echo $menu->toJson();	
		}

		public static function getDataBySpecificIdforAssist($idhorary)
		{
			//buscar un usuario especifico por el id 			
				
				//echo $menu->toJson();

				$horary =  Horary::selectRaw('id, type, food_start, to_char(food_start,\'HH:MIam\') as food_start_char, food_end, to_char(food_end,\'HH:MIam\') as food_end_char , cant')->where('id','=',$idhorary)->get();
			
				return $horary;
		}


		public static function getDataBySpecificType(Request $request, $response, $args)
		{
			//buscar un usuario especifico por el id 
				$type = $_GET['typeMenu'];			
				$menu =  Horary::selectRaw('id, type, food_start, to_char(food_start,\'HH:MIam\') as food_start_char, food_end, to_char(food_end,\'HH:MIam\') as food_end_char , cant')->where('type','=',$type)->get();
				echo $menu->toJson();	
		}

		public static function getDataSpecific($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$menu = Horary::where('soup', $request)
				     ->get();
			echo $menu;

		}

		public static function setHorario(Request $request, $response, $args)
		{
			//crea  nuevo registro en la tabla Menu
			$menu = Horary::create([
				
				'type'=>$_POST["tipo"],
				'food_start'=>$_POST["horainicio"],
				'food_end'=>$_POST["horafin"],
				'cant'=>$_POST["cantidad"],
			]);


			print_r(json_encode($menu->id));
		}

		public static function updateHorario($request)
		{
			//actulizar uno registro  por cualquierea de sus columnas
			$menu = Horary::where('id', $_POST["pid"])->update([
			   'type' => $_POST["tipo"],
			   'food_start' => $_POST["horainicio"],
			   'food_end' => $_POST["horafin"],
			   'cant' => $_POST["cantidad"],
				
			]);
			print_r($_POST);

		}

		public static function deleteHorario($request)
		{

			$array=array();
			$array["data"]= array();
			$array['state']=0;
			$array['message']="";
			try {
				$menu=Horary::where('id',$_POST['id'])->delete();
				$array['state']=1;
				$array["message"]="Horario eliminado con Exito...!";	
						
			} catch ( QueryException $e) {				
				$array['state']=0;
				if(strcmp($e->getCode(),"23503")==0){
					$array['message']="Error ".$e->getCode().": El horario no se puede eliminar porque esta en uso.";
				}else{
					$array['message']="Error ".$e->getCode().": Ocurrio un error inesperado, comunicase con el Administrador.";
				}
				
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));	




			//eliminar un registro mediante una columna o mas
			
			
		}



		/*Funcion para obtener el menu por semana y por timpo de menu*/
		public static function getDataHorary(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0 ;/*==false, 1=true*/
			$array["menssage"]="";/*Mensaje de error o de exito */
			if(empty($_POST["typeMenu"])){
				$array["menssage"]="Tipo menú vacío.";
			}else{
				$typeMenu=$_POST["typeMenu"];
				$array["state"]=1; 
				$array["menssage"]="Selección de datos correcto.";
			$horary = Horary::selectRaw('id, type, food_start, to_char(food_start,\'HH:MIam\') as food_start_char, food_end, to_char(food_end,\'HH:MIam\') as food_end_char , cant')->where('type','=',$typeMenu)->get();
			$array["data"]=$horary;
			

			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}

		public static function getDataHoraryCantReservation(Request $request,$response, $args){
			$array = array();
			$array["data"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0;/*==false, 1=true*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_POST["typeMenu"]) && empty($_POST["idMenu"])){
				$array["message"]="Tipo menú vacío.";
			}else{
				$typeMenu=$_POST["typeMenu"];
				$idMenu=$_POST["idMenu"];
				$array["state"]=1; 
				$array["message"]="Selección de datos correcto.";
				$horary = Horary::selectRaw('id, type, food_start, to_char(food_start,\'HH:MIam\') as food_start_char, food_end, to_char(food_end,\'HH:MIam\') as food_end_char , cant, (select count(*) from d_reservation where id_menu=? and id_timetable=timetable.id) as cantReser',[$idMenu])->where('type','=',$typeMenu)->get();
				$array["data"]=$horary;
				if (count($horary)==0) {
					$array["state"]=0;
					$array["message"]="No existen Horarios Disponibles.";
				}
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}

		public static function getDataHoraryCantReservationApp(Request $request,$response, $args){
			$array = array();
			$array["data_horary"]=array();/*Data a retornar si es necesarios*/

			$array["data_reservation"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0;/*==false, 1=true*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_POST["typeMenu"]) && empty($_POST["id_menu"])){
				$array["message"]="Tipo menú vacío.";
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
			
				$idMenu=$_POST["id_menu"];
				$array["state"]=1; 
				$array["message"]="Selección de datos correcto.";
			
				$array["data_reservation"]=ReservationController::getDataSpecificApp($uid, $eid, $oid, $escid, $subid, $pid, $idMenu);/*Data a retornar si es necesarios*/
				$horary = Horary::selectRaw('id, type, food_start, to_char(food_start,\'HH:MIam\') as food_start_char, food_end, to_char(food_end,\'HH:MIam\') as food_end_char , cant, (select count(*) from d_reservation where id_menu=? and id_timetable=timetable.id) as cantReser',[$idMenu])->where('type','=',$typeMenu)->get();
				$array["data_horary"]=$horary;
				if (count($horary)==0) {
					$array["state"]=0;
					$array["message"]="No existen Horarios Disponibles.";
				}
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}	

		public static function getDataHoraryCantReservationAppPrueba(Request $request,$response, $args){
			$array = array();
			$array["data_horary"]=array();/*Data a retornar si es necesarios*/

			$array["data_reservation"]=array();/*Data a retornar si es necesarios*/
			$array["state"]=0;/*==false, 1=true*/
			$array["message"]="";/*Mensaje de error o de exito */
			if(empty($_GET["typeMenu"]) && empty($_GET["id_menu"])){
				$array["message"]="Tipo menú vacío.";
			}else if(empty($_GET["uid"]) ||  empty($_GET["eid"]) || 
			empty($_GET["oid"]) || 	empty($_GET["escid"] ||
				empty($_GET["subid"]) || empty($pid=$_GET["pid"]))){
				$array["message"]="Alumno vacío.";
			}else{
				$typeMenu=$_GET["typeMenu"];
				$uid=$_GET["uid"];
				$eid=$_GET["eid"];
				$oid=$_GET["oid"];
				$escid=$_GET["escid"];
				$subid=$_GET["subid"];
				$pid=$_GET["pid"];
			
				$idMenu=$_GET["id_menu"];
				$array["state"]=1; 
				$array["message"]="Selección de datos correcto.";
			
				$array["data_reservation"]=HistorialReservationController::getDataSpecificApp($uid, $eid, $oid, $escid, $subid, $pid, $idMenu);/*Data a retornar si es necesarios*/
				$horary = Horary::selectRaw('id, type, food_start, to_char(food_start,\'HH:MIam\') as food_start_char, food_end, to_char(food_end,\'HH:MIam\') as food_end_char , cant, (select count(*) from h_d_reservation where id_menu=? and id_timetable=timetable.id) as cantReser',[$idMenu])->where('type','=',$typeMenu)->get();
				$array["data_horary"]=$horary;
				
				if (count($horary)==0) {
					$array["state"]=0;
					$array["message"]="No existen Horarios Disponibles.";
				}
			}
			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}		
	}
