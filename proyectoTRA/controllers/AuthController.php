<?php
// controllers/AuthController.php

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    public function login($usuario, $contrasena) {
        $usuarioModel = new Usuario();
        $datosUsuario = $usuarioModel->autenticar($usuario, $contrasena);
        
        if ($datosUsuario) {
            session_start();
            $_SESSION['usuario_id'] = $datosUsuario['id_admin'];
            $_SESSION['usuario_nombre'] = $datosUsuario['nombre'];
            return true;
        }

        return false;
    }
}
?>
