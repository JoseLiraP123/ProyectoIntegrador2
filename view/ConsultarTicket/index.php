<?php
    require_once '../../config/conexion.php';
    if(isset($_SESSION["usu_id"])){ 
?>

<!DOCTYPE html>
<html>
    <?php require_once("../MainHeader/head.php"); ?>
    
<title>Consulta tu ticket de Soporte Técnico</title>
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
                                    <h3>Consultar Ticket</h3>
                                    <ol class="breadcrumb breadcrumb-simple">
                                            <li><a href="#">Home</a></li>
                                            <li class="active">Consultar Ticket</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </header>
                    
                    <div class="box-typical box-typical-padding">
                        <table id="ticket_data" class="table table-bordered table-stripped table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Nro. Ticket</th>
                                    <th style="width: 15%;">Categoría</th>
                                    <th class="d-none d-sm-table-cell" style="width: 25%">Título</th>
                                    <th class="text-center" style="width: 15%;"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<?php require_once("../MainJS/js.php"); ?>
        <script src="consultarticket.js"></script>
        
</body>
</html>
<?php  
    } else {
        $conexion = new Conectar();
        $ruta = $conexion->ruta();        
        header("Location: ".$ruta."index.php");
    }
?>