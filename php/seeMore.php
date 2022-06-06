<?php
include('bloqueo.php');
include('conexion.php');

// Recogida de parámetros
$nia = isset($_POST['nia'])? $_POST['nia']:null;
$nombre = isset($_POST['nombre'])? $_POST['nombre']:null;
$ape_1 = isset($_POST['ape_1'])? $_POST['ape_1']:null;
$ape_2 = isset($_POST['ape_2'])? $_POST['ape_2']:null;
$id_curso = isset($_POST['id_curso'])? $_POST['id_curso']:null;

//Cursos
$curso = 'SELECT nombre FROM curso';
$stmtCurso = $conexion->prepare($curso);
$stmtCurso->execute();
$arrCurso = $stmtCurso->fetchAll(PDO::FETCH_ASSOC);


// Combrueba desde donde se envia el POST
if (isset($_POST['seeMore'])) {
    $submit=true;
    $submit_type="seeMore";
} elseif (isset($_POST['updateAlumno'])) {
    $submit=true;
    $submit_type="updateAlumno";
}

// Operación de inserción
if ($submit) {
    try {
        # Revisar si el alumno existe
        $is_control = 'SELECT nia FROM alumno WHERE nia="'.$nia.'"';
        $stmt = $conexion->prepare($is_control);
        $is_insert = $stmt->execute();
        $is_control_array = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($is_control_array['nia']==null) {
            echo '<script>
            alert("El alumno no existe.")
            window.location = "../controlAlumno.php";
            </script>';
            exit();
        }

        if ($submit_type=='seeMore') {

            $sql = 'SELECT * FROM alumno WHERE nia=:nia';
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

            <!DOCTYPE html>
            <html>
            <head>
                <title>Mas info</title>
                <link rel="stylesheet" type="text/css" href="../css/controlSalidas.css">
                <script src="https://kit.fontawesome.com/7e5b2d153f.js" crossorigin="anonymous"></script>
                <script defer src="js/header.js"></script>
                <link rel="stylesheet" href="../css/stylesheet.css" type="text/css">
                <link rel="icon" type="image/png" href="../Imgs/favicon/favicon_campico.ico"/>
                <meta charset="UTF-8">
                <meta name="viewport"
                content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
            </head>
            <body>
                <header class="header">
                    <nav class="nav">
                        <a href="../controlAlumno.php" class="logo"><img src="../Imgs/big-logo.png" alt="logoCampico"></a>
                        <button class="boton">
                            <i class="fas fa-bars"></i>
                        </button>
                        <ul class="nav-menu">
                            <li class="nav-menu-item">
                                <a href="../controlAlumno.php" class="nav-menu-link nav_link"><img src="../Imgs/control_home.png" alt="" width="40px"></a>
                            </li>
                            <li class="nav-menu-item">
                                <a href="../controlesCerrados.php" class="nav-menu-link nav_link"><img src="../Imgs/icono_control.png" alt="" width="40px"></a>
                            </li>
                            <li class="nav-menu-item">
                                <a href="#" class="nav-menu-link nav_link"><img src="../Imgs/logo_usuario.png" alt="" width="40px"></a>
                            </li>
                            <li class="nav-menu-item">
                                <a href="../perfilProfesor.php" class="nav-menu-link nav_link"><img src="../Imgs/logo_usuario.png" alt="" width="40px"></a>
                            </li>
                        </ul>

                    </nav>
                </header>
                <form action="seeMore.php" method="post">
                    <input type="hidden" name="nia" value="<?php echo $nia?>">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" name="nombre" value="<?php echo $nombre?>"><br>
                    <label for="ape_1">Apellido 1</label><br>
                    <input type="text" name="ape_1" value="<?php echo $ape_1?>"><br>
                    <label for="ape_2">Apellido 2</label><br>
                    <input type="text" name="ape_2" value="<?php echo $ape_2?>"><br>
                    <label for="id_curso">Curso</label><br>
                    <select name="id_curso" selected="<?php echo $id_curso ?>">
                        <?php
                        foreach ($arrCurso as $curso) {
                            if ($id_curso == $curso['nombre']){
                                echo '<option selected value="'.$curso['nombre'].'">'.$curso['nombre'].'</option>';
                            }else{
                                echo '<option value="'.$curso['nombre'].'">'.$curso['nombre'].'</option>';
                            }
                        }
                        ?> 
                    </select>
                    <input type="submit" name="updateAlumno">
                </form>
            </body>
            </html>            
            

            <?php
        } else {
            # Insertar registros
            $sql = 'UPDATE alumno SET nombre=:nombre, apellido_1=:ape_1, apellido_2=:ape_2, id_curso=:id_curso
            WHERE nia=:nia';
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