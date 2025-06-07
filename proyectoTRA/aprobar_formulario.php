<?php
// aprobar_formulario.php

require_once 'models/Formulario.php';
require_once 'config/Database.php';
require_once "./config/Encriptacion.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // si si hay GET obtener todos los datos   
    // Crear OBJETO formulario
    $db = new Database();
    $formulario = new Formulario();
    $id = desencriptar($_GET["id"]);

    // se envia el formulario a la BBDD para actualizar estado
    if($formulario->aprobar($db, $id)){
        header("Location: aprobaciones.php");
    exit;
} else{
        echo 'Error - no se puede actualizar el estado con id ' . $id;
    } 

} else {
    // si no hay post volver al dashboard
    header("Location: dashboard.php");
    exit;
}
?>
