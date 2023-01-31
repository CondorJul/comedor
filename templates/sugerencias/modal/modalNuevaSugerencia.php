
<!--Modal: modalPush-->
<div class="modal fade " id="modalNuevaSugerencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" >
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center bg-primary text-white">
        <!--<p class="heading">UNDAC Comedor</p>-->
            <h5 class="heading card-title">Envíanos tu Sugerencia o Reclamo</h5>
      </div>

    <form id="formSugerencias">

      <div class="modal-body">

        <p>Envía tu idea, sugerencia, propuesta, comentario, quejas o reclamos escribiendo en el siguiente cuadro de texto, y entre todos mejoraremos el servicio.</p>

          <div class="row">
            <div class="col-md-12 ">
                
              
                 <div class="form-group">
                    <div class="col-sm-12">
                      
                  <span class="d-flex justify-content-left"><b>Sugerencia: </b></span>

                  <textarea class="form-control" rows="5" name="suggestions" id="suggestions" onblur="revisar(this)" onkeyup="revisar(this)" required="" ></textarea>
                          <div class="invalid-feedback">
                                <strong>La descripcion</strong> es invalida
                          </div>
                    </div>
                  </div>

              
         
         

            </div>
          </div>


      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
       <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="guardar_datos">Enviar Sugerencia</button>
      </div>
    </form>  
    </div>
    <!--/.Content-->
  </div>
</div>

<!--Modal: modalPush-->