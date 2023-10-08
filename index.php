<?php
    require_once("config/conexion.php");
    
    if(isset($_POST["enviar"])and isset($_POST["enviar"])=="si"){
        require_once("models/Usuario.php");
        $usuario = new Usuario();
        $usuario->login();
    }

?>


<!DOCTYPE html>
<html>
<head lang="es">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Proyecto de Integrador 2</title>

	<link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="img/favicon.png" rel="icon" type="image/png">
	<link href="img/favicon.ico" rel="shortcut icon">

<link rel="stylesheet" href="public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/main.css">
</head>
<body>

    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                
                <form class="sign-box" method="post" id="login_form">
                    
                    <input type="hidden" id="rol_id" name="rol_id" value="1">
                    
                    <div class="sign-avatar">
                        <img src="public/1.jpg" alt="" id="imgtipo">
                    </div>
                    <header class="sign-title" id="lbltitulo">Acceso para Usuarios</header>
                    <?php
                        
                        if(isset($_GET["m"])){
                            switch ($_GET["m"]){
                                case "1";
                                ?>
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="d-flex align-items-center justity-content-start">
                                            <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0" ></i>
                                            <span>El usuario y/o contraseña son incorrectos.</span>
                                        </div>
                                    </div>
                                <?php
                                break;
                            
                                case "2";
                                ?>
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="d-flex align-items-center justity-content-start">
                                            <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0" ></i>
                                            <span>Los campos están vacios.</span>
                                        </div>
                                    </div>
                                <?php
                                break;
                            }
                        }
                        
                    ?>
                    
                    <div class="form-group">
                        <input type="text" id="usu_correo" name="usu_correo" class="form-control" placeholder="Ingresa tu E-Mail"/>
                    </div>
                    <div class="form-group">
                        <input type="password" id="usu_pass" name="usu_pass" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <div class="checkbox float-left">
                            <input type="checkbox" id="signed-in"/>
                            <label for="signed-in">Mantenerme conectado</label>
                        </div>
                        <div class="float-right reset">
                            <a href="reset-password.html">Recuperar contraseña</a>
                        </div>
                        <div class="float-left reset">
                            <a href="#" id="btnsoporte">Acceso Soporte</a>
                        </div>
                    </div>
                    <input type="hidden" name="enviar" class="form-control" value="si">
                    <button type="submit" class="btn btn-rounded">Iniciar Sesión</button>
                    <p class="sign-note">¿Eres nuevo? <a href="sign-up.html">Registrate</a></p>
                    <!--<button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </form>
            </div>
        </div>
    </div><!--.page-center-->


<script src="public/js/lib/jquery/jquery.min.js"></script>
<script src="public/js/lib/tether/tether.min.js"></script>
<script src="public/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="public/js/plugins.js"></script>
    <script type="text/javascript" src="public/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>

    <script src="index.js"></script>
    
    <script src="js/app.js"></script>



</body>
</html>