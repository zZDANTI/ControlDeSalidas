<?php
// Recogida de parámetros
$nia = isset($_POST['nia'])? $_POST['nia']:null;
$nombre = isset($_POST['nombre'])? $_POST['nombre']:null;
$apellido_1 = isset($_POST['apellido_1'])? $_POST['apellido_1']:null;
$motivo_control = isset($_POST['motivo'])? $_POST['motivo']:null;
$pers_autorizacion_registrar = "victorsarabia@gmail.com";
$observaciones = isset($_POST['observaciones'])? $_POST['observaciones']:null;
$submit_insert = isset($_POST['submit']);

echo "<pre>";
print_r($_POST);
echo "</pre>";

// Operación de inserción
if ($submit_insert) {
    $host='localhost';
    $dbname='control_de_salidas';
    $user='root';
    $pass='';

    try {
        # MySQL con PDO_MYSQL
        # Para que la conexion al mysql utilice las collation UTF-8 añadir charset=utf8 al string de la conexion.
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

        # Para que genere excepciones a la hora de reportar errores.
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        # Revisar si el alumno tiene controles abiertos
        $is_control = 'SELECT id_alumno FROM control where fecha_llegada IS NULL';
        $stmt = $pdo->prepare($is_control);
        $is_insert = $stmt->execute();
        $is_control_array = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($nia == $is_control_array['id_alumno']) {
            echo '<script>
                    alert("El alumno ya tiene un control abierto, operacion cancelada")
                  </script>';
            header("index.php", true); //TODO redireccion no funciona
            exit();
        }

        # Insertar registros
        $sql = 'INSERT INTO control (fecha_registrar, autorizado, id_alumno, id_personal_de_autorizacion_registrar, id_motivo)
	        VALUES (NOW(), :autorizado, :nia, :pers_autorizacion_registrar, :motivo_control);';
        echo $sql;
        if ($motivo_control == "no tiene autorizacion") {
            $values = [
                ":nia" => $nia,
                ":pers_autorizacion_registrar" => $pers_autorizacion_registrar,
                ":motivo_control" => $motivo_control,
                ":autorizado" => 0
            ];
        } else {
            $values = [
                ":nia" => $nia,
                ":pers_autorizacion_registrar" => $pers_autorizacion_registrar,
                ":motivo_control" => $motivo_control,
                ":autorizado" => 1
            ];
        }
        $stmt = $pdo->prepare($sql);
        $is_insert = $stmt->execute($values);

        if ($is_insert) {
            header("index.php", true);
            exit();
        } else {
            echo '<script>
                    alert("Error al insertar alumno.")
                  </script>';
            header("index.php", true);
            exit();
        }

    } catch(PDOException $e) {
        echo $e->getMessage();

        $stmt = null;
        $pdo = null;
    }
}
