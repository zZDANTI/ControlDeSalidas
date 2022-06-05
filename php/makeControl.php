<?php
include('bloqueo.php');
include('conexion.php');

// Recogida de parámetros
$nia = isset($_POST['nia'])? $_POST['nia']:null;
$nombre = isset($_POST['nombre'])? $_POST['nombre']:null; //TODO recogerlos con una consulta no por POST
$apellido_1 = isset($_POST['apellido_1'])? $_POST['apellido_1']:null;
$motivo_control = isset($_POST['motivo'])? $_POST['motivo']:null;
$pers_auth = $_SESSION['usuario'];
$observaciones = isset($_POST['observaciones'])? $_POST['observaciones']:null;
$submit = isset($_POST['makeControl']);

echo "<pre>";
print_r($_POST);
echo "</pre>";
echo $pers_auth;

// Operación de inserción
if ($submit) {
    try {
        # Revisar si el alumno tiene controles abiertos
        $is_control = 'SELECT id_alumno FROM control WHERE fecha_llegada IS NULL AND id_alumno="'.$nia.'"';
        $stmt = $conexion->prepare($is_control);
        $is_insert = $stmt->execute();
        $is_control_array = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($is_control_array['id_alumno']!=null) {
            echo '<script>
                    alert("El alumno ya tiene un control abierto, operacion cancelada");
                    window.location = "../controlAlumno.php";
                  </script>';
            exit();
        }

        # Insertar registros
        $sql = 'INSERT INTO control (observaciones, fecha_registrar, autorizado, id_alumno, id_personal_registrar, id_motivo)
	        VALUES (:observaciones, NOW(), :autorizado, :nia, :pers_autorizacion_registrar, :motivo_control);';
        echo $sql;
        if ($motivo_control == "No tiene autorizacion") {
            $values = [
                ":observaciones" => $observaciones,
                ":nia" => $nia,
                ":pers_autorizacion_registrar" => $pers_auth,
                ":motivo_control" => $motivo_control,
                ":autorizado" => 0
            ];
        } else {
            $values = [
                ":observaciones" => $observaciones,
                ":nia" => $nia,
                ":pers_autorizacion_registrar" => $pers_auth,
                ":motivo_control" => $motivo_control,
                ":autorizado" => 1
            ];
        }
        $stmt = $conexion->prepare($sql);
        $is_insert = $stmt->execute($values);

        # Para liberar los recursos utilizados en la consulta SELECT
        $stmt = null;
        $conexion = null;

        if ($is_insert) {
            echo '<script>
                    alert("Alumno insertado correctamente.")
                    window.location = "../controlAlumno.php";
                  </script>';
            exit();
        } else {
            echo '<script>
                    alert("Error al insertar alumno.");
                    window.location = "../controlAlumno.php";
                  </script>';
            exit();
        }

    } catch(PDOException $e) {
        echo $e->getMessage();

        $stmt = null;
        $conexion = null;
    }
}
