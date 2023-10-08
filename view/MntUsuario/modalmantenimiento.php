<div id="modalMantenimiento" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="usu_nom">Nombre</label>
                    <input type="text" class="form-control" id="usu_nom" placeholder="Ingrese nombre" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="usu_ape">Apellido</label>
                    <input type="text" class="form-control" id="usu_ape" placeholder="Ingrese apellido" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="usu_correo">Correo electronico</label>
                    <input type="email" class="form-control" id="usu_correo" placeholder="Ingrese correo electronico" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="usu_pass">Contraseña</label>
                    <input type="password" class="form-control" id="usu_pass" placeholder="***********" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="usu_correo">Rol</label>
                    <select class="select2">
								<option>Usuario</option>
								<option>Soporte</option>
					</select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-rounded btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>