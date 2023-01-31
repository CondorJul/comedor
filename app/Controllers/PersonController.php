<?php 
	namespace App\Controllers;
	//require 'C:/xampp/htdocs/comedor2/init.php';	
	
	use App\Entities\Person;

	class  PersonController{		

		public function getPerson()
		{
			$person =Person::get();
			return $person;
		}

		public static function getDataBySpecificId($id)
		{
			//buscar un usuario especifico por el id 
			$menu =  Person::find($id);
			return $menu

		}

		public static function getDataSpecific($request)
		{
			//uso para una coleccion completa puede ser un o mas
			$menu = Person::where('soup', $request)
				     ->get();
			return $menu

		}

		public static function setPerson($request)
		{

			//crea  nuevo registro en la tabla Menu
			$menu = Person::create([
				'id'=>'4',
				'type'=>'4',
				'soup'=>'sopa',
				'second'=>$request["segundo"],
				'drink'=>'bebida',
				'dessert'=>'fresa',
				'fruit'=>'mango',
			]);
			return $menu;
		}

		public static function updatePerson($request)
		{
			//actulizar uno registro  por cualquierea de sus columnas
			

		}

		public static function deleteMenu($request)
		{
			//eliminar un registro mediante una columna o mas
			$person=Person::where('id',$request)->delete();
		}
	}