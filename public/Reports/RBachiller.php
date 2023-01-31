<?php 
  if(!isset($_SESSION["logged_is_user"])){
    header("Location: http://comedor.undac.edu.pe/");
    exit();
  }elseif($_SESSION["role"] !== "SP"){
    if(isset($_SERVER['HTTP_REFERER'])){
      header("Location:".$_SERVER['HTTP_REFERER']);    
    }else{
      header("Location: http://comedor.undac.edu.pe/");
    }
    exit();
  } 
?>
<!DOCTYPE html>
<html lang="es">
  <?php include "../templates/layouts/head1.php"; ?>
<body class="app sidebar-mini rtl sidenav-toggled" style="min-width: 280px;">
  <?php include "../templates/layouts/header.php"; ?>
  <?php include "../templates/layouts/menu.php"; ?>

  <main class="app-content" style="background: white;">
    <div class="row">
      <div class="col-lg-3">
        <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="card">
            <h3 class="card-header text-center bg-primary" style="color: #fff; font-weight: bold; font-family: 'arial narrow';">Busqueda<span class="fas fa-search pull-right"></span></h3>
            <div class="card-block p-2">
              <form class="form-horizontal needs-validation" name="form_reporte" id="form_reporte" novalidate>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio1" name="usersSis" class="custom-control-input sistema" checked="" value="">
                  <label class="custom-control-label" for="customRadio1"> Todos los Usuarios del Sistema</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio2" name="usersSis" class="custom-control-input sistema" value="A">
                  <label class="custom-control-label" for="customRadio2"> Usuarios Activos del Sistema.</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio3" name="usersSis" class="custom-control-input sistema" value="B">
                  <label class="custom-control-label" for="customRadio3"> Usuarios Inactivos del Sistema.</label>
                </div>
                <hr>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio4" name="usersCom" class="custom-control-input comedor" checked="" value="">
                  <label class="custom-control-label" for="customRadio4"> Todos los Usuarios del Comedor.</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio5" name="usersCom" class="custom-control-input comedor" value="A">
                  <label class="custom-control-label" for="customRadio5"> Usuarios Habilitados para el Comedor.</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="customRadio6" name="usersCom" class="custom-control-input comedor" value="B">
                  <label class="custom-control-label" for="customRadio6"> Usuarios Inhabilitados para el Comedor.</label>
                </div>
                <hr>
                <div class="input-group input-group-sm col-lg-12 col-12 pl-0 pr-0">
                  <select class="form-control" value="" id="select_escuela" name="select_escuela">     
            
                  </select>
                </div>
                <hr>
                <div class="input-group input-group-sm col-lg-12 col-12 pl-0 pr-0">
                  <input type="text" class="form-control" id="search" name="search" placeholder="Apellidos y Nombres/Cód. de Matrícula" onkeyup='listUsers(this.value);'>
                  <div class="input-group-append" style="height: 30px;">
                    <button type="button" class="btn btn-info" id="botonBuscarUsers" name="botonBuscarUsers"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="card">
            <h3 class="card-header text-center bg-primary" style="color: #fff; font-weight: bold; font-family: 'arial narrow';">Lista de Usuarios<span class="fas fa-users pull-right"></span></h3>
            <div class="card-block p-3">
              <div class="card-body table-responsive p-0" id="tabla_resultado" style="height:423px; overflow:auto;">
                <table class="table table-hover table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th scope="col" class="text-center">DNI</th>
                      <th scope="col" class="text-center">Código</th>
                      <th scope="col" class="text-center">Apellidos y Nombres</th>
                      <th scope="col" class="text-center">Estado(S)</th>
                      <th scope="col" class="text-center">Estado(C)</th>
                      <th scope="col" class="text-center">Opciones</th>
                    </tr>
                  </thead>

                    <tbody id="tbodyUsuarios">
                    </tbody>
                </table>
                <div class="text-center" id="mensajeErrorUser">

                </div>
                <div id="mostrar_loadingH" style="display: none;">
                  <?php include "../templates/layouts/loading.html";?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <!--modal restablecer contraseña-->
    <div id="passwordReset" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Restablecer Contraseña</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="input-group input-group-sm col-lg-12 col-12 pl-0 pr-0">
                <input type="password" class="form-control" id="pw" name="pw" placeholder="Nueva Contraseña">
                <div class="input-group-append">
                  <button type="button" class="btn btn-secondary" id="verPw" name="verPw" data-status="true"><i class="fas fa-eye"></i></button>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-success btn-sm" id="restablecerPw" name="restablecerPw">Restablecer</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include "../templates/layouts/scriptFinal.php"; ?>
  <script src="http://comedor.undac.edu.pe//js/horario/horario.js"></script>
  
