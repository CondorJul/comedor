<?php 

namespace App\Controllers;

use App\Routing\Route;


class PagesController  extends Route
{
	public function principal()
    {

    	return Route::route("menu/menusemanal");
    	
    	
    }
}

