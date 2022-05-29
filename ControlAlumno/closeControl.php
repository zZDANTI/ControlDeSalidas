<?php
// Recogida de parámetros
$nia = isset($_POST['nia'])? $_POST['nia']:null;
$pers_autorizacion = "domingo@gmail.com";
$submit_insert = isset($_POST['closeControl']);

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
        $is_control = 'SELECT id_alumno FROM control where fecha_registrar IS NULL AND fecha_llegada IS NOT NULL';
        $stmt = $pdo->prepare($is_control);
        $is_insert = $stmt->execute();
        $is_control_array = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($nia != $is_control_array['id_alumno']) {
            echo '<script>
                    alert("El alumno no tiene ningun control abierto, operacion cancelada")
                  </script>';
            header("index.php", true); //TODO redireccion no funciona
            exit();
        }

        # Insertar registros
        $sql = 'UPDATE control SET fecha_llegada=NOW(), id_personal_de_autorizacion_llegada=:pers_autorizacion
                WHERE id_alumno=:nia';
        echo $sql;
        $values = [
            ":pers_autorizacion" => $pers_autorizacion,
            ":nia" => $nia
        ];
        $stmt = $pdo->prepare($sql);
        $is_insert = $stmt->execute($values);

        # Para liberar los recursos utilizados en la consulta SELECT
        $stmt = null;
        $pdo = null;

        if ($is_insert) {
            header("index.php", true);
            exit();
        } else {
            echo '<script>
                    alert("Error al cerrar el registro.")
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
