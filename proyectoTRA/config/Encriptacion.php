<?php
   

function encriptar($texto, $clave = 'A00098768') {
    $metodo = 'AES-256-CBC';
    $iv = substr(hash('sha256', 'B097855GG'), 0, 16);
    $clave = hash('sha256', $clave);
    return base64_encode(openssl_encrypt($texto, $metodo, $clave, 0, $iv));
}

function desencriptar($textoEncriptado, $clave = 'A00098768') {
    $metodo = 'AES-256-CBC';
    $iv = substr(hash('sha256', 'B097855GG'), 0, 16);
    $clave = hash('sha256', $clave);
    return openssl_decrypt(base64_decode($textoEncriptado), $metodo, $clave, 0, $iv);
}


?>
