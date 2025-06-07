<?php
// procesar_formulariouser.php

require_once 'models/Formulario.php';
require_once 'config/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // si si hay post obtener todos los datos

    $idReserva  = substr(htmlspecialchars(trim($_POST['reserva'])), -2);
    $nombres  = htmlspecialchars(trim($_POST['nombre1']));
    $apellidos  = htmlspecialchars(trim($_POST['apellido1']));
    $tipoIdentificacion  = htmlspecialchars(trim($_POST['tipo_identificacion1']));
    $NroIdentificacion  = htmlspecialchars(trim($_POST['identificacion1']));
    $CiudadResidencia  = htmlspecialchars(trim($_POST['residencia']));
    $CiudadProcedencia  = htmlspecialchars(trim($_POST['procedencia']));
    $motivoViaje  = htmlspecialchars(trim($_POST['motivo']));

    //huespedes adicionales 2-6

    // Crear OBJETO formulario instancia para subirlo a la base de datos
    
    $db = new Database();
    $formulario = new Formulario();

    // se envia el formulario a la BBDD para actualizar datos del titular
    echo '<!DOCTYPE html>
<html>
<head>
    <title>Aprobaciones</title>
    <link rel="stylesheet" href="./css/aprobaciones.css">
    <link rel="stylesheet" href="./css/general.css"></head><body><p><<h2 style="color:black">';
    $formulario->updateFormularioUsuario($db, $idReserva, 
    $nombres, $apellidos, $tipoIdentificacion, $NroIdentificacion,
    $CiudadResidencia, $CiudadProcedencia,
    $motivoViaje
);

echo '</h2></p><p><a href="login.php"><h2> Volver</h2> </a></p></body>
</html>';

    
} else {
    // si no hay post volver al dashboard
    header("Location: dashboard.php");
    exit;
}
?>
