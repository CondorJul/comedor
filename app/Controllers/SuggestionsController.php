<?php

	namespace App\Controllers;

	use Illuminate\Database\QueryException;
	use App\Entities\Person;
	use App\Entities\Reservation;
	use App\Entities\HistorialReservation;
	use App\Entities\Suggestions;


	use Slim\Http\Request;

	use Illuminate\Database\Eloquent\Model;

	use Carbon\Carbon;

	use Illuminate\Database\Capsule\Manager as Capsule;

	class  SuggestionsController{		

		public static function setSuggestions(Request $request, $response, $args)
		{
				$row = Suggestions::create([
						'uid' => $_SESSION["users"],
						'eid' => $_SESSION["eid"], 
						'oid' =>	$_SESSION["oid"], 
						'escid' => $_SESSION["escid"],
						'subid' => $_SESSION["subid"],
						'pid' => $_SESSION["pid"],
						'details'=>$_POST["suggestions"],
						'add_by'=>$_SESSION["users"]
					
				]);


			print_r(json_encode($row->id));
		}



	


		public static function getSuggestions(){
	      /*  $users = Suggestions::join('base_person','suggestions.pid','=', 'base_person.pid')
	                        ->selectRaw('base_person.pid, uid, concat(last_name0,\' \',last_name1, \', \', first_name) as apell_nom, details, for_all ')
	                        ->orderByRaw('last_name0, last_name1, first_name')
	                        ->get();*/
	           $users = Suggestions::join('base_person','suggestions.pid','=', 'base_person.pid')
	        ->selectRaw('id, date_add, details, solution, priority ')
	        ->orderByRaw('date_add DESC')
	        ->get();
	        echo $users->toJson();
	    }



		public static function setPriority(){
	      /*  $users = Suggestions::join('base_person','suggestions.pid','=', 'base_person.pid')
	                        ->selectRaw('base_person.pid, uid, concat(last_name0,\' \',last_name1, \', \', first_name) as apell_nom, details, for_all ')
	                        ->orderByRaw('last_name0, last_name1, first_name')
	                        ->get();*/
	           $users = Suggestions::where('id',$_POST['id'])->update(array('priority' => $_POST['priority']) );
	
	    }


	    	public static function setSuggestionsApp(Request $request, $response, $args)
		{
				$array=array();
				$array["data"]= array();
				$array['state']=0;
				$array['message']="";

				if(empty($_POST["uid"]) ||  empty($_POST["eid"]) || 
					empty($_POST["oid"]) || 	empty($_POST["escid"] ||
					empty($_POST["subid"]) || empty($_POST["pid"]))){
					$array["message"]="Alumno vacío.";

				}else if(empty($_POST["details"])){
					$array["message"]="Sugerencia vacío.";
				}else{

					$row = Suggestions::create([
							'uid' => $_POST["uid"],
							'eid' => $_POST["eid"], 
							'oid' => $_POST["oid"], 
							'escid' => $_POST["escid"],
							'subid' => $_POST["subid"],
							'pid' => $_POST["pid"],

							'details'=>$_POST["details"],
							
							'add_by'=>$_POST["uid"]
						
					]);
					$array['state']=1;
					$array['message']="Se guardó correctamente.";
					$array['data']=$row;


				}


			print(json_encode($array, JSON_UNESCAPED_UNICODE));
		}

	}
