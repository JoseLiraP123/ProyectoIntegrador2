<?php
    /*TODO: llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Email.php");
    $email = new Email();

    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    /*TODO: opciones del controlador */
    switch ($_GET["op"]) {
        /*TODO: enviar ticket abierto segun el ID */
        case "ticket_abierto":
            $email->ticket_abierto($_POST["tick_id"]);
            break;

        /*TODO: enviar ticket Cerrado segun el ID */
        case "ticket_cerrado":
            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
            $email->ticket_cerrado($decifrado);
            break;

        /*TODO: enviar ticket asignado segun el ID */
        case "ticket_asignado":
            $email->ticket_asignado($_POST["tick_id"]);
            break;

        case "recuperar_contra":
            $email->recuperar_contrasena($_POST["usu_correo"]);
            break;
    }
?>