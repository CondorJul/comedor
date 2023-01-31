<div class="modal fade" id="modalpassword" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Cambiar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cleanModal();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal needs-validation" id="formPassword" name="formPassword" novalidate>
          <label>Contraseña Actual</label>
          <div class="input-group input-group-sm mb-2">
            <input type="password" class="form-control" name="passwordCurrent" id="passwordCurrent" placeholder="Ingrese Contraseña Actual" onblur="revisarNoObligatorio(this)" onkeyup="revisarNoObligatorio(this)">
            <div class="invalid-feedback" style="margin-left: 0px;" id="currentPass" name="currentPass">Ingrese su contraseña actual</div>
          </div>
          <label>Nueva Contraseña</label>
          <div class="input-group input-group-sm mb-2">
            <input type="password" class="form-control" name="passwordNew" id="passwordNew" placeholder="Ingrese Nueva Contraseña" onblur="revisarNoObligatorio(this)" onkeyup="revisarNoObligatorio(this)">
            <div class="invalid-feedback" style="margin-left: 0px;">Ingrese una Nueva Contraseña</div>
          </div>
          <label>Verifique Nueva Contraseña</label>
          <div class="input-group input-group-sm mb-2">
            <input type="password" class="form-control" name="passwordVerify" id="passwordVerify" placeholder="Verifique Nueva Contraseña" onblur="revisarNoObligatorio(this)" onkeyup="revisarNoObligatorio(this)">
            <div class="invalid-feedback" style="margin-left: 0px;" id="verifyPass" name="verifyPass">Verifique su Nueva Contraseña</div>
          </div>
          <div id="verifyPassword"></div>
      </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cleanModal();">Cancelar</button>
            <button type="submit" class="btn btn-success" id="botonCambiarContrasena" name="botonCambiarContrasena"><i class="far fa-save"></i> Guardar</button>  
          </div>
        </form>
    </div>
  </div>
</div>
