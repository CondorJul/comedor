<?php if ($_SESSION["role"] === "AD" or $_SESSION["role"] === "SP") {?>
<div class="modal fade" id="menu" tabindex="-1" role="dialog" aria-labelledby="menu" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="menuTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cleanModal();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form class="form-horizontal needs-validation" id="formMenu" name="formMenu" novalidate>
          <!--<input type="hidden" id="tipoMenu" name="tipoMenu">-->
          <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text"><b>Fecha : </b></span>
            </div>
            <input type="date" class="form-control"  onblur="validarFormatoFecha(this); existeFecha(this)" onkeyup="validarFormatoFecha(this); existeFecha(this)" name="fecha" id="fecha" required="" readonly="">
            <div class="invalid-feedback">
              El campo Fecha esta incorrecta
            </div>

          </div>

          <div class="input-group input-group-sm mb-2" id="tercero">
            <div class="input-group-prepend" style="">
              <span class="input-group-text"><b>Segundo :</b></span>
            </div>
            <input class="form-control" list="listSegundo" name="segundo" id="segundo" placeholder="Ingrese Segundo"  onblur="revisarNoObligatorio(this)" onkeyup="revisarNoObligatorio(this)">
                  <div class="invalid-feedback">
                    El campo Segundo no debe haber espacios en blanco
                  </div>
            <datalist id="listSegundo">
              <!--Lista de Segundos-->
            </datalist>
          </div>
          <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text"><b>Sopa : </b></span>
            </div>
            <input class="form-control" list="listSopa" name="sopa" id="sopa" onblur="revisarNoObligatorio(this)" onkeyup="revisarNoObligatorio(this)" placeholder="Ingrese Sopa">
                  <div class="invalid-feedback">
                    El campo Sopa no debe haber espacios en blanco
                  </div>
            <datalist id="listSopa">
              <!--lista de sopas-->
            </datalist>
          </div>
          <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text"><b>Infusión : </b></span>
            </div>
            <input class="form-control" list="listAgua" name="infusion" id="infusion" placeholder="Ingrese Infusión" onblur="revisarNoObligatorio(this)" onkeyup="revisarNoObligatorio(this)">
                <div class="invalid-feedback">
                    El campo Desayuno no debe haber espacios en blanco
                  </div>
            <datalist id="listAgua">
              <!--Lista de Aguas-->
            </datalist>
          </div>
          <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text"><b>Fruta :</b></span>
            </div>
            <input class="form-control" list="listFruta" name="fruta" id="fruta" onblur="revisarNoObligatorio(this)" onkeyup="revisarNoObligatorio(this)" placeholder="Ingrese Fruta">
            <div class="invalid-feedback">
                    El campo Fruta no debe haber espacios en blanco
                  </div>
            <datalist id="listFruta">
              <!--Lista de fruta-->
            </datalist>
          </div>
          <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text"><b>Postre :</b></span>
            </div>
            <input class="form-control" list="listPostre" name="postre" id="postre" onblur="revisarNoObligatorio(this)" onkeyup="revisarNoObligatorio(this)" placeholder="Ingrese Postre">
            <div class="invalid-feedback">
                    El campo Postre no debe ir vacío o espacios en blanco
                  </div>
            <datalist id="listPostre">
              <!--Lista de Postre-->
            </datalist>
          </div>
          <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text"><b>Adicional :</b></span>
            </div>
            <input class="form-control" list="listAdicional" name="adicional" id="adicional" onblur="revisarNoObligatorio(this)" onkeyup="revisarNoObligatorio(this)" placeholder="Ingrese Adicional - Opcional">
            <div class="invalid-feedback">
              El campo Adicional no debe haber espacios en blanco
            </div>
            <datalist id="listAdicional">
              <!--Lista de Adicional-->
            </datalist>
          </div>
          <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text"><b>Inicio de Reserva : </b></span>
            </div>
            <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" onblur="validarFormatoFecha(this); existeFecha(this)" onkeyup="validarFormatoFecha(this); existeFecha(this)" required="">
            <input type="time" class="form-control" name="horaInicio" id="horaInicio" onblur="revisar(this)" onkeyup="revisar(this)" required="">
            <div class="invalid-feedback" id="inicioreserva">
                    El campo Inicio Reserva no debe ir vacío
                  </div>
          </div>
          <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text"><b>Fin de Reserva : </b></span>
            </div>
            <input type="date" class="form-control" name="fechaFin" id="fechaFin" onblur="validarFormatoFecha(this); existeFecha(this)" onkeyup="validarFormatoFecha(this); existeFecha(this)" required="">
            <input type="time" class="form-control" name="horaFin" id="horaFin" onblur="revisar(this)" onkeyup="revisar(this)" required="">
            <div class="invalid-feedback" id="finreserva">
                    El campo Fin Reserva no debe ir vacío
                  </div>
          </div>

          <div class="input-group input-group-sm mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text"><b>Estado :</b></span>
            </div>
            <select class="form-control" required="" id="estado" name="estado" onblur="revisar(this)" onchange="revisar(this)">
                  <option value="" disabled="true" selected="true">-- Seleccione Estado --</option>
                  <option value="1" selected="">Activado</option>
                  <option value="0">Desactivado</option>
           </select>
          </div>

          <div id="verificacion"></div>
          </div>
          <div class="row" id="botones" data-pid="0">
            <div class="col-md-3 col-lg-2 mb-1 p-1">
              <button type="button" class="btn btn-dark btn-block" id="cerrar" name="cerrar" data-dismiss="modal" onclick="cleanModal();">Cerrar</button>
            </div>
            <div class="col-md-3 mb-1 p-1">
              <button type="submit" class="btn btn-success btn-block" id="btnGuardarMenu" name="btnGuardarMenu"><i class="far fa-save"></i> Guardar</button>
            </div>
            <div class="col-md-3 mb-1 p-1">
              <button type="button" class="btn btn-danger btn-block" id="btnEliminarMenu" name="btnEliminarMenu"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php }?>