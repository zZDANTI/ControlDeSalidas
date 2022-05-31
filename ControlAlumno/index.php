<?php

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

    $stmt = $pdo->prepare($sql);
    $stmt->execute($filters);

    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
	<title>Control Alumno</title>
	<link rel="stylesheet" type="text/css" href="css/controlSalidas.css">
	<script src="https://kit.fontawesome.com/7e5b2d153f.js" crossorigin="anonymous"></script>
	<script defer src="js/header.js"></script>
    <link rel="stylesheet" href="css/stylesheet.css" type="text/css">
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
                        <a href="ControlAlumno/index.php" class="nav-menu-link nav_link"><img src="Imgs/control_home.png" alt="" width="40px"></a>
                    </li>
                    <li class="nav-menu-item">
                        <a href="#" class="nav-menu-link nav_link"><img src="Imgs/icono_control.png" alt="" width="40px"></a>
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
        
        <main>
            <div class="div-alumnos">
                <div class="alumnos-header">
                    <h1>ALUMNOS</h1>
                    <form method="post" action="index.php" class="main-form" margin-top="140px">
                        <label for=" nombre">Nombre:</label>
                        <input type="text" name="nombre" value="<?php echo $nombre?>">

                        <input type="submit" value="Buscar" name="buscar">

                        <br>
                    </form>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>
                            <p>NIA | </p>
                        </th>
                        <th>
                            <p>NOMBRE | </p>
                        </th>
                        <th>
                            <p>APELLIDO 1 | </p>
                        </th>
                        <th>
                            <p>ID_CURSO</p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    <div class="alumnos-body">
                        <?php

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            echo '<form method="post" action="makeControl.php">';
                            echo "<tr>";
                            $nia = $row['nia'];
                            echo "<td>".$nia."</td>";
                            echo '<input type="hidden" name="nia" value="'.$nia.'">';
                            $nombre = $row['nombre'];
                            echo "<td>".$nombre."</td>";
                            echo '<input type="hidden" name="nombre" value="'.$nombre.'">';
                            $apellido_1 = $row['apellido_1'];
                            echo "<td>".$apellido_1."</td>";
                            echo '<input type="hidden" name="apellido_1" value="'.$apellido_1.'">';
                            $id_curso = $row['id_curso'];
                            echo "<td>".$id_curso."</td>";
                            echo '<input type="hidden" name="id_curso" value="'.$id_curso.'">';
                            echo '<td><button type="submit" formaction="seeMore.php" name="seeMore">Mas Info</button></td>';
                            echo '<td><label for="motivo">Motivo del control:</label>
                                <select name="motivo" id="motivo">
                                    <option value="ir a secretaria">ir a secretaria</option>
                                    <option value="ir al bano">ir al bano</option>
                                    <option value="se va de excursion">se va de excursion</option>
                                    <option value="sus padres se lo llevan">sus padres se lo llevan</option>
                                    <option value="no tiene autorizacion" selected>no tiene autorizacion</option>
                                    <option value="otro">otro</option>
                                </select></td>';
                            echo '<td><label for="observaciones"> Observaciones: </label></td>';
                            echo '<td><textarea name="observaciones" maxlength="500"></textarea></td>';
                            echo '<td><button type="submit" formaction="makeControl.php" name="makeControl">Realizar control</button></td>';
                            echo "</tr>";
                            echo "</form>";
                        }

                        ?>
                    </div>
                    </tbody>
                </table>
            </div>
            <input type="submit" name="primera" value="<<">
            <input type="submit" name="anterior" value="<">
            <input type="text" name="pagina" value="<?php echo $pagina ?>">
            <input type="submit" name="siguiente" value=">">
            <input type="submit" name="ultima" value=">>">

            </form>

            <div class="div-control-abierto">

                <?php
                $sql = 'SELECT * from alumno a, control c where a.nia=c.id_alumno and c.fecha_llegada is null order by fecha_registrar desc';
                $sql .= $sql_where;
                $sql .= " limit ".($pagina-1)*$num_registros.", $num_registros";

                $stmt = $pdo->prepare($sql);
                $stmt->execute($filters);

                ?>

                <div class="alumnos-header">
                    <h1>CONTROLES ABIERTOS</h1>
                    <form method="post" action="index.php" class="main-form" margin-top="140px">
                        <label for=" nombre">Nombre:</label>
                        <input type="text" name="nombre" value="<?php echo $nombre?>">

                        <input type="submit" value="Buscar" name="buscar">

                        <br>
                    </form>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>
                            <p>NIA | </p>
                        </th>
                        <th>
                            <p>NOMBRE | </p>
                        </th>
                        <th>
                            <p>APELLIDO 1 | </p>
                        </th>
                        <th>
                            <p>ID_CURSO | </p>
                        </th>
                        <th>
                            <p>FECHA INICIO REGISTRO | </p>
                        </th>
                        <th>
                            <p>FECHA FIN ACTIVIDAD | </p>
                        </th>
                        <th>
                            <p>AUTORIZANTE REGISTRO | </p>
                        </th>
                        <th>
                            <p>AUTORIZANTE FIN ACTIVIDAD | </p>
                        </th>
                        <th>
                            <p>MOTIVO | </p>
                        </th>
                        <th>
                            <p>AUTORIZADO</p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    <div class="alumnos-body">

                        <?php

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            echo '<form method="post" action="closeControl.php">';
                            echo "<tr>";
                            $nia = $row['nia'];
                            echo "<td>".$nia."</td>";
                            echo '<input type="hidden" name="nia" value="'.$nia.'">';
                            $nombre = $row['nombre'];
                            echo "<td>".$nombre."</td>";
                            echo '<input type="hidden" name="nombre" value="'.$nombre.'">';
                            $apellido_1 = $row['apellido_1'];
                            echo "<td>".$apellido_1."</td>";
                            echo '<input type="hidden" name="apellido_1" value="'.$apellido_1.'">';
                            $id_curso = $row['id_curso'];
                            echo "<td>".$id_curso."</td>";
                            echo '<input type="hidden" name="id_curso" value="'.$id_curso.'">';
                            $fecha_registrar = $row['fecha_registrar'];
                            echo "<td>".$fecha_registrar."</td>";
                            echo '<input type="hidden" name="fecha_registrar" value="'.$fecha_registrar.'">';
                            $fecha_fin_actividad = $row['fecha_fin_actividad'];
                            echo "<td>".$fecha_fin_actividad."</td>";
                            echo '<input type="hidden" name="fecha_fin_actividad" value="'.$fecha_fin_actividad.'">';
                            $id_personal_de_autorizacion_registrar = $row['id_personal_de_autorizacion_registrar'];
                            echo "<td>".$id_personal_de_autorizacion_registrar."</td>";
                            echo '<input type="hidden" name="id_personal_de_autorizacion_registrar" value="'.$id_personal_de_autorizacion_registrar.'">';
                            $id_personal_de_autorizacion_fin_actividad = $row['id_personal_de_autorizacion_fin_actividad'];
                            echo "<td>".$id_personal_de_autorizacion_fin_actividad."</td>";
                            echo '<input type="hidden" name="id_personal_de_autorizacion_fin_actividad" value="'.$id_personal_de_autorizacion_fin_actividad.'">';
                            $id_motivo = $row['id_motivo'];
                            echo "<td>".$id_motivo."</td>";
                            echo '<input type="hidden" name="id_motivo" value="'.$id_motivo.'">';
                            $autorizado = $row['autorizado'];
                            echo "<td>".$autorizado."</td>";
                            echo '<input type="hidden" name="autorizado" value="'.$autorizado.'">';
                            echo '<td><button type="submit" formaction="closeControl.php" name="closeControl">Cerrar control</button></td>';
                            //TODO el control selecciona siempre el ultimo registro
                            echo "</tr>";
                            echo "</form>";
                        }
                        ?>
                    </div>
                    </tbody>
                </table>
                </form>
                <?php
                // Paginador
                if (isset($_POST["primera"]) && $pagina>1)
                    $pagina = 1;
                if (isset($_POST["anterior"]) && $pagina>1)
                    $pagina--;
                if (isset($_POST["siguiente"]) && $pagina<=$total_paginas)
                    $pagina++;
                if (isset($_POST["ultima"]) && $pagina<=$total_paginas)
                    $pagina = $total_paginas;
                ?>
            </div>
        </main>

    </body>
    </html>
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