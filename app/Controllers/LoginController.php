<?php
namespace App\Controllers;

use App\Entities\Person;
use App\Entities\User;
use Slim\Http\Request;	


use Carbon\Carbon;

use Illuminate\Database\Capsule\Manager as Capsule;

use App\Helpers\LogActivity;


class LoginController
{

    public static function getUser($codDni)
    {

        $user = User::select('base_users.uid as code', 'base_users.eid', 'base_users.oid', 'base_users.escid', 'base_users.subid', 'base_person.pid', 'base_person.first_name', 'base_person.last_name0', 'base_person.last_name1')->join('base_person', function ($q) {
            $q->on('base_person.pid', '=', 'base_users.pid')
                ->on('base_person.eid', '=', 'base_users.eid');
        }
        )->where(function ($query) use ($codDni) {
            $query->where('base_users.uid', '=', $codDni)
                ->orWhere('base_person.pid', '=', $codDni);
        })->where('base_users.rid', 'AL')
            ->orderBy('base_users.state_c', 'ASC')
            /*->where('base_users.state_c', 'A')*/
            ->get();
        //$user['uid'] = $user["codee"];
        //unset($user['codee']);
        return $user;
    }

    public static function validateUserApp()
    {
        $array            = array();
        $array["data"]    = array();
        $array["state"]   = 0; /*==false, 1=true*/
        $array["message"] = "" /*mensaje */;

        if (empty($_POST['user'])) {
            $array["message"] = "Usuario vacío";
        } else if (empty($_POST['password'])) {
            $array["message"] = "Password vacío";
        } else {
            $uid      = $_POST['user'];
            $password = $_POST['password'];

            $data = User::select('base_users.uid','base_users.rid', 'base_users.eid', 'base_users.oid', 'base_users.token',
                'base_users.escid', 'base_users.subid', 'base_person.pid', 'base_person.first_name', 'base_person.last_name0', 'base_person.last_name1', 'base_person.mail_person', 'password')->join('base_person', function ($q) {
                $q->on('base_users.pid', '=', 'base_person.pid')
                    ->on('base_users.eid', '=', 'base_person.eid');
            }
            )->where('base_users.uid', $uid)
                /*->where('base_users.rid', 'AL')*/
                /*->where('base_users.state', 'A')*/
                ->get();

            if (count($data)) {

                if(strcasecmp($data[0]["rid"], 'AL')===0){
                    if (strcmp($data[0]["password"], md5($password)) === 0) {
                        unset($data[0]["password"]);
                        $array["data"]    = $data;
                        $data[0]->code    = $uid;
                        $array["state"]   = 1;
                        $array["message"] = "Inició sesión correctamente.";

                    } else {
                        $array["message"] = "La contraseña ingresada es incorrecta.";
                    }
                }else {
                    $array["message"] = "Lo sentimos, usted no es alumno de pre-grado.";
                }

            } else {
                $array["message"] = "El código ingresado no existe";
            }
        }
        //echo json_encode($array);
        print(json_encode($array, JSON_UNESCAPED_UNICODE));

    }

