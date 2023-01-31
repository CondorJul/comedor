<?php 
	namespace App\Controllers;
	use \DateTime;
	use App\Entities\Reservation;
	use App\Entities\HistorialReservation;
	use Illuminate\Database\QueryException;
	use Slim\Http\Request;	
	use Carbon\Carbon;

	use Illuminate\Database\Capsule\Manager as Capsule;

	class  HistorialReservationController {		

		public static function getDataSpecificApp($uid, $eid, $oid, $escid, $subid, $pid, $idMenu)
		{
			//uso para una coleccion completa puede ser un o mas
			$reservation = HistorialReservation::where([
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

		public static function getReservationJustify(){
	        $query='uid=? ';
	        $data=array($_SESSION["users"]);
	        
	        if (!empty($_POST["select_period"])) {
	            $query = $query.((empty($query))?'period=? ':'and period=? ');
	            array_push($data, $_POST["select_period"]);
	        }

	        if (!empty($_POST["select_type_menu"])) {
	            $query = $query.((empty($query))?'menu.type=? ':'and menu.type=? ');
	            array_push($data, $_POST["select_type_menu"]);
	        }

	        if (!empty($_POST["justUsers"])) {
	            $query = $query.((empty($query))?'just_state=? ':'and just_state=? ');
	            array_push($data, $_POST["justUsers"]);
	        }
	        
            $users = HistorialReservation::join('menu', 'h_d_reservation.id_menu','=', 'menu.id')
                        ->selectRaw('id_menu, skd_date, CASE WHEN menu.type = 1 THEN \'Desayuno\' WHEN menu.type = 2 THEN \'Almuerzo\' WHEN menu.type = 3 THEN \'Cena\' END AS type, to_char(reservation_time, \'DD/MM/YYYY HH24:MI:SS\') as reservation_time, CASE WHEN assist=TRUE AND id_timetable IS NOT NULL THEN \'Asistió\' WHEN assist=FALSE AND id_timetable IS NOT NULL THEN \'Faltó\' WHEN assist IS NULL AND id_timetable IS NULL THEN \'Canceló\' WHEN assist IS NULL AND id_timetable IS NOT NULL THEN \'No Atendido\' END AS assist, just_state')
                        ->whereRaw($query, $data)
                        /*->where(function ($query) {
                            $query->where('base_users.uid', 'LIKE', '%'.$_POST["search"].'%')
                                  ->orWhere('base_users.pid', 'LIKE', '%'.$_POST["search"].'%')
                                  ->orWhereRaw('lower(concat(last_name0, \' \',last_name1,\', \', first_name)) like lower(?)','%'.$_POST["search"].'%');
                        })*/
                        ->orderByRaw('skd_date DESC, menu.type ASC')
                        ->get();
	        echo $users->toJson();
	    }

	    public static function getCantReservationJustify(){
	    	$cants = Capsule::select('SELECT * FROM cant_reservation(\''.$_SESSION["users"].'\') AS ("JA" BIGINT, "JP" BIGINT,"JD" BIGINT, "JO" BIGINT, "NR" BIGINT, "TOTAL" BIGINT)');
	    	print(json_encode($cants, JSON_UNESCAPED_UNICODE));
	    }

	    public static function getListPuntuation(){
	    	$puntuacion = HistorialReservation::join('menu', 'h_d_reservation.id_menu','=', 'menu.id')
	    					->selectRaw('id_menu, skd_date, CASE WHEN menu.type = 1 THEN \'Desayuno\' WHEN menu.type = 2 THEN \'Almuerzo\' WHEN menu.type = 3 THEN \'Cena\' END AS type')
	    					->whereRaw('uid=? AND assist=TRUE AND id_timetable IS NOT NULL AND score IS NULL', $_SESSION["users"])
	    					->orderByRaw('skd_date DESC, id_menu ASC')
	    					->get();
	    	echo $puntuacion->toJson();
	    }

	    public static function updateScore(){
	    	$idMenu = base64_decode(urldecode($_POST["id_menu"]));
	        $score = HistorialReservation::where(['uid' => $_SESSION["users"], 'id_menu'=> $idMenu])
	                        ->update(
	                            array(
	                                "score" => $_POST["score"],
	                            )
	                        );
	        if($score){             
	        	echo "Gracias por calificar el servicio... :)";
	        }else{
	            echo "Ha acurrido un Error. :(";
	        }
	    }

	    public static function updateComment(){
	    	$idMenu = base64_decode(urldecode($_POST["id_menu"]));
	    	$comment = empty(trim($_POST["comment"]))?null:$_POST["comment"];
	        $comments = HistorialReservation::where(['uid' => $_SESSION["users"], 'id_menu'=> $idMenu])
	                        ->update(
	                            array(
	                                "comment" => $comment,
	                            )
	                        );
	        if($comments){             
	        	echo "Gracias por enviarnos tu comentario... :)";
	        }else{
	            echo "Ha acurrido un Error. :(";
	        }
	    }

	    public static function countMenu(){
	        $count = HistorialReservation::selectRaw('COUNT(*) AS cont')->whereRaw('uid=? AND assist=TRUE AND id_timetable IS NOT NULL AND score IS NULL', $_SESSION["users"])->get();

	        echo $count->toJson();
	       	
	    }

	}



	