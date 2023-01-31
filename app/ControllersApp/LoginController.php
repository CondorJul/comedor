<?php
namespace App\ControllersApp;

use App\Entities\Person;
use App\Entities\User;


use Carbon\Carbon;

use Illuminate\Database\Capsule\Manager as Capsule;

class LoginController
{

    public static function setSuggestions(Request $request, $response, $args)
    {
        $row = Suggestions::create([
                'uid' => $_SESSION["users"],
                'eid' => $_SESSION["eid"], 
                'oid' =>    $_SESSION["oid"], 
                'escid' => $_SESSION["escid"],
                'subid' => $_SESSION["subid"],
                'pid' => $_SESSION["pid"],
                'details'=>$_POST["suggestions"],
                'add_by'=>$_SESSION["users"]
            
        ]);


        print_r(json_encode($row->id));
    }

}