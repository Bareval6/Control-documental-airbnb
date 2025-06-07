<?php
// login.php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}
require_once 'controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['username'] ?? '';
    $contrasena = $_POST['password'] ?? '';

    $auth = new AuthController();

    $auth->login($usuario, $contrasena);

    if ($auth->login($usuario, $contrasena)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Usuario o contraseña incorrectos.";
    }
    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>

    <form method="POST" action="">
        <h2>Iniciar Sesion</h2>

        <?php if (isset($message) && $message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <input type="text" id="username" name="username" placeholder="Usuario" required>
        <input type="password" id="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar</button>
    </form>
    <?php  require 'components/Footer.php'; ?>
</body>
</html>
