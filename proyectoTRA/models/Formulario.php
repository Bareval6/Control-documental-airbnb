<?php
class Formulario
{
    private $fechaEnvio;
    private $nombre;
    private $apellidos;
    private $fecha_entrada;
    private $fecha_salida;
    private $tipo_acomodacion;
    private $valor;
    private $estado;
    private $huespedes;

    public function __construct(
        $fechaEnvio = null,
        $nombre = null,
        $apellidos = null,
        $fecha_entrada = null,
        $fecha_salida = null,
        $tipo_acomodacion = null,
        $valor = null,
        $huespedes = null
    ) {
        $this->fechaEnvio = $fechaEnvio;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fecha_entrada = $fecha_entrada;
        $this->fecha_salida = $fecha_salida;
        $this->tipo_acomodacion = $tipo_acomodacion;
        $this->valor = $valor;
        $this->huespedes = $huespedes;
        $this->estado = "Pendiente por diligenciamiento de usuario";
    }

    // enviar formulario siendo ADMIN y subirlo a la BDD

    public function enviar($db)
    {
        /* Crear conexión a base de datos */

        $conn = $db->connect();

        $query = "INSERT INTO formularios (id, estado, fecha_envio, id_admin, id_alojamiento, huespedes, 
     tipo_identificacion, numero_identificacion, nombres, apellidos, 
     ciudad_residencia, ciudad_procedencia, motivo, fecha_entrada, fecha_salida, 
     tipo_acomodacion, valor) VALUES (NULL, :estado, :fecha_envio, :id_admin, NULL, :huespedes, 
     NULL, NULL, :nombres, :apellidos, 
     NULL, NULL, NULL, :fecha_entrada, :fecha_salida, :tipo_acomodacion, :valor)";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":fecha_envio", $this->fechaEnvio);
        $stmt->bindParam(":id_admin", $_SESSION["usuario_id"]);
        $stmt->bindParam(":huespedes", $this->huespedes);

        $stmt->bindParam(":nombres", ucwords(strtolower($this->nombre)));
        $stmt->bindParam(":apellidos", ucwords(strtolower($this->apellidos)));

        $stmt->bindParam(":fecha_entrada", $this->fecha_entrada);

        $stmt->bindParam(":fecha_salida", $this->fecha_salida);

        $stmt->bindParam(":tipo_acomodacion", $this->tipo_acomodacion);
        $stmt->bindParam(":valor", $this->valor);

        if ($stmt->execute()) {
            echo "✅ Reserva registrada exitosamente.";
        } else {
            echo "❌ Error al registrar la reserva.";
        }
    }

    // descargar Formulario en forma de lista para panel de aprobaciones
    public function descargarFormularios($db)
    {
        /* Crear conexión a base de datos */
        $conn = $db->connect();
        $query = "SELECT * FROM formularios ORDER BY id DESC";

        $stmt = $conn->prepare($query);

        if ($stmt->execute()) {
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultados as $formulario) {
                $estado = strtolower($formulario["estado"]); // ejemplo: 'pendiente', 'aprobado', 'cancelado'

                // Definir el color según estado
                switch ($estado) {
                    case "aprobado":
                        $color = "verde";
                        break;
                    case "pendiente por aprobar":
                        $color = "amarillo";
                        break;
                    case "pendiente por diligenciamiento de usuario":
                        $color = "azul";
                        break;
                    default:
                        $color = "gris";
                        break;
                }

                require_once "./config/Encriptacion.php";
                $idURL = encriptar($formulario["id"]);

                echo "<div class='tarjeta $color'>
            <p><strong>Código: </strong> R00{$formulario["id"]}  Fecha: {$formulario["fecha_envio"]} - 
               <strong>Nombre del Titular:</strong> {$formulario["nombres"]} {$formulario["apellidos"]} - 
               <strong>Cantidad de huéspedes:</strong> {$formulario["huespedes"]}</p>
            <p>Estado del Formulario:<a class='estado'><strong>{$formulario["estado"]}</strong></a> </p>";
// imprimir boton de acuerdo al formulario

switch ($estado) {
    case "pendiente por diligenciamiento de usuario":
        echo "<p> <button><a href='formulariouser.php?formularioID={$idURL}'>    Obtener link </a></button> </p>
        </div>";
        break;
        case "pendiente por aprobar":
            echo "<p> <form  action='aprobar_formulario.php'  
            method= 'GET' onsubmit='return validarEnvio()'>
            
            <button  type='submit'> Aprobar </button> 
            <input type='hidden' name='id' value='".$idURL."' /> </form> 
            </p>
            </div>";
        break;
    default:
    echo "</div>";
        break;
}
           

            }
        } else {
            echo "❌ Error...";
        }
    }


    public function updateFormularioUsuario($db, $id, 
    $nombres = null, $apellidos = null, $tipoIdentificacion = null, $NroIdentificacion = null,
    $CiudadResidencia = null, $CiudadProcedencia = null,
    $motivoViaje = null
    )
    {
        /* Crear conexión a base de datos */

        $conn = $db->connect();

        //verificar que ID de reserva exista y verificar el estado

        $query = "SELECT * FROM formularios WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            // SI EXISTE LA RESERVA

            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $estado= $fila['estado'];

            if($estado == "Pendiente por diligenciamiento de usuario"){


                $query2 = "UPDATE formularios SET estado = 'Pendiente por aprobar',
                 tipo_identificacion = :tipo_identificacion, numero_identificacion
                  = :numero_identificacion, nombres = :nombres1, apellidos = :apellidos1,
                   ciudad_residencia = :residencia, ciudad_procedencia = :procedencia,
                    motivo = :motivo WHERE id = :id";

                $stmt2 = $conn->prepare($query2);
                $stmt2->bindParam(":tipo_identificacion", $tipoIdentificacion);
                $stmt2->bindParam(":numero_identificacion", $NroIdentificacion);
                $stmt2->bindParam(":nombres1", $nombres);
                $stmt2->bindParam(":apellidos1", $apellidos);
                $stmt2->bindParam(":residencia", $CiudadResidencia);
                $stmt2->bindParam(":procedencia", $CiudadProcedencia);
                $stmt2->bindParam(":motivo", $motivoViaje);
                $stmt2->bindParam(":id", $id);

        if ($stmt2->execute()) {

            echo "✅ Reserva registrada exitosamente.";
                return true;

             }
             
            } else if($estado == "Pendiente por aprobar"){
                echo "✅ Los datos de la reserva han sido actualizados correctamente.";

                return true;

             } else {
                echo "❌ Error al actualizar datos de la reserva - Reserva no existe";
                return false;
            }
        } else {
            echo "❌ Error al actualizar datos de la reserva - Database error";
            return false;
        }

    }

    public function aprobar($db, $id)
    {
        /* Crear conexión a base de datos */

        $conn = $db->connect();

        //verificar que ID de reserva exista y verificar el estado

        $query = "SELECT * FROM formularios WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            // SI EXISTE LA RESERVA

            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $estado= $fila['estado'];

            if($estado == "Pendiente por aprobar"){
                $query2 = "UPDATE formularios SET estado = 'Aprobado' WHERE id = :id";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bindParam(":id", $id);
                
        if ($stmt2->execute()) {
                return true;
             }
            }else {
                return false;
            }
        } else {
            return false;
        }

    }
}
?>
