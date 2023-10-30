<div id="modalasignar" class="modal fade bd-example-modal" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hiddin="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <form methon="post" id="ticket_form">
                <div class="modal-body">
                    <input type="hidden" id="tick_id" name="tick_id">
                    
                    <div class="form-group">
                        <label class="form-label" form="usu_asig">Soporte</label>
                        <select class="select2" id="usu_asig" name="usu_asig" data-placeholder="Seleccionar" required>
                            
                            
                        </select>
                    </div>
                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-rounded bt-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Asignar</button>
                    </div>
                </div>
            </form>
        </div>    
    </div>
</div>
