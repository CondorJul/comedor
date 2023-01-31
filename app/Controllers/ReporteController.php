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

	class  ReporteController{		

		public static function getReportReservationDate(Request $request, $response, $args){
			date_default_timezone_set('America/Lima');
			$hoy = date("Y-m-d");

			$query='';
			$data=array();

			$table = ($_POST["fecha"] == $hoy)?'d_reservation':'h_d_reservation';
			$nom = ($_POST["fecha"] == $hoy)?'Pendiente':'No Coberturado';
			if (!empty($_POST["select_escuela"])) {
				$query = 'menu.type=? AND skd_date=? AND '.$table.'.escid=?';
				array_push($data, $_POST["select_type_menu"], $_POST["fecha"], $_POST["select_escuela"]);
			}else {
				$query = 'menu.type=? AND skd_date=?';
				array_push($data, $_POST["select_type_menu"], $_POST["fecha"]);
			}

            $reporte = Person::join('base_users', 'base_person.pid', '=', 'base_users.pid')
            		->join(''.$table.'', 'base_users.uid', '=', ''.$table.'.uid')
            		->join('menu', ''.$table.'.id_menu', '=', 'menu.id')
            		->selectRaw('base_users.uid, concat(last_name0, \' \',last_name1,\', \', first_name) as name, to_char(reservation_time, \'DD/MM/YYYY HH24:MI:SS\') as reserva, to_char(assist_time, \'DD/MM/YYYY HH24:MI:SS\') AS asistencia, CASE WHEN assist=TRUE AND id_timetable IS NOT NULL THEN \'Asistió\' WHEN assist=FALSE AND id_timetable IS NOT NULL THEN \'Faltó\' WHEN assist IS NULL AND id_timetable IS NULL THEN \'Canceló\' WHEN assist IS NULL AND id_timetable IS NOT NULL THEN \''.$nom.'\' END AS asistio')
            		->whereRaw($query, $data)
            		->where(function ($query) {
					    $query->where('base_users.uid', 'LIKE', '%'.$_POST["search"].'%')
					          ->orWhereRaw('lower(concat(last_name0, \' \',last_name1,\', \', first_name)) like lower(?)','%'.$_POST["search"].'%');
					})
					->orderByRaw('assist_time DESC nulls last')
            		->get();
            	echo $reporte->toJson();		
            }

		public static function getReportCantReservationDate(Request $request, $response, $args){
			date_default_timezone_set('America/Lima');
			$hoy = date("Y-m-d");
			if ($_POST["fechaCantidadReserva"] == $hoy) {
				$reporte = Reservation::join('menu', 'd_reservation.id_menu', '=', 'menu.id')
            		->selectRaw('menu.type, COUNT(*) AS total, COUNT(NULLIF(assist, FALSE)) AS asistieron, (COUNT(*)-COUNT(NULLIF(assist,NULL))) AS faltaron,  SUM( CASE WHEN d_reservation.id_timetable is null then 1 else 0 end )  AS cancelaron')
            		->where('menu.skd_date', '=', $_POST["fechaCantidadReserva"])
            		->groupBy('menu.type')
					->orderBy('menu.type', 'ASC')
            		->get();	
			}else{
				$reporte = HistorialReservation::join('menu', 'h_d_reservation.id_menu', '=', 'menu.id')
            		->selectRaw('menu.type, COUNT(*) AS total, COUNT(NULLIF(assist, FALSE)) AS asistieron, COUNT(NULLIF(assist, TRUE)) AS faltaron, (COUNT(*)-COUNT(NULLIF(assist,NULL))) AS cancelaron')
            		->where('menu.skd_date', '=', $_POST["fechaCantidadReserva"])
            		->groupBy('menu.type')
					->orderBy('menu.type', 'ASC')
            		->get();
			}
			echo $reporte->toJson();
			#print_r($hoy); 
		}


		public static function getPeriod($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$HistorialReservation = HistorialReservation::selectRaw('DISTINCT period')->get();
			echo $HistorialReservation->toJson();
		}

		public static function getMonthsByPeriod($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$mbp = HistorialReservation::selectRaw(' DISTINCT  to_char((SELECT skd_date from menu WHERE menu.id=h_d_reservation.id_menu), \'TMMonth\') as month ')->where('period','=',$_POST['period'])->get();
			echo $mbp->toJson();
		}

		public static function getMoreAssists($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$queryWhere='';
			$arrayWhere = array();
			if(!empty($_POST['select_period'])){
				$queryWhere=(empty($queryWhere))?'period=? ':' and period=? ';
				array_push($arrayWhere,$_POST['select_period']);
			}
			
			if(!empty($_POST['select_months_by_period'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?'to_char((SELECT skd_date from menu WHERE menu.id=h_d_reservation.id_menu), \'TMMonth\')=? ':' and to_char((SELECT skd_date from menu WHERE menu.id=h_d_reservation.id_menu), \'TMMonth\')=? ');
				array_push($arrayWhere,$_POST['select_months_by_period']);
			}
			
			if(!empty($_POST['select_type_menu'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?'type=? ':' and type=? ');
				array_push($arrayWhere,$_POST['select_type_menu']);
			}
			
			if(!empty($_POST['search'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?'uid=? ':' and uid=? ');
				array_push($arrayWhere,$_POST['search']);
			}

			$queryWhere=(empty($queryWhere))?' ':' where '.$queryWhere;


	
			
			$HistorialReservation =  Capsule::select(' select 		uid, 			(			select concat( last_name0,\' \', last_name1 ,\', \', first_name) from base_person where pid=(SELECT pid from base_users where uid=h_d_reservation.uid) )	as first_last_name, sum( 	CASE  WHEN assist=true  THEN 1 ELSE 0	END )  as assist_true ,  sum( CASE  WHEN assist=false  THEN 1	ELSE 0 END )  as assist_false, sum(		CASE  	WHEN assist is null  THEN 1		ELSE 0	END	)  as assist_cancel  FROm 	h_d_reservation  '.$queryWhere.' GROUP BY uid ORDER BY sum( 	CASE   WHEN assist=true  THEN 1	ELSE 0 END 		) DESC; ', $arrayWhere);

			print(json_encode($HistorialReservation, JSON_UNESCAPED_UNICODE));	


			//echo $HistorialReservation->toJson();
		}



		public static function getMoreAssistsByDateInterval($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$queryWhere='';
			$arrayWhere = array();
		
			if(!empty($_POST['date_start'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?' (SELECT skd_date from menu WHERE menu.id=h_d_reservation.id_menu)>=? ':' and (SELECT skd_date from menu WHERE menu.id=h_d_reservation.id_menu)>=? ');
				array_push($arrayWhere,$_POST['date_start']);
			}
			

			if(!empty($_POST['date_end'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?' (SELECT skd_date from menu WHERE menu.id=h_d_reservation.id_menu)<=? ':' and (SELECT skd_date from menu WHERE menu.id=h_d_reservation.id_menu)<=? ');
				array_push($arrayWhere,$_POST['date_end']);
			}



			if(!empty($_POST['select_type_menu'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?'type=? ':' and type=? ');
				array_push($arrayWhere,$_POST['select_type_menu']);
			}
			
			if(!empty($_POST['search'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?'uid=? ':' and uid=? ');
				array_push($arrayWhere,$_POST['search']);
			}

			$queryWhere=(empty($queryWhere))?' ':' where '.$queryWhere;


	
			
			$HistorialReservation =  Capsule::select(' select 		uid, 			(			select concat( last_name0,\' \', last_name1 ,\', \', first_name) from base_person where pid=(SELECT pid from base_users where uid=h_d_reservation.uid) )	as first_last_name, sum( 	CASE  WHEN assist=true  THEN 1 ELSE 0	END )  as assist_true ,  sum( CASE  WHEN assist=false  THEN 1	ELSE 0 END )  as assist_false, sum(		CASE  	WHEN assist is null  THEN 1		ELSE 0	END	)  as assist_cancel  FROm 	h_d_reservation  '.$queryWhere.' GROUP BY uid ORDER BY sum( 	CASE   WHEN assist=true  THEN 1	ELSE 0 END 		) DESC; ', $arrayWhere);

			print(json_encode($HistorialReservation, JSON_UNESCAPED_UNICODE));	


			//echo $HistorialReservation->toJson();
		}





		public static function getAllByDayOfWeek($request)
		{
			//uso para una coleccion completa puede ser un o mas
			

			$array = array();
			
			$array["ta"] =  Capsule::select('select count(*) as total, to_char(h_d_reservation.assist_time, \'D\') as week_day from h_d_reservation where to_char(h_d_reservation.assist_time, \'D\') is not null
				group by to_char(h_d_reservation.assist_time, \'D\') 
				order by to_char(h_d_reservation.assist_time, \'D\')   asc;');
			$array["tr"] =  Capsule::select('select count(*) as total, to_char(menu.skd_date, \'D\') as week_day  from menu inner join h_d_reservation on menu."id"=h_d_reservation.id_menu GROUP BY to_char(menu.skd_date, \'D\') order by to_char(menu.skd_date, \'D\')   asc;');

			print(json_encode($array, JSON_UNESCAPED_UNICODE));	


			//echo $HistorialReservation->toJson();
		}


		public static function getReservationByHour($request)
		{
			//uso para una coleccion completa puede ser un o mas
			

			
			
			$are =  Capsule::select('select count(*) as total, to_char(h_d_reservation.reservation_time, \'HH24\') as hour_day from h_d_reservation
			group by to_char(h_d_reservation.reservation_time, \'HH24\') 
			order by  to_char(h_d_reservation.reservation_time, \'HH24\')  asc;
			');
					

			print(json_encode($are, JSON_UNESCAPED_UNICODE));	


			//echo $HistorialReservation->toJson();
		}


		public static function getAllByHorary($request)
		{
			//uso para una coleccion completa puede ser un o mas
			

			
			
			$are =  Capsule::select('select count(*) as total,concat( to_char(food_start,\'HH:MIam\') , \'-\', to_char(food_end,\'HH:MIam\') ) as horary from h_d_reservation GROUP BY food_start, food_end order by food_start;
');
					

			print(json_encode($are, JSON_UNESCAPED_UNICODE));	


			//echo $HistorialReservation->toJson();
		}



		public static function getAllByType($request)
		{
			//uso para una coleccion completa puede ser un o mas
			

			
			
			$are =  Capsule::select('select count(*) as total, type from h_d_reservation GROUP BY type order by type;');
					

			print(json_encode($are, JSON_UNESCAPED_UNICODE));	


			//echo $HistorialReservation->toJson();
		}

		public static function getAllReservationLast23Day($request)
		{
			//uso para una coleccion completa puede ser un o mas
			

		$data =  Capsule::select('select sum(	 CASE		WHEN d_reservation.inserted_from=\'W\' THEN 1 		ELSE 0	 END ) as web, sum(	 CASE		WHEN d_reservation.inserted_from=\'M\' THEN 1 		ELSE 0	 END ) as movil, date(d_reservation.reservation_time) as datee from d_reservation group by date(d_reservation.reservation_time)  order by date(d_reservation.reservation_time) DESC; ');
			
		$data_historial =  Capsule::select(' select sum(	 CASE		WHEN h_d_reservation.inserted_from=\'W\' THEN 1 		ELSE 0	 END ) as web, sum(	 CASE		WHEN h_d_reservation.inserted_from=\'M\' THEN 1 		ELSE 0	 END ) as movil, date(h_d_reservation.reservation_time) as datee from h_d_reservation group by date(h_d_reservation.reservation_time)  order by date(h_d_reservation.reservation_time)    DESC limit 23; ');

		$resultado = array_merge($data, $data_historial);

			print(json_encode($resultado, JSON_UNESCAPED_UNICODE));	


			//echo $HistorialReservation->toJson();
		}


		public static function getMenuRanking($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$queryWhere='';
			$arrayWhere = array();
		
			if(!empty($_POST['date_start'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?'skd_date>=? ':' and skd_date>=? ');
				array_push($arrayWhere,$_POST['date_start']);
			}
			

			if(!empty($_POST['date_end'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?' skd_date<=? ':' and skd_date<=? ');
				array_push($arrayWhere,$_POST['date_end']);
			}



			if(!empty($_POST['select_type_menu'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?'type=? ':' and type=? ');
				array_push($arrayWhere,$_POST['select_type_menu']);
			}
			
			if(!empty($_POST['search'])){
				$queryWhere=$queryWhere.((empty($queryWhere))?"concat(menu.second, ' ', menu.soup,' ', menu.drink, ' ', menu.dessert,' ', menu.fruit, ' ', menu.aditional) like ? ":" and concat(menu.second, ' ', menu.soup,' ', menu.drink, ' ', menu.dessert,' ', menu.fruit, ' ', menu.aditional) like ? ");
				array_push($arrayWhere,'%'.$_POST['search'].'%');
			}

			$queryWhere=(empty($queryWhere))?' ':' where '.$queryWhere;


	
			
			$menuRanking =  Capsule::select('select  menu.skd_date, menu.type, trunc((sum(COALESCE(score, 0))::decimal / 
					CASE WHEN sum(CASE WHEN score IS NULL THEN 0 ELSE 1 END)=0 THEN 1 ELSE sum(CASE WHEN score IS NULL THEN 0 ELSE 1 END) END
				),2) as prom_ranking, sum( CASE WHEN comment is  null then 0 else 1 end ) as num_coment, menu.id from menu left join h_d_reservation on menu.id=h_d_reservation.id_menu '.$queryWhere.' GROUP BY menu.id ORDER BY skd_date desc, type 
				DESC', $arrayWhere);

			print(json_encode($menuRanking, JSON_UNESCAPED_UNICODE));	


			//echo $HistorialReservation->toJson();
		}


	}
