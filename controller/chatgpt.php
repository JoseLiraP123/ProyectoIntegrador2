<?php

    require_once("../config/conexion.php");
    require_once("../models/Chatgpt.php");
    $chatgpt = new Chatgpt();
    
    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    switch ($_GET["op"]) {

        case "respuestaia":
            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
            
            $datos=$chatgpt->get_respuestaia($decifrado);
            echo $datos;
            break;
    }
?>