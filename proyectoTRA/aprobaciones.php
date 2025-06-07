<?php
// aprobaciones.php

require_once 'middlewares/AuthMiddleware.php';

require_once 'config/Database.php';
require_once 'models/Formulario.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Aprobaciones</title>
    <link rel="stylesheet" href="./css/aprobaciones.css">
    <link rel="stylesheet" href="./css/general.css">
    <script>
        // Función que se ejecuta antes de enviar el formulario
    function validarEnvio() {
      const confirmar = confirm("¿Seguro de aprobar este formulario");
      if (confirmar) {
        alert("Formulario aprobado con exito.");
        return true; // permite enviar el formulario
      } else {
        return false; // cancela el envío
      }
    }
    </script>
</head>
<body>
<?php  require_once 'components/NavegacionSuperior.php'; ?>
    <div class="panel-deslizable">
    <h2>Aprobaciones</h2>
<?php  

    // El parámetro no está presente - por ende mostrar la lista de formularios para aprobar
    // conexion Database y descargar los formularios en el sistemas
$db = new Database();
    $formulario = new Formulario();
    // se envia el formulario a la BBDD

    $formulario->descargarFormularios($db);


?>
    </div>
    <?php  require_once 'components/Footer.php'; ?>
</body>
</html>