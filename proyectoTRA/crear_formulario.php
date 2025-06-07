<?php
// crear_formulario.php
require_once 'middlewares/AuthMiddleware.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Formulario</title>
    <script>
        // Función que se ejecuta antes de enviar el formulario
        
    function validarEnvio() {
      const confirmar = confirm("¿Seguro de enviar este formulario?");
      if (confirmar) {
        alert("Formulario enviado con éxito");
        return true; // permite enviar el formulario
      } else {
        return false; // cancela el envío
      }
    }
    </script>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/formulario.css">
</head>
<body>
<?php      //Mostrar Barra Superior
    require_once 'components/NavegacionSuperior.php';
?>

    <!-- Contenido principal -->
    <main>
      
    <form action="procesar_formulario.php" method="post" onsubmit="return validarEnvio()">
        <h2>Crear formulario</h2>


            <label for="huespedes">Cantidad de huespedes</label>
      <select name="huespedes" id="huespedes" >
      <option value="1">1</option>
      <!-- proximamente se agregara la opcion de mas huespedes
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option> -->
      </select>


      <p> <label for="nombre">Nombre(s) del titular</label>
            <input type="text" id="nombre" name="nombre" required></p> 

            <p>  <label for="apellido">Apellido(s) del titular</label>
            <input type="text" id="apellido" name="apellido" required> </p>

            <p> <label for="valor">Valor habitación</label>
            <input type="number" id="valor" name="valor" required> </p>

            <p> <label for="fecha_entrada">Fecha de entrada</label>
            <input type="date" id="fecha_entrada" name="fecha_entrada"required> </p>

            <p> <label for="fecha_salida">Fecha de Salida</label>
            <input type="date" id="fecha_entrada" name="fecha_salida" required> </p>

            <label for="acomodacion">Tipo de acomodación</label>
            <select name="acomodacion" id="acomodacion">
                
      <option value="Alojamiento entero">Alojamiento entero</option>
      <option value="Habitación">Habitación</option>
      <option value="Habitación compartida">Habitación compartida</option>
      </select>
            <button type="submit">Enviar Formulario</button>
        </form>
    </main>
    <?php  require 'components/Footer.php'; ?>
</body>
</html>
