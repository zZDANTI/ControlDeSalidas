<?php
// require 'auth.inc.php';

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";


$_SESSION['user_id'] = 25;
$_SESSION['user_name'] = "Juan Antonio";

// Ejemplo de conexión a diferentes tipos de bases de datos.
# Conectamos a la base de datos
$host='localhost';
$dbname='control_de_salidas';
$user='root';
$pass='';

// Recogida de filtros
// $ID_CURSO = isset($_POST["ID_CURSO"])? $_POST["ID_CURSO"]:null;
$nombre = isset($_POST["nombre"])? $_POST["nombre"]:null;
$pagina = isset($_POST["pagina"])? $_POST["pagina"]:1;
$num_registros=15;


try {
    # MySQL con PDO_MYSQL
    # Para que la conexion al mysql utilice las collation UTF-8 añadir charset=utf8 al string de la conexion.
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    # Para que genere excepciones a la hora de reportar errores.
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    // Total registros
    $sql_count = 'SELECT count(*) as total from alumno where true';
    $sql_where = "";

    $filters = [];
    // if (!empty($ID_CURSO)) {
    //     $sql_where .= " and ID_CURSO=:ID_CURSO";
    //     $filters[":ID_CURSO"] = $ID_CURSO;
    // }
    if (!empty($nombre)) {
        $sql_where .= " and nombre like :nombre";
        $filters[":nombre"] = "%".$nombre."%";
    }

    $stmt = $pdo->prepare($sql_count.$sql_where);
    $stmt->execute($filters);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_registros = $row["total"];
    $total_paginas = ceil($total_registros/$num_registros);

    // Paginador
    if (isset($_POST["primera"]) && $pagina>1)
        $pagina = 1;
    if (isset($_POST["anterior"]) && $pagina>1)
        $pagina--;
    if (isset($_POST["siguiente"]) && $pagina<=$total_paginas)
        $pagina++;
    if (isset($_POST["ultima"]) && $pagina<=$total_paginas)
        $pagina = $total_paginas;

    $sql = 'SELECT * from alumno where true';
    $sql .= $sql_where;
    $sql .= " limit ".($pagina-1)*$num_registros.", $num_registros";

    //echo $sql;exit();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($filters);


    //$stmt->setFetchMode(PDO::FETCH_ASSOC);
    // $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //echo "<pre>";
    //print_r($rows);
    //echo "</pre>";

    ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/stylesheet.css" type="text/css">
</head>

<body>
    <!-- <header>
        <nav class="nav-top">
            <ul>
                <li class="nav-top-item-big-logo"><img src="../Imgs/big-logo.png" alt="big-logo.png"></li>
                <li class="nav-top-item-1">
                    <h1>Control de Salidas</h1>
                </li>
                <li class="nav-top-perfil"><a href="#" class="nav-top-perfil-button"><img
                            src="../Imgs/default-profile-pic.jpg" alt="default-profile-pic"></a></li>
            </ul>
        </nav>
    </header> -->
    <main>
        <div class="div-alumnos">
            <div class="alumnos-header">
                <h1>ALUMNOS</h1>
                <form method="post" action="index.php" class="main-form" margin-top="140px">
                    <label for=" nombre">Nombre:</label>
                    <input type="text" name="nombre" value="<?php echo $nombre?>">

                    <!-- <label for="ID_CURSO">ID_CURSO:</label>
                    <input type="text" name="ID_CURSO" pattern="[a-z]{,10}" value="<?php echo $ID_CURSO?>"> -->

                    <input type="submit" value="Buscar" name="buscar">

                    <br>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>
                            <p>NIA </p>
                        </th>
                        <th>
                            <p>NOMBRE </p>
                        </th>
                        <th>
                            <p>APELLIDO 1 </p>
                        </th>
                        <th>
                            <p>ID_CURSO</p>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <div class="alumnos-body"></div>
        </div>
        <?php

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //echo "<pre>";
        //print_r($row);
        //echo "</pre>";
        //echo $row['NIA'] . " - ";
        //echo $row['NOMBRE'] . " - ";
        //echo $row['APELLIDO_1'] . "<br/>";

        echo "<tr>";
        echo "<td>".$row['nia']."</td>";
        echo "<td>".$row['nombre']."</td>";
        echo "<td>".$row['apellido_1']."</td>";
        echo "<td>".$row['id_curso']."</td>";
        echo '<td><label for="motivo">Motivo del control:</label>
            <select name="motivo" id="motivo">
                <option value="ir a secretaria">ir a secretaria</option>
                <option value="ir al bano">ir al bano</option>
                <option value="se va de excursion">se va de excursion</option>
                <option value="sus padres se lo llevan">sus padres se lo llevan</option>
                <option value="no tiene autorizacion" selected>no tiene autorizacion</option>
                <option value="otro">otro</option>
             </select></td>';
        echo '<td><button type="button" formaction="makeControl.php">Realizar control</button></td>';
        echo "</tr>";
    }
    ?>
        </tbody>
        </table>
        <input type="submit" name="primera" value="<<">
        <input type="submit" name="anterior" value="<">
        <input type="text" name="pagina" value="<?php echo $pagina ?>">
        <input type="submit" name="siguiente" value=">">
        <input type="submit" name="ultima" value=">>">

        </form>
        <?php

    # Para liberar los recursos utilizados en la consulta SELECT
    $stmt = null;
    $pdo = null;
}
catch(PDOException $e) {
    echo $e->getMessage();

    $stmt = null;
    $pdo = null;
}