<div class="modal fade" style="min-width: 318px;" id="modalReserva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="menuTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade active show" id="almuerzo" role="tabpanel" aria-labelledby="pop1-tab">
            
            <div class="card">
              <h3 class="card-header text-center card-primary" id="dateMenu"><span class="fas fa-utensils pull-right"></span></h3>
              <div class="card-block">
                    <div class="row columnapadre justify-content-center align-items-center">
                        <div class="col-4 colderecha text-right">
                            <h4 class="h4-1" style="margin-bottom: 4px; margin-top: 4px;">Segundo : </h4>
                        </div>
                        <div class="col-8 colizquierda">
                            <h5 class="h5-1" style="margin-bottom: 4px; margin-top: 4px;" id="detailSecond"></h5>
                        </div>
                    </div>
                    <div class="row columnapadre justify-content-center align-items-center">
                        <div class="col-4 colderecha text-right"> 
                            <h4 class="h4-1" style="margin-bottom: 4px; margin-top: 4px;">Sopa : </h4>
                        </div>
                        <div class="col-8 colizquierda">
                            <h5 class="h5-1" style="margin-bottom: 4px; margin-top: 4px;" id="detailSoup"></h5>
                        </div>
                    </div>
                     <div class="row columnapadre justify-content-center align-items-center">
                        <div class="col-4 colderecha text-right">
                            <h4 class="h4-1" style="margin-bottom: 4px; margin-top: 4px;" id="desayuno">Infusión : </h4>
                        </div>
                        <div class="col-8 colizquierda">
                            <h5 class="h5-1" style="margin-bottom: 4px; margin-top: 4px;" id="detailDrink"></h5>
                        </div>
                    </div>
                    <div class="row columnapadre justify-content-center align-items-center">
                        <div class="col-4 colderecha text-right">
                            <h4 class="h4-1" style="margin-bottom: 4px; margin-top: 4px;">Fruta : </h4>
                        </div>
                        <div class="col-8 colizquierda">
                            <h5 class="h5-1" style="margin-bottom: 4px; margin-top: 4px;" id="detailFruit"></h5>
                        </div>
                    </div>
                    <div class="row columnapadre justify-content-center align-items-center">
                        <div class="col-4 colderecha text-right">
                          <h4 class="h4-1" style="margin-bottom: 4px; margin-top: 4px;">Postre : </h4>
                        </div>
                        <div class="col-8 colizquierda">
                          <h5 class="h5-1" style="margin-bottom: 4px; margin-top: 4px;" id="detailDessert"></h5>
                        </div>
                    </div>
                    <div class="row columnapadre justify-content-center align-items-center">
                        <div class="col-4 colderecha text-right">
                          <h4 class="h4-1" style="margin-bottom: 4px; margin-top: 4px;">Adicional : </h4>
                        </div>
                        <div class="col-8 colizquierda">
                          <h5 class="h5-1" style="margin-bottom: 4px; margin-top: 4px;" id="detailAditional"></h5>
                        </div>
                    </div>
                    <div class="row columnapadreReservaInicio justify-content-center align-items-center">
                        <div class="col-4 colderechaReservaInicio text-right">
                          <h4 class="h4-1" style="margin-bottom: 4px; margin-top: 4px;">Inicio de Reserva : </h4>
                        </div>
                        <div class="col-8 colizquierda">
                          <h5 class="h5-1" style="margin-bottom: 4px; margin-top: 4px;" id="inicioReserva"></h5>
                        </div>
                    </div>
                    <div class="row columnapadreReservaFin justify-content-center align-items-center">
                        <div class="col-4 colderechaReservaFin text-right">
                          <h4 class="h4-1" style="margin-bottom: 4px; margin-top: 4px;">Fin de Reserva : </h4>
                        </div>
                        <div class="col-8 colizquierda">
                          <h5 class="h5-1" style="margin-bottom: 4px; margin-top: 4px;" id="finReserva"></h5>
                        </div>
                    </div>
              </div>
            </div>
            <div style="height: 1px; background: black;" ></div> 
            
            <div class="card">
              <h3 class="card-header text-center card-primary">Seleccione un horario para ir a comer <span class="fas fa-utensils pull-right"></span></h3>
              <div class="card">
                <div class="row" id="listHorary" style="padding: 5px;">
                  <!--lista de horarios-->
                </div> 
                <div id="mostrar_loadingHR" style="display: none;">
                  <?php include "../templates/layouts/loading.html"; ?>
                </div>
                <!--<div>Tiene una reserva: </div>-->
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

