<?php
/* TODO:Clave de Cifrado (asegúrate de usar la misma clave que se utilizó para cifrar) */
$key = "mi_key_secret";
/* TODO:Metodo de Cifrado (asegúrate de usar el mismo método que se utilizó para cifrar) */
$cipher = "aes-256-cbc";

/* El texto cifrado que deseas descifrar */
$textoCifrado = "Os+c/dWO4XYTtoHMlFNRJKKMn8QSLpOi6Y1ll8A9rD8=";

/* Obtener el IV del texto cifrado */
$iv_dec = substr(base64_decode($textoCifrado), 0, openssl_cipher_iv_length($cipher));
/* Obtener el texto cifrado sin el IV */
$cifradoSinIV = substr(base64_decode($textoCifrado), openssl_cipher_iv_length($cipher));
/* TODO: Descifrado */
$decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
echo "Texto Descifrado: " . $decifrado;
?>