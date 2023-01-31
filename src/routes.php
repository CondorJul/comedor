<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();    

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {

        // Render index view
        return $container->get('renderer')->render($response, 'login/login.phtml', $args);
    });


    // get all todos
    $app->get('/usuarios', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'usuarios/usuarios.php', $args);

    });

    // get all todos
    $app->get('/asistencia', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'asistencia/asistencia.phtml', $args);

    });

    // get all todos
    $app->get('/reserva', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'reserva/reserva.php', $args);

    });

    // get all todos
    $app->get('/novedades', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'novedades/novedades.php', $args);

    });



    $app->get('/sugerencias', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'sugerencias/sugerencias.php', $args);

    });

    $app->get('/justificaciones', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'justificaciones/justificaciones.php', $args);

    });

    // get all todos
    $app->get('/menu', function ($request, $response, $args) use ($container) {
       return $container->get('renderer')->render($response, 'menu/menusemanal.php', $args);
    });

    // get all todos
    $app->get('/reporte1', function ($request, $response, $args) use ($container) {
       return $container->get('renderer')->render($response, 'reporte/reporte1.php', $args);

    });

    $app->get('/reporte2', function ($request, $response, $args) use ($container) {
       return $container->get('renderer')->render($response, 'reporte/reporte2.php', $args);

    });

    $app->get('/reporte3', function ($request, $response, $args) use ($container) {
       return $container->get('renderer')->render($response, 'reporte/reporte3.php', $args);

    });

    $app->get('/reporte4', function ($request, $response, $args) use ($container) {
       return $container->get('renderer')->render($response, 'reporte/reporte4.php', $args);

    });

    $app->get('/reporte5', function ($request, $response, $args) use ($container) {
       return $container->get('renderer')->render($response, 'reporte/reporte5.php', $args);
    });

    $app->get('/reporte6', function ($request, $response, $args) use ($container) {
       return $container->get('renderer')->render($response, 'reporte/reporte6.php', $args);
    });

    $app->get('/reporte7', function ($request, $response, $args) use ($container) {
       return $container->get('renderer')->render($response, 'reporte/reporte7.php', $args);
    });
     $app->get('/reporte8', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'reporte/reporte8.php', $args);

    });

    $app->get('/reporte9', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'reporte/reporte9.php', $args);

    });

     $app->get('/reporte10', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'reporte/reporte10.php', $args);

    });

    // get all todos
    $app->get('/horario', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'horario/horarios.php', $args);

    });
 
    // Retrieve todo with id 
    $app->get('/todo/[{id}]', function ($request, $response, $args) use ($container){
       //return "nueva ruta";
       return $container->get('renderer')->render($response, 'index.phtml', $args);
    });
 
 
    // Search for todo with given search teram in their name
    $app->get('/todos/search/[{query}]', function ($request, $response, $args) {
        return "otra mas";
    });

  // get all todos
    $app->get('/politica_privacidad', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'politica_privacidad/politica_privacidad.php', $args);

    });

    /*$app->get('/prueba', function () {

        Fpdf::AddPage();
        Fpdf::SetFont('Courier', 'B', 18);
        Fpdf::Cell(50, 25, 'Hello World!');
        Fpdf::Output();

    });*/

    /*$app->get('/prueba', function (Codedge\Fpdf\Fpdf\Fpdf $fpdf) {

        $fpdf->AddPage();
        $fpdf->SetFont('Courier', 'B', 18);
        $fpdf->Cell(50, 25, 'Hello World!');
        $fpdf->Output();

    });*/


    /*====================================
    =            route menu              =
    ====================================*/

    $app->get('/create/usuario/nuevo/{query}', 'App\Controllers\MenuController:getDataBySpecificId');
    $app->get('/menu/dato/todo/', 'App\Controllers\MenuController:getData');
    $app->post('/create/menu/', 'App\Controllers\MenuController:setMenu');
    $app->post('/update/menu/', 'App\Controllers\MenuController:updateMenu');
    $app->post('/delete/menu/', 'App\Controllers\MenuController:deleteMenu');
    $app->post('/capturarEspecifico/menu/', 'App\Controllers\MenuController:getDataBySpecificId');
    $app->get('/menu/today', 'App\Controllers\MenuController:getMenuToday');
    $app->post('/menu/checkMenuEnable','App\Controllers\MenuController:checkMenuEnable');
    $app->get('/listar/menu/second/', 'App\Controllers\MenuController:listSecond');
    $app->get('/listar/menu/soup/', 'App\Controllers\MenuController:listSoup');
    $app->get('/listar/menu/drink/', 'App\Controllers\MenuController:listDrink');
    $app->get('/listar/menu/fruit/', 'App\Controllers\MenuController:listFruit');
    $app->get('/listar/menu/dessert/', 'App\Controllers\MenuController:listDessert');
    $app->get('/listar/menu/aditional/', 'App\Controllers\MenuController:listAditional');

    /*=====  End of route asistencia  ======*/ 

    /*para el app android */

    $app->post('/menu/checkMenuReservationEnable','App\Controllers\MenuController:checkMenuReservationEnable');




    /*====================================
    =            route asistencia           =
    ====================================*/
    $app->get('/asistencia/horary', 'App\Controllers\HoraryController:getDataBySpecificType');
    $app->post('/asistencia/cerrar/menu', 'App\Controllers\ReservationController:closeMenu');   

    /*=====  End of route asistencia  ======*/ 
    

    /*====================================
    =            route horary            =
    ====================================*/
    $app->post('/horario/dato/todo/', 'App\Controllers\HoraryController:getData');  
    $app->post('/create/horario/', 'App\Controllers\HoraryController:setHorario');
    $app->post('/obtener/horario/', 'App\Controllers\HoraryController:getDataBySpecificId');
    $app->post('/update/horario/', 'App\Controllers\HoraryController:updateHorario');
    $app->post('/delete/horario/', 'App\Controllers\HoraryController:deleteHorario');
    $app->post('/horario/getHoraryCantReser','App\Controllers\HoraryController:getDataHoraryCantReservation');

    /*para el app android */
    $app->post('/horario/getAppHorary','App\Controllers\HoraryController:getDataHorary');
  

    $app->get('/horario/getAppCantReservationPrueba','App\Controllers\HoraryController:getDataHoraryCantReservationAppPrueba');

    /*=====  End of route horary  ======*/
    

    /*=======================================
    =            route novedades            =
    =======================================*/
    
    $app->post('/novedades/dato/todo/', 'App\Controllers\NovedadesController:getNovedades'); 
    $app->post('/novedades/dato/state/', 'App\Controllers\NovedadesController:getNovedadesState'); 
    $app->post('/create/novedad/', 'App\Controllers\NovedadesController:setNovedades'); 
    $app->post('/novedades/delete/specific/', 'App\Controllers\NovedadesController:deleteNov');
    $app->post('/novedades/update/specific/', 'App\Controllers\NovedadesController:getDataSpecific');
    $app->post('/novedades/update/state/', 'App\Controllers\NovedadesController:updateState');
    $app->post('/novedades/search/dato/', 'App\Controllers\NovedadesController:getNovedadesSearch');
    
    /*=====  End of route novedades  ======*/
    
 
    
    /*====================================
    =            routes login            =
    ====================================*/
    
    $app->post('/validate/login/user/', 'App\Controllers\LoginController:validateUser');
    $app->post('/close/login/user/', 'App\Controllers\LoginController:closeUser');

     /*Login app*/
    
    /*=====  End of routes login  ======*/

    /*====================================
    =            routes reserva          =
    ====================================*/
    
    $app->post('/create/reservation/', 'App\Controllers\ReservationController:setReservation');
    $app->post('/capture/reservation/', 'App\Controllers\ReservationController:getDataSpecific');
    $app->post('/updateAssist/reservation', 'App\Controllers\ReservationController:updateAssist');
    $app->post('/reserva/cantReservation/', 'App\Controllers\ReservationController:getCantReservation');
    $app->post('/reserva/asistencia', 'App\Controllers\ReservationController:getDataReservationAsisst');
    $app->post('/reserva/asistenciasFaltas', 'App\Controllers\ReservationController:getDataCantAssistFaults');
    $app->post('/reporte/period', 'App\Controllers\ReporteController:getPeriod');
    $app->post('/reporte/months_by_period', 'App\Controllers\ReporteController:getMonthsByPeriod');
    $app->get('/obtener/lista/puntuaciones', 'App\Controllers\HistorialReservationController:getListPuntuation');
    $app->post('/usuario/send/punctuationMenu/', 'App\Controllers\HistorialReservationController:updateScore');
    $app->post('/usuario/send/commentsMenu/', 'App\Controllers\HistorialReservationController:updateComment');
    $app->get('/usuario/count/listMenu/', 'App\Controllers\HistorialReservationController:countMenu');

    /*=====  End of routes reserva  ======*/

    /*====================================
    =            routes reporte          =
    ====================================*/
    
    $app->post('/reporte/reservaciones/fecha/', 'App\Controllers\ReporteController:getReportReservationDate');
    $app->post('/reporte/cantidad/reservaciones/fecha/', 'App\Controllers\ReporteController:getReportCantReservationDate');
    $app->post('/reporte/get_more_asssist', 'App\Controllers\ReporteController:getMoreAssists');

    $app->post('/reporte/get_more_asssist_by_interval_date', 'App\Controllers\ReporteController:getMoreAssistsByDateInterval');


    
    $app->post('/reporte/get_all_by_day_of_week', 'App\Controllers\ReporteController:getAllByDayOfWeek');
    $app->post('/reporte/get_reservation_by_hour', 'App\Controllers\ReporteController:getReservationByHour');
    $app->post('/reporte/get_all_by_horary', 'App\Controllers\ReporteController:getAllByHorary'); 
    $app->post('/reporte/get_all_by_type', 'App\Controllers\ReporteController:getAllByType'); 
    
    $app->post('/reporte/get_all_reservation_last_23_day', 'App\Controllers\ReporteController:getAllReservationLast23Day'); 

      $app->post('/reporte/getMenuRanking', 'App\Controllers\ReporteController:getMenuRanking'); 
         
        
    /*=====  End of routes reporte  ======*/    


    /*====================================
    =            routes usuarios          =
    ====================================*/
    $app->post('/login/changePassword/current/', 'App\Controllers\LoginController:changePassword');
    $app->post('/obtener/lista/usuarios/', 'App\Controllers\LoginController:getUsers');
    $app->post('/usuario/cambiar/estadoComedor/', 'App\Controllers\LoginController:changeStateComedor');
    $app->post('/usuario/cambiar/estadoSistema/', 'App\Controllers\LoginController:changeStateSistema');
    $app->post('/usuario/restablecer/contrasena/', 'App\Controllers\LoginController:resetPassword');
 
    /*=====  End of routes usuarios  ======*/ 


    /*====================================
    =            routes sugerencias      =
    ====================================*/
    $app->post('/sugerencias/create/', 'App\Controllers\SuggestionsController:setSuggestions');

    $app->post('/sugerencias/list/', 'App\Controllers\SuggestionsController:getSuggestions');
    $app->post('/sugerencias/update/priority', 'App\Controllers\SuggestionsController:setPriority');
    
    /*=====  End of routes sugerencias  ======*/


    /*====================================
    =       routes especialidades        =
    ====================================*/
    $app->get('/obtener/lista/escuelas/', 'App\Controllers\SpecialityController:getSpeciality');
    /*=====  End of routes especialidades  ======*/

    /*====================================
    =       routes justificaciones       =
    ====================================*/
    $app->post('/obtener/lista/reservaciones/', 'App\Controllers\HistorialReservationController:getReservationJustify');
    $app->post('/cantidad/justificaciones/', 'App\Controllers\HistorialReservationController:getCantReservationJustify');
    /*=====  End of routes especialidades  ======*/


    //POST Y CONSULTAS DE APP
    
    $app->get('/novedadesApp', function ($request, $response, $args) use ($container) {
        //return "hola";
       return $container->get('renderer')->render($response, 'novedadesApp/novedades.php', $args);

    });

    $app->post('/validate/login/userApp', 'App\Controllers\LoginController:validateUserApp');


    $app->post('/create/reservationApp', 'App\Controllers\ReservationController:setReservationApp');


    $app->post('/menu/checkMenuEnableApp','App\Controllers\MenuController:checkMenuEnableApp');
    $app->post('/menu/getAppMenu','App\Controllers\MenuController:getDataBySpecificTypeMenuWeek');


    $app->post('/horario/getAppCantReservation','App\Controllers\HoraryController:getDataHoraryCantReservationApp');


   $app->post('/login/changePassword', 'App\Controllers\LoginController:changePasswordApp');  

    $app->post('/reservation/getCantAllReservationApp','App\Controllers\ReservationController:getCantAllReservationApp');

    $app->post('/sugerencias/create/app', 'App\Controllers\SuggestionsController:setSuggestionsApp');
    //Consultas para el app
    $app->post('/app/home/getListItemsView', 'App\ControllersApp\HomeController:getListItemsView');
    $app->post('/menu/getAppMenu/active/app','App\ControllersApp\MenuController:getDataBySpecificTypeActiveReservationApp');

    $app->post('/app/reservation/getMenuReservationsToday','App\ControllersApp\ReservationController:getMenuReservationsToday');

    $app->post('/app/news/getLatestNews', 'App\ControllersApp\NewsController:getLatestNews');


    $app->post('/app/token_users_firebase/saveNewInstanceIdToken', 'App\ControllersApp\TokenUsersFirebaseController:saveNewInstanceIdToken');

    $app->post('/app/reservation/setScore','App\ControllersApp\ReservationController:setScore');

    $app->post('/app/reservation/setComment','App\ControllersApp\ReservationController:setComment');

    $app->post('/app/history_reservation/getListForJustification','App\ControllersApp\HistoryReservationController:getListForJustification');

    $app->post('/app/menu/getDataBySpecificTypeMenuWeek','App\ControllersApp\MenuController:getDataBySpecificTypeMenuWeek');

    $app->post('/app/menu/getMenuAll','App\ControllersApp\MenuController:getMenuAll');
    $app->post('/app/menu/getMenu','App\ControllersApp\MenuController:getMenu');

    $app->post('/app/history_reservation/getReservation','App\ControllersApp\HistoryReservationController:getReservation');

    $app->post('/app/token_users_firebase/saveDateLoggedInLast', 'App\ControllersApp\TokenUsersFirebaseController:saveDateLoggedInLast');
    
    $app->post('/app/token_users_firebase/saveDateLogout', 'App\ControllersApp\TokenUsersFirebaseController:saveDateLogout');
    $app->get('/app/token_users_firebase/getList', 'App\ControllersApp\TokenUsersFirebaseController:getList');


    $app->post('/app/justification/getStateMessage', 'App\ControllersApp\JustificationController:getStateMessage');

    $app->post('/app/justification/getCountForJustification', 'App\ControllersApp\JustificationController:getCountForJustification');


    $app->get('/prueba/preuba', 'App\Controllers\NovedadesController:sendNotificationToUser');

};
