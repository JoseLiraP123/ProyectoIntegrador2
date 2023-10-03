<?php
    require_once '../../config/conexion.php';
    if(isset($_SESSION["usu_id"])){ 
?>

<!DOCTYPE html>
<html>
    <?php require_once("../MainHeader/head.php"); ?>
    
<title>Detalle de ticket enviado</title>
</head>
<body class="with-side-menu">

	<?php require_once("../MainHeader/header.php"); ?>

	<div class="mobile-menu-left-overlay"></div>
        
	<?php require_once("../MainNav/nav.php"); ?>

	<div class="page-content">
		<div class="container-fluid">
                    <header class="section-header">
                        <div class="tbl">
                            <div class="tbl-row">
                                <div class="tbl-cell">
                                    <h3 id="lblnomidticket"></h3>
                                    <div id="lblestado"></div>
                                    <span class="label label-pill label-primary" id="lblnomusuario">Nombre del usuario</span>
                                    <span class="label label-pill label-default" id="lblfechcrea">00/00/00</span>
                                    <ol class="breadcrumb breadcrumb-simple">
                                            <li><a href="#">Home</a></li>
                                            <li class="active">Consultar Ticket</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </header>
                    
                    <div class="box-typical box-typical-padding">
                        <div class="row">
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="cat_nom">Categoría: </label>
                                    <input type="text" class="form-control" id="cat_nom" name="cat_nom" readonly>
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="tick_titulo">Título: </label>
                                    <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" readonly>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="tickd_descripusu">Descripción: </label>
                                    <div class="summernote-theme-1">
                                            <textarea class="summernote" name="tickd_descripusu" id="tickd_descripusu"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <section class="activity-line" id="lbldetalle">

                    </section><!--.activity-line-->
                    
                     <div class="box-typical box-typical-padding">
				                             
                                <h5 class="m-t-lg with-border">Ingrese su duda o consulta</h5>

				<div class="row">         		
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tickd_descrip">Descrición</label>
							<div class="summernote-theme-1">
                                                                <textarea class="summernote" name="tickd_descrip" id="tickd_descrip"></textarea>
                                                        </div>
						</fieldset>
					</div>
					<div class="col-lg-12">
                                            <button type="button" id="btnenviar" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
                                            <button type="button" id="btncerrarticket" class="btn btn-rounded btn-inline btn-warning">Cerrar Ticket</button>
					</div>
				</div><!--.row-->
                        </div>
                    
                    
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<?php require_once("../MainJS/js.php"); ?>
        <script src="detalleticket.js"></script>
        
</body>
</html>
<?php  
    } else {
        $conexion = new Conectar();
        $ruta = $conexion->ruta();        
        header("Location: ".$ruta."index.php");
    }
?>