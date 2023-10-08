<header class="site-header">
	    <div class="container-fluid">
	
	        <a href="#" class="site-logo">
	            <img class="hidden-md-down" src="../../public/img/logo-2.png" alt="">
	            <img class="hidden-lg-up" src="../../public/img/logo-2-mob.png" alt="">
	        </a>
	
	        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
	            <span>Botón de menú lateral</span>
	        </button>
	
	        <button class="hamburger hamburger--htla">
	            <span>Botón de menú lateral para móbiles</span>
	        </button>
                
                
	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">                            
	                    <div class="dropdown user-menu">
	                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                            <img src="../../public/<?php echo $_SESSION['rol_id']; ?>.jpg" alt="">
	                        </button>
	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-user"></span>Perfil</a>
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-cog"></span>Configuración</a>
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span>Ayuda</a>
	                            <div class="dropdown-divider"></div>
	                            <a class="dropdown-item" href="../Logout/logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Cerrar Sesión</a>
	                        </div>
	                    </div>
	
	                    <button type="button" class="burger-right">
	                        <i class="font-icon-menu-addl"></i>
	                    </button>
	                </div><!--.site-header-shown-->
	
	                <div class="mobile-menu-right-overlay"></div>
                        
                        <input type="hidden" id="user_idx" value="<?php echo $_SESSION['usu_id']; ?>"> <!--variable de usuario global-->
                        <input type="hidden" id="rol_idx" value="<?php echo $_SESSION['rol_id']; ?>"> <!--variable de rol del usuario-->
                        
                        <div class="dropdown dropdown-typical">
                            <a href="#" class="dropdown-toggle no-arr">
                                <span class="font-icon font-icon-user"></span>
                                <span class="lblcontactonomx"><?php echo $_SESSION["usu_nom"]." ".$_SESSION["usu_ape"]; ?></span>
                            </a>
                        </div>
                        
                        
<!--	                <div class="site-header-collapsed">
	                    <div class="site-header-collapsed-in">
	                        <div class="dropdown dropdown-typical">
	                            <div class="dropdown-menu" aria-labelledby="dd-header-sales">
	                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-home"></span>Quant and Verbal</a>
	                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-cart"></span>Real Gmat Test</a>
	                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-speed"></span>Prep Official App</a>
	                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-users"></span>CATprer Test</a>
	                                <a class="dropdown-item" href="#"><span class="font-icon font-icon-comments"></span>Third Party Test</a>
	                            </div>
	                        </div>
	                    </div>.site-header-collapsed-in
	                </div>.site-header-collapsed-->
	            </div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->