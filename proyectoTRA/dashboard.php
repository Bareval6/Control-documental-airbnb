<?php
// dashboard.php

require_once 'middlewares/AuthMiddleware.php';

$id = $_SESSION['usuario_id'];
$nombre = htmlspecialchars($_SESSION['usuario_nombre']);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>
<?php require_once 'components/NavegacionSuperior.php'; ?>

    <!-- Contenido principal -->
    <main>
    <div class="pantalla">
    <div class="contenido">
        <h2>Bienvenido, <?= $nombre ?></h2>
        <p class="pregunta">¿Qué deseas hacer hoy?</p>
        <div class="botones">
        <form action="crear_formulario.php" method="get" style="display:inline;">
            <button class="boton negro" type="submit">Crear Formulario</button>
        </form>

        <form action="aprobaciones.php" method="get" style="display:inline;">
            <button class="boton blanco" type="submit">Ver Formularios</button>
        </form>

        </div>
</div>
        </div>
        </main>
    <?php  require 'components/Footer.php'; ?>
</body>
</html>