    public function validateUser()
    {
        header("Content-Type: application/json");

        $data = [
            "alert"       => "alert alert-danger",
            "remove"      => "alert alert-success",
            "information" => "Usuario no identificado",
            "user"        => "",
            "validate"    => false,
        ];

        if (!empty($_POST["user"]) and !empty($_POST["password"]) and !empty($_POST["role"])) {

            if ($_POST["role"] == "AD") {
                $user = $_POST["user"] . $_POST["role"];
                $user = User::with('person')->where('state', 'A')->where('uid', $user)
                    ->where('rid', $_POST["role"])
                    ->where('password', md5($_POST["password"]))
                    ->get();
            } elseif ($_POST["role"] == "SP") {
                $user = $_POST["user"] . $_POST["role"];
                $user = User::with('person')->where('state', 'A')->where('uid', $user)
                    ->where('rid', $_POST["role"])
                    ->where('password', md5($_POST["password"]))
                    ->get();
            } elseif ($_POST["role"] == "RE") {
                $user = $_POST["user"] . $_POST["role"];
                $user = User::with('person')->where('state', 'A')->where('uid', $user)
                    ->where('rid', $_POST["role"])
                    ->where('password', md5($_POST["password"]))
                    ->get();
            }elseif ($_POST["role"] == "BU") {
                $user = $_POST["user"] . $_POST["role"];
                $user = User::with('person')->where('state', 'A')->where('uid', $user)
                    ->where('rid', $_POST["role"])
                    ->where('password', md5($_POST["password"]))
                    ->get();
            } else {

                $user = User::with('person')->where('state', 'A')->where('uid', $_POST["user"])
                    ->where('rid', $_POST["role"])
                    ->where('password', md5($_POST["password"]))
                    ->get();
            }

            if (count($user)) {

                $data = [
                    "alert"       => "alert alert-success",
                    "remove"      => "alert alert-danger",
                    "information" => "Usuario autentificado ,redireccionando...",
                    "validate"    => true,

                ];

                $userT = json_decode($user);

                session_destroy();
                session_start();
                $_SESSION["logged_is_user"] = true;
                $_SESSION["userAdm"]        = $_POST["user"] . $_POST["role"];
                $_SESSION["role"]           = $userT[0]->rid;

                $_SESSION["users"]     = $_POST["user"];
                $_SESSION["eid"]       = "20154605046";
                $_SESSION["oid"]       = "1";
                $_SESSION["escid"]     = $userT[0]->escid;
                $_SESSION["subid"]     = $userT[0]->subid;
                $_SESSION["pid"]       = $userT[0]->pid;
                $_SESSION["nombre"]    = $userT[0]->person->first_name;
                $_SESSION["apellido0"] = $userT[0]->person->last_name0;
                $_SESSION["apellido1"] = $userT[0]->person->last_name1;
                $_SESSION["email"] = $userT[0]->person->mail_person;
                $_SESSION["cellPhone"] = $userT[0]->person->cellular;

                LogActivity::add($_SESSION["users"]." ha iniciado sesión.", null,null);
            }else{
                LogActivity::add($_POST["user"]." ha intentado iniciar sesión sin exito.", null,null);
            }

        }

        print(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public function closeUser()
    {
        session_destroy();
    }

    public function changePassword(Request $request)
    {
        $array            = array();
        $array["data"]    = array();
        $array["message"] = "";
        $array["state"]   = 0;
        //print_r($_SESSION);
        try {
            $pwc       = $_POST["passwordCurrent"];
            $pwn       = $_POST["passwordNew"];
            $pwv       = $_POST["passwordVerify"];
            $pass      = LoginController::verifyPassword(md5($pwc));
            $someArray = json_decode($pass, true);
            if (strcmp($someArray[0]["password"], md5($pwc)) === 0) {
                if ($_SESSION['role'] == "AD" || $_SESSION['role'] == "SP" || $_SESSION['role'] == "RE" || $_SESSION['role'] == "BU") {
                    $user = User::where("pid", $_SESSION["pid"])->where('uid', $_SESSION["userAdm"])
                        ->update(
                            array(
                                "password" => md5($pwv),
                            )
                        );
                } elseif ($_SESSION['role'] == "AL") {
                    $user = User::where("pid", $_SESSION["pid"])->where('uid', $_SESSION["users"])
                        ->update(
                            array(
                                "password" => md5($pwv),
                            )
                        );
                }
                $array["state"]   = 1;
                $array["message"] = "Contraseña Actualizado con Éxito";
            } else {
                $array["state"]   = 0;
                $array["message"] = "Contraseña Actual es invalida";
            }
        } catch (Exception $e) {
            $array["state"]   = 0;
            $array['message'] = "Error " . $e->getCode() . ": Lo sentimos, Comunicase con el Administrador.";
        }


        LogActivity::add($_SESSION["users"]." ha actualizado su contraseña ".(($array['state']==1)?"con exito":"sin exito").". [".$array["message"]."]", null,json_encode(['session'=>$_SESSION, 'params'=>[]]));

        print(json_encode($array, JSON_UNESCAPED_UNICODE));
    }

    public static function verifyPassword($pwCurrent)
    {
        if ($_SESSION['role'] == "AD" || $_SESSION['role'] == "SP" || $_SESSION['role'] == "RE" || $_SESSION['role'] == "BU") {
            $password = User::select('password')
                ->where([
                    'pid' => $_SESSION['pid'],
                    'uid' => $_SESSION['userAdm'],
                ])->get();
        } elseif ($_SESSION['role'] == "AL") {
            $password = User::select('password')
                ->where([
                    'pid' => $_SESSION['pid'],
                    'uid' => $_SESSION['users'],
                ])->get();
        }
        return $password->toJson();
    }

    public static function getUsers(){
        $query='';
        $data=array();
        if (!empty($_POST["usersSis"])) {
            $query = (empty($query))?'state=? ':'and state=? ';
            array_push($data, $_POST["usersSis"]);
        }

        if (!empty($_POST["usersCom"])) {
            $query = $query.((empty($query))?'state_c=? ':'and state_c=? ');
            array_push($data, $_POST["usersCom"]);
        }

        if (!empty($_POST["select_escuela"])) {
            $query = $query.((empty($query))?'escid=? ':'and escid=? ');
            array_push($data, $_POST["select_escuela"]);
        }

        if (empty($query)) {
            $users = Person::join('base_users','base_person.pid','=', 'base_users.pid')
                        ->selectRaw('base_person.pid, base_users.uid, concat(last_name0,\' \',last_name1, \', \', first_name), state, state_c')
                        ->where(function ($query) {
                            $query->where('base_users.uid', 'LIKE', '%'.$_POST["search"].'%')
                                  ->orWhere('base_users.pid', 'LIKE', '%'.$_POST["search"].'%')
                                  ->orWhereRaw('lower(concat(last_name0, \' \',last_name1,\', \', first_name)) like lower(?)','%'.$_POST["search"].'%');
                        })
                        ->orderByRaw('last_name0, last_name1, first_name')
                        ->get();
        }else{
            $users = Person::join('base_users','base_person.pid','=', 'base_users.pid')
                        ->selectRaw('base_person.pid, base_users.uid, concat(last_name0,\' \',last_name1, \', \', first_name), state, state_c')
                        ->whereRaw($query, $data)
                        ->where(function ($query) {
                            $query->where('base_users.uid', 'LIKE', '%'.$_POST["search"].'%')
                                  ->orWhere('base_users.pid', 'LIKE', '%'.$_POST["search"].'%')
                                  ->orWhereRaw('lower(concat(last_name0, \' \',last_name1,\', \', first_name)) like lower(?)','%'.$_POST["search"].'%');
                        })
                        ->orderByRaw('last_name0, last_name1, first_name')
                        ->get();
        }
        echo $users->toJson();
    }

    public static function changeStateComedor(){
        $stateC = (base64_decode(urldecode($_POST["state"])) == "A")?B:A;
        $state = User::where('uid', base64_decode(urldecode($_POST["id"])))
                        ->update(
                            array(
                                "state_c" => $stateC,
                            )
                        );
        if($stateC=="A"){             
            echo "Usuario Habilitado para el Comedor";
        }else{
            echo "Usuario Inhabilitado para el Comedor";
        }
    }

    public static function changeStateSistema(){
        $stateS = (base64_decode(urldecode($_POST["state"])) == "A")?B:A;
        $state = User::where('uid', base64_decode(urldecode($_POST["id"])))
                        ->update(
                            array(
                                "state" => $stateS,
                            )
                        );
        if($stateS=="A"){             
            echo "Usuario Activo para el Sistema de Comedor";
        }else{
            echo "Usuario Inactivo para el Sistema de Comedor";
        }
    }

    public static function resetPassword(){
        $state = User::where('uid', base64_decode(urldecode($_POST["id"])))
                        ->update(
                            array(
                                "password" => md5($_POST["newPassword"]),
                            )
                        );
        if ($state) {
            echo "Contraseña restablecido con Exito... :)";
        }else{
            echo "Se produjo un Error... :(";
        }
    }
 
    public static function changePasswordApp()
    {
        $array            = array();
        $array["data"]    = array();
        $array["message"] = "";
        $array["state"]   = 0;
        //print_r($_SESSION);
        try {
           
            $uid = $_POST["uid"];
            $eid = $_POST["eid"]; 
            $oid =  $_POST["oid"]; 
            $escid = $_POST["escid"];
            $subid = $_POST["subid"];
            $pid = $_POST["pid"];

            $pwo       = $_POST["password_old"];
            $pwn       = $_POST["password_new"];
            $pwv       = $_POST["repit_password_new"];


            $passwordOld = User::select('password')
                ->where([
                    'uid' => $uid,
                    'eid'=> $eid,
                    'oid'=> $oid,
                    'escid'=> $escid,
                    'subid'=>$subid,
                    'pid' => $pid, 
                    'password'=>md5($pwo)
                ])->get();

            if(count($passwordOld)===0){
                $array["state"]=0;
                $array["message"]="La contraseña actual es incorrecta.";
            }else if(strcmp($pwn, $pwv)!=0){
                $array["state"]=0;
                $array["message"]="Las contraseñas ingresadas no coinciden.";
            }else{
                 $user = User::where([
                    'uid' => $uid,
                    'eid'=> $eid,
                    'oid'=> $oid,
                    'escid'=> $escid,
                    'subid'=>$subid,
                    'pid' => $pid
                ])->update(
                            array(
                                "password" => md5($pwv),
                            )
                        );
                $array["state"]   = 1;
                $array["message"] = "Contraseña Actualizado con Éxito";
            }

        } catch (Exception $e) {
            $array["state"]   = 0;
            $array['message'] = "Error " . $e->getCode() . ": Lo sentimos, Comunicase con el Administrador.";
        }



        print(json_encode($array, JSON_UNESCAPED_UNICODE));
    }


     /*public static function getDataUserssss()
        {
            $array            = array();
            $array["data"]    = array();
            $array["message"] = "";
            $array["state"]   = 0;
            //print_r($_SESSION);
            try {
               
                $uid = $_POST["uid"];
                $eid = $_POST["eid"]; 
                $oid =  $_POST["oid"]; 
                $escid = $_POST["escid"];
                $subid = $_POST["subid"];
                $pid = $_POST["pid"];



                $passwordOld = User::select('password')
                    ->where([
                        'uid' => $uid,
                        'eid'=> $eid,
                        'oid'=> $oid,
                        'escid'=> $escid,
                        'subid'=>$subid,
                        'pid' => $pid
                    ])->get();

                $array["state"]   = 1;
                $array["message"] = "Contraseña Actualizado con Éxito";

            }catch (Exception $e) {
                $array["state"]   = 0;
                $array['message'] = "Error " . $e->getCode() . ": Lo sentimos, Comunicase con el Administrador.";
            }
            print(json_encode($array, JSON_UNESCAPED_UNICODE));
        } */

}