</body>
</html>
<?php 

  require('../fpdf/force_justify.php');
    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();
    
    $pdf->SetAlpha(0.08);
    $pdf->Image('img/nacional.gif',15,60,180);
    $pdf->SetAlpha(1);

    $pdf->SetFont('Helvetica', 'BIU', 13);
    $y=$pdf->GetY();
    $pdf->setXY(40, $y+8);
    $pdf->MultiCell(130, 8, utf8_decode('CONSTANCIA DE DATOS ESTADÍSTICOS PARA OPTAR EL GRADO DE BACHILLER'),0,'C',0);

    $pdf->SetFont('Times','', 13);
    $y=$pdf->GetY();
    $pdf->SetXY(30, $y+5);
    $pdf->Cell(90, 12, utf8_decode('CÓDIGO DE MATRICULA : '),0,0,'R');
    $pdf->SetFont('Times', 'BU', 13);
    $pdf->Cell(60, 12, utf8_decode($arrayAcademico['Codigo']),0,1,'L');

    $pdf->SetFont('Times', '', 12);
    $pdf->SetX(30);
    $pdf->Cell(50, 8, utf8_decode('Apellidos y Nombres  : '),0,0,'L');
    $pdf->SetFont('Times', 'BU', 12);
    $pdf->Cell(100, 8, utf8_decode($arrayAlumno['ApellidoPaterno']." ".$arrayAlumno['ApellidoMaterno'].", ".$arrayAlumno['Nombres']),0,1,'L');

    $pdf->SetFont('Times', '', 12);
    $pdf->SetX(30);
    $pdf->Cell(50, 8, utf8_decode('Facultad: '),0,0,'L');
    $pdf->SetFont('Times', 'BU', 12);
    $pdf->Cell(100, 8,  utf8_decode($arrayAcademico['facultad']),0,1,'L');
    
    $pdf->SetFont('Times', '', 12);
    $pdf->SetX(30);
    $pdf->Cell(50, 8, utf8_decode('Escuela      : '),0,0,'L');
    $pdf->SetFont('Times', 'BU', 11);
    $pdf->Cell(100, 8,utf8_decode($arrayAcademico['escuela']),0,1,'L');

if ($arrayAcademico['CodFac']==='2') {
  $pdf->SetFont('Times', '', 12);
  $pdf->SetX(30);
  $pdf->Cell(50, 8, utf8_decode('Especialidad :'),0,0,'L');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(100, 8, utf8_decode($arrayAcademico['especialidad']),0,1,'L');
 }
  $pdf->SetFont('Times', '', 12);
  $pdf->SetX(30);
  $pdf->Cell(50, 8, utf8_decode('Grado de Bachiller en :'),0,0,'L');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(100, 8, utf8_decode($arrayAcademico['bachiller']),0,1,'L');
  
  $pdf->SetFont('Times', '', 12);
  $y=$pdf->GetY();
  $pdf->SetXY(30, $y+6);
  $pdf->MultiCell(150, 8, utf8_decode('Ha cumplido con rellenar su Ficha de Estadística, requisito indispensable para la entrega del diploma del Grado Académico de Bachiller.'),0,'J',0);
  
  $pdf->SetFont('Times', '', 12);
  $y=$pdf->GetY();
  $pdf->setXY(90,$y+15);
  $pdf->Cell(30,8, utf8_decode('Cerro de Pasco, '),0,0,'R');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(10,8, utf8_decode($arrayAcademico['dia']),0,0,'C');
  $pdf->SetFont('Times', '', 12);
  $pdf->Cell(10,8, utf8_decode('de'),0,0,'C');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(20,8, utf8_decode($mes),0,0,'C');
  $pdf->SetFont('Times', '', 12);
  $pdf->Cell(10,8, utf8_decode('del'),0,0,'C');
  $pdf->SetFont('Times', 'BU', 12);
  $pdf->Cell(10,8, utf8_decode($arrayAcademico['anio']),0,1,'L');
 
  $pdf->Line(70, 180, 210-70, 180);
  $pdf->SetFont('Times', '', 12);
  $pdf->setXY(30,180);
  $pdf->Cell(150,6, utf8_decode('V°B° Dirección de Estadística'),0,0,'C');
  
  $pdf->Output();
?>