<div class="modal fade" id="modalSolicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Justificación de Inasistencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height: 430px;  width: 100%;  overflow-y: auto;">
        <div class="container cuerpo">
          <div class="row pull-right">
            <div class="col-4">
              Solicito:
            </div>
            <div class="col-8">
              <strong class="text-center">Justificación de<br>Inasistencia.</strong>
            </div>
          </div>
          <br>
          <br>
          <br>
          <div>
            <label id="Distinatario">Sra. DIRECTORA DE LA OFICINA DE BIENESTAR UNIVERSITARIO.</label><br>
            <label id="usersName">Apellidos y Nombres: <strong> <?php echo $_SESSION["apellido0"].' '.$_SESSION["apellido1"].' '.$_SESSION["nombre"]; ?></strong></label>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
              <label id="usersDni">D.N.I. : <strong><?php echo $_SESSION["pid"]; ?></strong></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
              <label id="usersCodigo">Código Matricula : <strong><?php echo $_SESSION["users"]; ?></strong></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
              <label id="usersCelular">N° Cel. : <strong><?php echo $_SESSION["cellPhone"]; ?></strong></label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
              <label id="usersCorreo">Correo : <strong><?php echo $_SESSION["email"]; ?></strong></label>
            </div>
          </div>
          <div class="fundamento">
            <label><strong>FUNDAMENTO DE PEDIDO : </strong></label>
            <p class="text-justify" style="text-indent: 50px;">Con especial agrado me dirijo a usted, para expresarle mis cordiales saludos a la vez solicitarle <strong>Justificación de Inasistencia</strong> al Comedor Universitario del presente mes.</p>
          </div>
          <div class="motivo">
            <label><strong>POR MOTIVO : </strong></label>
            <form class="form-horizontal needs-validation" name="formSolicitud" id="formSolicitud" novalidate>
              <p><textarea class="form-control" id="textareaMotivo" name="textareaMotivo" autofocus></textarea></p>
            </form>
          </div>
          <div class="despedida">
            <p class="text-justify">En espera de su pronta atencion al presente, sirvase atender mi petición.</p>
          </div>
          <br>
          <br>
          <div class="text-center">
            <p>Atentamente,</p>
          </div>
          <br>
          <br>
          <br>
          <div class="firma text-center" style="line-height: 1.4;">
            ________________________________ <br>
            <?php echo $_SESSION["apellido0"].' '.$_SESSION["apellido1"].' '.$_SESSION["nombre"]; ?> <br>
            D.N.I. : <?php echo $_SESSION["pid"]; ?> <br>
          </div>
          <br>
          <div class="col-auto my-1 text-justify">
            <div class="custom-control custom-checkbox mr-sm-2">
              <input type="checkbox" class="custom-control-input" id="checkConfirmation">
              <label class="custom-control-label" for="checkConfirmation">Me comprometo a Regularizar los requisitos correspondientes en la Oficina de Bienestar Universitario. Para continuar con los trámites correspondientes.</label>
            </div>
          </div>
        </div>
      </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="btnEnviarSolicitud" name="btnEnviarSolicitud"><i class="fas fa-share-square"></i> Enviar Solicitud</button>
      </div>
    </div>
  </div>
</div>