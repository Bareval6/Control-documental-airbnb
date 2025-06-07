<?php
// formulariousers.php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro TRA aibnb</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/formulario.css">
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
    </head>
<?php if (isset($_GET["formularioID"]))
{
    // El parámetro 'formularioID' está presente en la URL
    require_once "config/Encriptacion.php";
    require_once "config/Database.php";
    $idURL = desencriptar($_GET["formularioID"]);
    if (!is_numeric($idURL)) {
        header('Location: login.php');}


        // descargar datos ya existentes del formulario de la BDD
        $db = new DataBase();
        $conn = $db->connect();

        $query = "SELECT * FROM formularios WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $idURL);
        if ($stmt->execute()) {
            
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $numeroHuespedes = $fila['huespedes'];
?>
<body>
    <main>

        <form action="procesar_formulariouser.php" method="post" onsubmit="return validarEnvio()">
        <h1>Registro TRA Airbnb</h1>

            <label for="reserva">Numero de Reserva</label>
            <input type="text" id="reserva" name="reserva" value="R00<?=htmlspecialchars($idURL) ?>" readonly="readonly">
            <?php 
            
            for ($i = 1; $i <= $numeroHuespedes; $i++) {
            echo '<h2>Información huesped Nº '. $i . ($i == 1 ? ' (Titular)' : '' ). '</h2>';

            echo '<p>  <label for="nombre'.$i. '">Nombre(s)</label>
        <input value="'.($i == 1 ? $fila['nombres'] : '') .'" type="text" id="nombre'.$i. '" name="nombre'.$i.'" required>  </p>';

        
        echo '<p>  <label for="apellido'.$i. '">Apellido(s)</label>
        <input value="'. ($i == 1 ? $fila['apellidos'] : ''). '"  type="text" id="apellido'.$i. '" name="apellido'.$i.'" required>  </p>';

echo '<p>  <label for="tipo_identificacion'.$i. '">Tipo de Identificación</label>
            <select name="tipo_identificacion'.$i.'" id="tipo_identificacion'.$i.'">
                <option value="CC">Cedula de Ciudadania</option>
                <option value="TI">Tarjeta de Identidad</option>
                <option value="RC">Registro Civil</option>
                <option value="P">Pasaporte</option>
                <option value="CE">Cedula de extranjeria</option>
                <option value="PEP">Permiso Especial de Permanencia</option>
            </select>  </p>';

        echo '<p> <label for="identificacion'.$i.'">Tipo de Identificación</label>
            <input type="text" id="identificacion'.$i.'" name="identificacion'.$i.'" required>  </p>';
        }?>
            

            


            

            <h2>Información general</h2>
            <p> <label for="residencia">Ciudad de residencia</label>
            <input type="text" id="residencia" name="residencia" required>  </p>



            <p> <label for="procedencia">Ciudad de procedencia</label>
            <input type="text" id="procedencia" name="procedencia" required>  </p>


            <p> <label for="motivo">Motivo del viaje</label>
            <select name="motivo" id="motivo">
                <option value="Turismo">Turismo</option>
                <option value="Ocio">Ocio</option>
                <option value="Trabajo o Negocios">Trabajo o Negocios</option>
            </select>  </p>


                <p>    <label for="fecha_entrada">Fecha de entrada</label>
                <input value="<?= $fila['fecha_entrada'] ?>" type="date" id="fecha_entrada" name="fecha_entrada" readonly="readonly">  </p>


                <p>   <label for="fecha_salida">Fecha de Salida</label>
                <input value="<?= $fila['fecha_salida'] ?>" type="date" id="fecha_entrada" name="fecha_salida" readonly="readonly">  </p>


                <p>Recuerda que tu tipo de acomodacion es <strong><?= $fila['tipo_acomodacion'] ?></strong>, el costo total de tu reserva es <strong>COP <?= number_format($fila['valor']) ?></strong>. El pago es gestionado a través de Airbnb.

                </p>

                <button type="submit">Enviar Formulario</button>
        </form>
    </main>
</body>
    <?php
    } else {
        echo "❌ Error al obtener datos de la reserva";
    }
}
else
{
    header('Location: login.php');
} ?>
</html>
