<?php
include('bloqueo.php');
include('conexion.php');

// Recogida de parámetros
$nia = isset($_POST['nia'])? $_POST['nia']:null;
$nombre = isset($_POST['nombre'])? $_POST['nombre']:null;
$ape_1 = isset($_POST['ape_1'])? $_POST['ape_1']:null;
$ape_2 = isset($_POST['ape_2'])? $_POST['ape_2']:null;
$id_curso = isset($_POST['id_curso'])? $_POST['id_curso']:null;
if (isset($_POST['seeMore'])) {
$submit=true;
$submit_type="seeMore";
} elseif (isset($_POST['updateAlumno'])) {
$submit=true;
$submit_type="updateAlumno";
}

echo "type".$submit_type;
echo "sub".$submit;

echo "<pre>";
print_r($_POST);
echo "</pre>";

// Operación de inserción
if ($submit) {
    try {
        # Revisar si el alumno existe
        $is_control = 'SELECT id_alumno FROM control WHERE id_alumno="'.$nia.'"';
        $stmt = $conexion->prepare($is_control);
        $is_insert = $stmt->execute();
        $is_control_array = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($is_control_array['id_alumno']==null) {
            echo '<script>
                    alert("El alumno no existe.")
                    window.location = "../controlAlumno.php";
                  </script>';
            exit();
            exit();
        }

        if ($submit_type=='seeMore') {

            $sql = 'SELECT * FROM alumno WHERE nia=:nia';
//        echo $sql;
            $values = [
                ":nia" => $nia
            ];
            $stmt = $conexion->prepare($sql);
            $is_insert = $stmt->execute($values);

            $arr = $stmt->fetch(PDO::FETCH_ASSOC);

            $nombre = $arr["nombre"];
            $ape_1 = $arr["apellido_1"];
            $ape_2 = $arr["apellido_2"];
            $id_curso = $arr["id_curso"];

            # Para liberar los recursos utilizados en la consulta SELECT
            $stmt = null;
            $conexion = null;
            ?>
            <form action="seeMore.php">
                <label for="nia">NIA</label><br>
                <input type="text" name="nia" value="<?php $nia?>"><br>
                <label for="nombre">Nombre:</label><br>
                <input type="text" name="nombre" value="<?php $nombre?>"><br>
                <label for="ape_1">Apellido 1</label><br>
                <input type="text" name="ape_1" value="<?php $ape_1?>"><br>
                <label for="ape_2">Apellido 2</label><br>
                <input type="text" name="ape_2" value="<?php $ape_2?>"><br>
                <label for="id_curso">Curso</label><br>
                <select name="id_curso">
                    <option value="1">1º</option>
                    <option value="2">2º</option>
                    <option value="3">3º</option>
                    <option value="4">4º</option>
                    <option value="otro">otro</option>
                </select>
                <input type="submit" name="updateAlumno">
            </form>

            <?php
        } else {
            # Insertar registros
            $sql = 'UPDATE alumno SET nia=:nia, nombre=:nombre, apellido_1=:ape_1, apellido_2=:ape_2, id_curso=:id_curso
                WHERE id_alumno=:nia';
            echo $sql;
            $values = [
                ":nia" => $nia,
                ":nombre" => $nombre,
                ":ape_1" => $ape_1,
                ":ape_2" => $ape_2,
                ":id_curso" => $id_curso
            ];
            $stmt = $conexion->prepare($sql);
            $is_insert = $stmt->execute($values);

            # Para liberar los recursos utilizados en la consulta SELECT
            $stmt = null;
            $conexion = null;

            if ($is_insert) {
                echo '<script>
                    alert("Alumno editado correctamente.")
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
        }

    } catch (PDOException $e) {
        echo $e->getMessage();

        $stmt = null;
        $conexion = null;
    }
}