<?php
    require_once '../../config/conexion.php';
    if(isset($_SESSION["usu_id"])){ 
?>

<!DOCTYPE html>
<html>
    <?php require_once("../MainHeader/head.php"); ?>
    
<title>Crea un nuevo ticket de Soporte Técnico</title>
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
							<h3>Nuevo Ticket</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Nuevo Ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
                        <div class="box-typical box-typical-padding">
				<p>
                                    Estimado usuario, desde esta opción usted podrá generar nuevos tickets de consulta al servicio técnico.
                                </p>                                
                                <h5 class="m-t-lg with-border">Ingresar Información</h5>

				<div class="row">
                                    <form method="post" id="ticket_form">
                                        
                                        <input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION['usu_id']; ?>">
                                        
                                        <div class="col-lg-8">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tick_titulo">Título</label>
                                                        <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" placeholder="Ingrese Título">
						</fieldset>
					</div>
					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label semibold" for="exampleInput">Categoría</label>
                                                        <select class="form-control" id="cat_id" name="cat_id">
							</select>
						</fieldset>
					</div>
					
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tick_descrip">Descrición</label>
							<div class="summernote-theme-1">
                                                                <textarea class="summernote" name="tick_descrip" id="tick_descrip"></textarea>
                                                        </div>
						</fieldset>
					</div>
					<div class="col-lg-12">
                                            <button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Enviar Ticket</button>
					</div>
                                    </form>
				</div><!--.row-->
                        </div>
                    
		</div><!--.container-fluid-->
	</div><!--.page-content-->
        
	<?php require_once("../MainJS/js.php"); ?>
        <script src="nuevoticket.js"></script>
           
        
</body>
</html>
<?php  
    } else {
        $conexion = new Conectar();
        $ruta = $conexion->ruta();        
        header("Location: ".$ruta."index.php");
    }
?>