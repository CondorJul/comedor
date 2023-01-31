<header class="app-header">
	<a class="app-sidebar__toggle" href="#" data-toggle="sidebar"></a>
	<img class="app-logo" src="img/undac.png" height="30px" width="30px">
	<a class="app-nav__item" href="interfaz.php" id="app-logo"> Comedor Universitario</a>
	
	

	<ul class="app-nav ml-auto">

		<?php if ($_SESSION["role"] === "AL") {?>

	    	<div class="d-flex align-items-center ">
	    		<button type="button" id="btnNuevaSugerencia" class="btn btn-success pull-right d-md-block d-lg-block d-xl-block " data-toggle="modal" data-target="#modalNuevaSugerencia" style="border-radius: 300px "> &nbsp<i class="fas fa-parachute-box fa-lg" style="color:white; "></i></button>
	    	</div>

	 	<?php }?>

		<li class="dropdown d-block d-sm-block d-md-none d-lg-none d-xl-none"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg" style="color: #fff;"> </i></a>
	    	<ul class="dropdown-menu settings-menu dropdown-menu-right" style="width: 252px;">
	    		<li><a class="dropdown-item" href="#"><i class="fa fa-cog fa-lg"></i> <?php $d = (isset($_SESSION["apellido0"])) ? $_SESSION["apellido0"] . " " . $_SESSION["apellido1"] . " " . $_SESSION["nombre"] : "Apellidos y nombres";
echo $d?></a></li>
	        	<li><a class="dropdown-item" href="#"><i class="fa fa-cog fa-lg"></i> <?php $role = (isset($_SESSION["role"])) ? (strcmp($_SESSION["role"], "AL") === 0) ? "Alumno" : "Administrador" : "Rol";
echo $role?></a></li>
	    		<li class="modifypassword" ><a data-toggle="modal" data-target="#modalpassword" class="dropdown-item" href="#"><i class="fa fa-user fa-lg" ></i> Cambiar Contraseña</a></li>
	        	<li class="cerrar"><a class="dropdown-item" href="#"><i class="fa fa-user fa-lg" ></i> Cerrar Sesión</a></li>
	      	</ul>
	    </li>
	    <li class="dropdown d-none d-sm-none d-md-block d-lg-block d-xl-block">
	    	<a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"> </i> <?php echo $d ?></a>
	    	<ul class="dropdown-menu settings-menu dropdown-menu-right">
	        	<li><a class="dropdown-item" href="#"><i class="fa fa-cog fa-lg"></i><?php echo $role ?></a></li>
	    		<li class="modifypassword" ><a data-toggle="modal" data-target="#modalpassword" class="dropdown-item" href="#"><i class="fa fa-user fa-lg" ></i> Cambiar Contraseña</a></li>
	        	<li class="cerrar"><a class="dropdown-item" href="#"><i class="fa fa-user fa-lg" ></i> Cerrar Sesión</a></li>
	      	</ul>
	    </li>
	  </ul>

</header>

<?php include "modalmodifypassword.php";?>
<?php include "../templates/sugerencias/modal/modalNuevaSugerencia.php";?>


<!--$_SESSION["apellido0"]." ".$_SESSION["apellido1"]." ".$_SESSION["nombre"]