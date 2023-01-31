<?php 
	namespace App\Controllers;
	
	use App\Entities\Novedades;	
	use App\Entities\Person;	
	use Slim\Http\Request;
	use App\Firebase\CloudMessaging;

	class  NovedadesController{		

		public function getNovedades()
		{
			$novedades = Novedades::orderBy('state', 'desc')->orderBy('date_pub', 'desc')->get();
			echo $novedades->toJson();
		}

		public function getNovedadesState()
		{
			$novedades = Novedades::where('state','true')->orderBy('date_pub', 'desc')->get();
			echo $novedades->toJson();
		}

		public function getNovedadesSearch()
		{
			$search= ucwords(strtolower(trim($_POST["search"])));			
			$novedades = Novedades::where('title','LIKE','%'.$search.'%')->orderBy('state', 'desc')->orderBy('date_pub', 'desc')->get();
			echo $novedades->toJson();

		}

		public static function updateState($request)
		{
			
			
			$state = (base64_decode(urldecode($_POST["state"])) == "true")?FALSE : TRUE;			
			$novedades = Novedades::where('id', base64_decode(urldecode($_POST["token"])))->update([
					'state' => $state
				]);

			if($novedades){				
				echo "Se cambio el estado del articulo correctamente";
			}else{
					echo "No se pudo ejecutar la accion";
				}

		}

		public static function getDataSpecific($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$novedades = Novedades::where('id',base64_decode(urldecode($_POST["token"])))
				     ->get();

			echo $novedades->toJson();

		}

		
		public static function setNovedades($request)
		{		

			$data = array('errorInfo' => FALSE,
							"errorT"  => '', 
							"errorF"  => '',
							"errorD"  => ''); 
			if(empty(trim($_POST["form"][0]["value"]))){
				$data["errorT"] = "No se ah ingresado el <strong>titulo</strong></br>";
				$data["errorInfo"] = TRUE;				
			}

			if(empty(trim($_POST["form"][1]["value"]))){
				$data["errorF"] = "No se ah ingresado una <strong>fecha</strong></br>";
				$data["errorInfo"] = TRUE;				
			}

			if(empty(trim($_POST["form"][2]["value"]))){
				$data["errorD"] = "No se ah ingresado una <strong>descripcion</strong>";
				$data["errorInfo"] = TRUE;				
			}
				

			if(isset($_POST["token"])){				
				if(!$data["errorInfo"]){
					$novedades = Novedades::where('id', base64_decode(urldecode($_POST["token"])))->update([
						'title' => ucwords(strtolower(trim($_POST["form"][0]["value"]))),
						/*'date_pub' => trim($_POST["form"][1]["value"]),*/
						'description' => ucfirst(trim($_POST["form"][2]["value"])),
						'create_user' => $_SESSION["userAdm"]
					]);
				}			

			}else{
				if(!$data["errorInfo"]){
					$novedades = Novedades::create([
						'title' => ucwords(strtolower(trim($_POST["form"][0]["value"]))),
						/*'date_pub' => trim($_POST["form"][1]["value"]),*/
						'description' =>ucfirst(trim($_POST["form"][2]["value"])),
						'create_user' => $_SESSION["userAdm"]
					]);

					/*Envia notificaciones a los telefonos inteligeentes que tenga el aplicativo*/
					$cm = new CloudMessaging;
					$cm->sendGCM(ucwords(strtolower(trim($_POST["form"][0]["value"]))).": \n".ucfirst(trim($_POST["form"][2]["value"])));
					/*Fin*/
				}
			}				
			
			print(json_encode($data, JSON_UNESCAPED_UNICODE));	
		}


		public static function deleteNov($request)
		{
			//eliminar un registro mediante una columna o mas
			
			$novedades=Novedades::where('id',base64_decode(urldecode($_POST["token"])))->delete();
			$data["flag"] = $novedades;
			$data["information"] = "No se a podido eliminar los datos!!!";
			if($novedades)
				$data["information"] = "Se ha eliminado correctamente!!!";

			print(json_encode($data, JSON_UNESCAPED_UNICODE));	

		}

		public static function sendNotificationToUser(){
			$cm = new CloudMessaging;
			$cm->sendGCMToUser('cKQEI_38wNs:APA91bGYu6zPRCpHZf7dYVDC8v6ld3sjMbhgo0XXbTKKXvj2uVGX9U6vL6R3ehAOcjSPUvEES-j7sikQsgpQOWmNmvHHU9ZMRxtAs-7mhpZj36UbK2uZP-g2ZQ2Y2SuitY9N7sWgiKH4','Hola como esta');
		}
	}