<?php
include ('php/bloqueo.php');
include ('php/conexion.php');

$pagina = isset($_POST["pagina"])? $_POST["pagina"]:1;


$sql_count = 'SELECT count(*) AS total FROM control WHERE true';
    $num_registros=10;
    $sql_where  = "";

    $filters = [];

    $stmt = $conexion->prepare($sql_count.$sql_where);
    $stmt->execute($filters);
    $arrAlumnos = $stmt->fetch(PDO::FETCH_ASSOC);
    $controlCerrado = $arrAlumnos["total"];
    $total_paginas = ceil($controlCerrado/$num_registros);

    // Paginador
    if (isset($_POST["primera"]) && $pagina>1)
        $pagina = 1;
    if (isset($_POST["anterior"]) && $pagina>1)
        $pagina--;
    if (isset($_POST["siguiente"]) && $pagina<$total_paginas)
        $pagina++;
    if (isset($_POST["ultima"]) && $pagina<$total_paginas)
        $pagina = $total_paginas;

try {
    # Recoger los controles
    $sql = 'SELECT c.*, a.nombre FROM control c JOIN alumno a ON a.nia=c.id_alumno
     WHERE fecha_llegada IS NOT NULL ORDER BY fecha_registrar DESC';
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    ?>
    <!doctype html>
    <html lang="es">
    <head>
        <title>Controles Cerrados</title>
        <link rel="stylesheet" type="text/css" href="css/controlSalidas.css">
        <script src="https://kit.fontawesome.com/7e5b2d153f.js" crossorigin="anonymous"></script>
        <script defer src="js/header.js"></script>
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css">
        <link rel="icon" type="image/png" href="Imgs/favicon/favicon_campico.ico"/>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>
    <header class="header">
        <nav class="nav">
            <a href="#" class="logo"><img src="Imgs/big-logo.png" alt="logoCampico"></a>
            <button class="boton">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-menu">
                <li class="nav-menu-item">
                    <a href="controlAlumno.php" class="nav-menu-link nav_link"><img src="Imgs/control_home.png" alt="" width="40px"></a>
                </li>
                <li class="nav-menu-item">
                    <a href="controlesCerrados.php" class="nav-menu-link nav_link"><img src="Imgs/icono_control.png" alt="" width="40px"></a>
                </li>
                <li class="nav-menu-item">
                    <a href="#" class="nav-menu-link nav_link"><img src="Imgs/logo_usuario.png" alt="" width="40px"></a>
                </li>
                <li class="nav-menu-item">
                    <a href="perfilProfesor.php" class="nav-menu-link nav_link"><img src="Imgs/logo_usuario.png" alt="" width="40px"></a>
                </li>
            </ul>

        </nav>
    </header>
    <div class="controlCerrado">
        <div class="controlesCerradosHead"><h1>Controles Cerrados</h1></div>

        <div class="controlesCerradosBody">
            <table>
                <thead>
                <tr>
                    <th>NIA</th>
                    <th>NOMBRE</th>
                    <th>INICIO REGISTRO</th>
                    <th>FIN ACTIVIDAD</th>
                    <th>FIN REGISTRO</th>
                    <th>AUTORIZADOR SALIDA</th>
                    <th>AUTORIZADOR FIN ACTIVIDAD</th>
                    <th>AUTORIZADOR LLEGADA</th>
                    <th>MOTIVO</th>
                    <th>OBSERVACIONES</th>
                    <th>AUTORIZADO</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($arrControles = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>'.$arrControles['id_alumno'].'</td>';
                    echo '<td>'.$arrControles['nombre'].'</td>';
                    echo '<td>'.$arrControles['fecha_registrar'].'</td>';
                    echo '<td>'.$arrControles['fecha_fin_actividad'].'</td>';
                    echo '<td>'.$arrControles['fecha_llegada'].'</td>';
                    echo '<td>'.$arrControles['id_personal_registrar'].'</td>';
                    echo '<td>'.$arrControles['id_personal_fin_actividad'].'</td>';
                    echo '<td>'.$arrControles['id_personal_llegada'].'</td>';
                    echo '<td>'.$arrControles['id_motivo'].'</td>';
                    echo '<td>'.$arrControles['observaciones'].'</td>';
                    echo '<td>'.$arrControles['autorizado'].'</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
            <br>
            <form action="controlesCerrados.php" class="paginador" method="post">
                <input type="submit" name="primera" value="<<">
                    <input type="submit" name="anterior" value="<">
                        <input type="text" name="pagina" value="<?php echo $pagina ?>">
                        <input type="submit" name="siguiente" value=">">
                        <input type="submit" name="ultima" value=">>">
                    </form>
                    <p>Controles Cerrados <?php echo $controlCerrado ?> | Número total de páginas <?php echo $total_paginas ?></p>
                </div>
        </div>
    </div>
    </body>
    </html>

    <?php

} catch(PDOException $e) {
    echo $e->getMessage();

    $stmt = null;
    $conexion = null;
}