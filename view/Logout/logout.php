<?php
    require_once("../../config/conexion.php");
    $conexion = new Conectar();
    $ruta = $conexion->ruta();
    session_destroy();
    header("Location:".$ruta."index.php");
    exit();    
?>