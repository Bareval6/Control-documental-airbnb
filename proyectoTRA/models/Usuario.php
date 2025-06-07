<?php
// models/Usuario.php

require_once __DIR__ . '/../config/Database.php';

class Usuario {
    private $conn;
    private $table = 'admins';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // valida que exista el usuario en la base de dat0s
    public function autenticar($usuario, $contrasena) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email2 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email2', $usuario);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            //Agregar hash y password verify

            if (password_verify($contrasena, $fila['clave'])) {
                return $fila;
            }
        }

        return false;
    }
}
?>
