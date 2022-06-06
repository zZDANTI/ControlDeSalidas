<?php
include('bloqueo.php');
include('conexion.php');

// Recogida de parámetros
$nia = isset($_POST['nia'])? $_POST['nia']:null;
$pers_autorizacion = $_SESSION['usuario'];
$submit = isset($_POST['closeControl']);

// Operación de inserción
if ($submit) {

    try {

        # Revisar si el alumno tiene controles abiertos
        $is_control = 'SELECT id_alumno FROM control WHERE fecha_registrar IS NOT NULL AND fecha_llegada IS NULL AND id_alumno="'.$nia.'"';
        $stmt = $conexion->prepare($is_control);
        $is_insert = $stmt->execute();
        $is_control_array = $stmt->fetch(PDO::FETCH_ASSOC);

        if ((!$is_control_array['id_alumno'])) {
            echo '<script>
                    alert("El alumno no tiene ningun control abierto.")
                    window.location = "../controlAlumno.php";
                  </script>';
            exit();
        }

        # Insertar registros
        $sql = 'UPDATE control SET fecha_llegada=NOW(), id_personal_llegada=:pers_autorizacion
                WHERE id_alumno=:nia';
        echo $sql;
        $values = [
            ":pers_autorizacion" => $pers_autorizacion,
            ":nia" => $nia
        ];
        $stmt = $conexion->prepare($sql);
        $is_insert = $stmt->execute($values);

        # Para liberar los recursos utilizados en la consulta SELECT
        $stmt = null;
        $conexion = null;

        if ($is_insert) {
            echo '<script>
                    alert("Control cerrado correctamente.")
                    window.location = "../controlAlumno.php";
                  </script>';
            exit();
        } else {
            echo '<script>
                    alert("Ha habido un problema, operacion cancelada.")
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