<?php
// crear_formulario.php

require_once 'middlewares/AuthMiddleware.php';
require_once 'models/Formulario.php';
require_once 'config/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // si si hay post obtener todos los 
    $fechaEnvio = date('Y-m-d');
    $nombre     = htmlspecialchars(trim($_POST['nombre']));
    $apellidos     = htmlspecialchars(trim($_POST['apellido']));
    $fecha_entrada = htmlspecialchars(trim($_POST['fecha_entrada']));
    $fecha_salida = htmlspecialchars(trim($_POST['fecha_salida']));
    $valor       = (float) $_POST['valor'];
    $acomodacion = htmlspecialchars(trim($_POST['acomodacion']));
    $huespedes = htmlspecialchars(trim($_POST['huespedes']));

    // Crear OBJETO formulario instancia para subirlo a la base de datos
    
    $db = new Database();
    $formulario = new Formulario($fechaEnvio, $nombre, $apellidos, 
    $fecha_entrada, $fecha_salida, $acomodacion, $valor, $huespedes);

    // se envia el formulario a la BBDD
    $formulario->enviar($db);
   
    //ir a aprobaciones
    header("Location: aprobaciones.php");


} else {
    // si no hay post volver al dashboard
    header("Location: dashboard.php");
    exit;
}
?>
