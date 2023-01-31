<?php

	namespace App\Controllers;

	use Illuminate\Database\QueryException;
	use App\Entities\Speciality;

	use Slim\Http\Request;

	use Illuminate\Database\Eloquent\Model;

	use Carbon\Carbon;

	use Illuminate\Database\Capsule\Manager as Capsule;

	class  SpecialityController{		

		public static function getSpeciality(){
	      	$speciality = Speciality::join('base_users','base_speciality.escid','=', 'base_users.escid')
	                        ->selectRaw('DISTINCT concat(\'\',base_users.escid)as codigo, name')
	                        ->orderByRaw('name ASC')
	                        ->get();
	        echo $speciality->toJson();
	    }

	}
