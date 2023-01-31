<?php

	namespace App\Helpers;

	use Illuminate\Database\QueryException;
	use App\Entities\Speciality;

	use Slim\Http\Request;

	use Illuminate\Database\Eloquent\Model;

	use Carbon\Carbon;

	use Illuminate\Database\Capsule\Manager as Capsule;

	use App\Entities\Audit as LogActivityModel;

	class  LogActivity{		
		public function __construct(){
		}
		public static function add($subject, $data_old, $data_new){

			$ip = $_SERVER['HTTP_CLIENT_IP'] 
			? $_SERVER['HTTP_CLIENT_IP'] 
			: ($_SERVER['HTTP_X_FORWARDED_FOR'] 
					? $_SERVER['HTTP_X_FORWARDED_FOR'] 
					: $_SERVER['REMOTE_ADDR']);
			
			$log=[];
			$log['subject']=$subject;
			$log['user_agent']=$_SERVER['HTTP_USER_AGENT'];
			$log['url']=$_SERVER['REQUEST_URI'];
			$log['method']=$_SERVER['REQUEST_METHOD'];
			$log['ip']=$ip;
			$log['data_old']=$data_old;
			$log['data_new']=$data_new;
			$log['created_by']=(isset($_SESSION["logged_is_user"]))?$_SESSION["users"]:null;
			
			LogActivityModel::create($log);

		}

		public static function logActivityLists(){
			return LogActivityModel::latest()->get();
		}
		
	}
