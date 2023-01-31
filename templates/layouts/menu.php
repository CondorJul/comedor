<!--<div class="app-sidebar__overlay" data-toggle="sidebar"></div>-->
<aside class="app-sidebar">
	<!--<div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
        <div>
        	<p class="app-sidebar__user-name">John Doe</p>
          	<p class="app-sidebar__user-designation">Frontend Developer</p>
        </div>
    </div>-->
    <ul class="app-menu">
      <div class="dropdown-divider">
      </div>
      <?php if($_SESSION["role"] === "SP"){?>
        <li>
          <a class="app-menu__item" href="usuarios"><i class="app-menu__icon fas fa-users" aria-hidden="true"></i><span class="app-menu__label">Usuarios</span></a>
        </li>
      <?php } ?>  
      <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP"){?>
        <li>
          <a class="app-menu__item" href="asistencia"><i class="app-menu__icon fa fa-address-card" aria-hidden="true"></i><span class="app-menu__label">Asistencia</span></a>
        </li>
      <?php } ?>
      <?php if($_SESSION["role"] === "AL" or $_SESSION["role"] === "SP"){?>
  	  <li>
        <a class="app-menu__item" href="reserva"><i class="app-menu__icon fas fa-calendar-check"></i><span class="app-menu__label">Reservar Menú</span></a>
      </li>
      <?php } ?>
      <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP"){?>
        <li>
          <a class="app-menu__item" href="menu"><i class="app-menu__icon fas fa-utensils"></i><span class="app-menu__label">Menú</span></a>
        </li>
      <?php } ?>
      <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP"){?>
        <li>
          <a class="app-menu__item" href="horario"><i class="app-menu__icon fas fa-clock"></i><span class="app-menu__label">Horarios</span></a>
        </li>
      <?php } ?>
      <li>
        <a class="app-menu__item" href="novedades"><i class="app-menu__icon fas fa-bookmark"></i><span class="app-menu__label"> Noticias</span>
        </a>
      </li>
      <?php if($_SESSION["role"] === "SP" or $_SESSION["role"] === "AD" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
        <li>
          <a class="app-menu__item" href="sugerencias"><i class="app-menu__icon fas fa-comment-dots"></i><span class="app-menu__label">Sugerencias</span></a>
        </li>
      <?php } ?>
      <?php if($_SESSION["role"] === "SP" or ($_SESSION["role"] === "AL" AND $_SESSION["users"]==="1394403041")){?>
        <li>
          <a class="app-menu__item" href="justificaciones"><i class="app-menu__icon fas fa-file-signature"></i><span class="app-menu__label">Reservaciones</span></a>
        </li>
      <?php } ?>
      <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-chart-bar"></i></i><span class="app-menu__label">Reportes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
          
            <li><a class="treeview-item" href="reporte1"><i class="fa fa-calendar-alt"></i>&nbspAsistencia Diaria</a></li>
          
            <?php } ?>

            <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
           
            <li><a class="treeview-item" href="reporte2"><i class="fa fa-calendar-alt"></i>&nbspCantidad de Reserva</a></li>
           
            <?php } ?>
            
            <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
           
            <li><a class="treeview-item" href="reporte3"><i class="fa fa-calendar-alt"></i>&nbspAsistencia por Periodo</a></li>
           
            <?php } ?>


            <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
           
            <li><a class="treeview-item" href="reporte9"><i class="fa fa-calendar-alt"></i>&nbspAsistencias por Fechas</a></li>
           
            <?php } ?>


             <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
           
            <li><a class="treeview-item" href="reporte4"><i class="fa fa-calendar-alt"></i>&nbspGrafica Semanal</a></li>
           
            <?php } ?>


             <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
           
            <li><a class="treeview-item" href="reporte5"><i class="fa fa-calendar-alt"></i>&nbspGrafica Reservaciones</a></li>
           
            <?php } ?>

              <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
           
            <li><a class="treeview-item" href="reporte6"><i class="fa fa-calendar-alt"></i>&nbspHorario Preferido</a></li>
           
            <?php } ?>

             <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
           
            <li><a class="treeview-item" href="reporte7"><i class="fa fa-calendar-alt"></i>&nbspCantidad por Tipo</a></li>
           
            <?php } ?>

            <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
           
            <li><a class="treeview-item" href="reporte8"><i class="fa fa-calendar-alt"></i>&nbspMovil-Web</a></li>
           
            <?php } ?>

            <?php if($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP" or $_SESSION["role"] === "RE" or $_SESSION["role"] === "BU"){?>
           
            <li><a class="treeview-item" href="reporte10"><i class="fa fa-calendar-alt"></i>&nbspRanking Menú</a></li>
           
            <?php } ?>

            <?php if($_SESSION["role"] === "SP"){?>

            <li><a class="treeview-item" href="#"><i class="fa fa-calendar-alt"></i>&nbspOtro</a></li>
            
            <?php } ?>

          </ul>
        </li>  
      <?php } ?>       
    </ul>

</aside>