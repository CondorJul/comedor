<?php
namespace App\ControllersApp;

use App\Entities\TokenUsersFirebase;
use Slim\Http\Request;

use Carbon\Carbon;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Helpers\LogActivity;

class TokenUsersFirebaseController
{

    public static function saveNewInstanceIdToken(Request $request, $response, $args)
    {
        $row = TokenUsersFirebase::updateOrCreate(
                    [
                        'token' => $_POST['token'] 
                        
                    ],
                    [
                        'uid' => $_POST["uid"],
                        'eid' => $_POST["eid"], 
                        'oid' => $_POST["oid"], 
                        'escid' => $_POST["escid"],
                        'subid' => $_POST["subid"],
                        'pid' => $_POST["pid"],
                        'date_suscribed'=>Capsule::raw('now()')
                    ]   
                );

                print(json_encode($row, JSON_UNESCAPED_UNICODE));

       //print_r(json_encode($row));
    }

    public static function saveDateLoggedInLast(Request $request, $response, $args)
    {
        $row=TokenUsersFirebase::where('token', $_POST['token'])
               ->update([
                   'date_logged_in_last' => Capsule::raw('now()')
                ]);
        $data=array();
        $data["update"]=$row;
        print(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public static function saveDateLogout(Request $request, $response, $args)
    {
        $row=TokenUsersFirebase::where('token', $_POST['token'])
               ->update([
                   'date_logout' => Capsule::raw('now()')
                ]);

        
        $data=array();
        $data["update"]=$row;
        print(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public static function getList(Request $request){
        
     
        

        //print_r(json_encode($request->getParams()));
        //print_r(json_encode($_SESSION));

        print('<br><br>');



        LogActivity::add("Alguien a visitado esta pagina", null, json_encode(['session'=>$_SESSION, 'params'=>$request->getParams()]) );
        $data=TokenUsersFirebase::get();
        print(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

}