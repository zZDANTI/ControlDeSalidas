<?php
include('php/bloqueo.php');
include('php/conexion.php');
$idUsuario = $_SESSION['usuario'];

//$sql_personal = "SELECT * FROM personal WHERE email='$idUsuario'";
//
//$stmt = $conexion->prepare($sql_personal);
//$stmt->execute();
//$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Recogida de filtros
// $ID_CURSO = isset($_POST["ID_CURSO"])? $_POST["ID_CURSO"]:null;
$nombre = isset($_POST["nombre"])? $_POST["nombre"]:null; //TODO arreglar esto
$pagina = isset($_POST["pagina"])? $_POST["pagina"]:1;
$num_registros=10;

try {

// Motivos
    $motivos = 'SELECT nombre FROM motivo';

    $stmtMotivos = $conexion->prepare($motivos);
    $stmtMotivos->execute();
    $arrMotivos = $stmtMotivos->fetch(PDO::FETCH_ASSOC);



// Total registros
    $sql_count = 'SELECT count(*) as total from alumno where true';
    $sql_where  = "";

    $filters = [];

    if (!empty($nombre)) {
        $sql_where .= " and nombre like :nombre";
        $filters[":nombre"] = "%".$nombre."%";
    }

    $stmt = $conexion->prepare($sql_count.$sql_where);
    $stmt->execute($filters);
    $arrAlumnos = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_registros = $arrAlumnos["total"];
    $total_paginas = ceil($total_registros/$num_registros);

    // Paginador
    if (isset($_POST["primera"]) && $pagina>1)
    $pagina = 1;
    if (isset($_POST["anterior"]) && $pagina>1)
    $pagina--;
    if (isset($_POST["siguiente"]) && $pagina<$total_paginas)
    $pagina++;
    if (isset($_POST["ultima"]) && $pagina<$total_paginas)
    $pagina = $total_paginas;

    $sql = 'SELECT * FROM alumno WHERE true ORDER BY nia ASC LIMIT '.($pagina-1)*$num_registros.", $num_registros";

    $stmt = $conexion->prepare($sql);
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
        
        <div class="controlAlumno">
            <div class="div-alumnos">
                <div class="alumnos-body">
                    
                    <h1>ALUMNOS</h1>
                    <form method="post" action="controlAlumno.php" class="main-form" margin-top="140px">
                        <label for=" nombre">Nombre:</label>
                        <input type="text" name="nombre" value="<?php echo $nombre?>">

                        <input type="submit" value="Buscar" name="buscar">

                        <br>
                    </form>
                
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
                                <p> 1&#176;APELLIDO </p>
                            </th>
                            <th>
                                <p> CURSO</p>
                            </th>
                        </tr>
                        </thead>
                        <tbody>


                        <?php

                        while ($arrAlumnos = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            echo '<form method="post" action="php/makeControl.php">';
                            echo "<tr>";
                            $nia = $arrAlumnos['nia'];
                            echo "<td>".$nia."</td>";
                            echo '<input type="hidden" name="nia" value="'.$nia.'">';
                            $nombre = $arrAlumnos['nombre'];
                            echo "<td>".$nombre."</td>";
                            echo '<input type="hidden" name="nombre" value="'.$nombre.'">';
                            $apellido_1 = $arrAlumnos['apellido_1'];
                            echo "<td>".$apellido_1."</td>";
                            echo '<input type="hidden" name="apellido_1" value="'.$apellido_1.'">';
                            $id_curso = $arrAlumnos['id_curso'];
                            echo "<td>".$id_curso."</td>";
                            echo '<input type="hidden" name="id_curso" value="'.$id_curso.'">';
                            echo '<td><button type="submit" formaction="php/seeMore.php" name="seeMore"> Más Info</button></td>';
                            echo '<td><label for="motivo">Motivo del control:</label>';
                            echo  '<select name="motivo">';
                                while ($arrMotivos = $stmtMotivos->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="'.$arrMotivos['nombre'].'">'.$arrMotivos['nombre'].'</option>';
                                }                   
                            echo '</select></td>';
                            echo '<td><label for="observaciones"> Observaciones: </label></td>';
                            echo '<td><textarea name="observaciones" maxlength="500"></textarea></td>';
                            echo '<td><button type="submit" formaction="php/makeControl.php" name="makeControl">Realizar control</button></td>';
                            echo "</tr>";
                            echo "</form>";
                        }

                        ?>
                </div>
                </tbody>
                </table>
                <form action="controlAlumno.php" class="paginador" method="post">
                <input type="submit" name="primera" value="<<">
                <input type="submit" name="anterior" value="<">
                <input type="text" name="pagina" value="<?php echo $pagina ?>">
                <input type="submit" name="siguiente" value=">">
                <input type="submit" name="ultima" value=">>">
            </form>
            </div>
            

            <div class="alumnos-header">
                <h1>CONTROLES ABIERTOS</h1>
            </div>

            <div class="div-control-abierto">

                <?php
                $sql = 'SELECT * from alumno a, control c where a.nia=c.id_alumno and c.fecha_llegada is null order by fecha_registrar desc limit '.($pagina-1)*$num_registros.", $num_registros";

                $stmt = $conexion->prepare($sql);
                $stmt->execute($filters);

                ?>

                
                <table>
                    <thead>
                    <tr>
                        <th>
                            <p> NIA  </p>
                        </th>
                        <th>
                            <p> NOMBRE  </p>
                        </th>
                        <th>
                            <p> 1&#176;APELLIDO  </p>
                        </th>
                        <th>
                            <p> CURSO  </p>
                        </th>
                        <th>
                            <p> INICIO REGISTRO  </p>
                        </th>
                        <th>
                            <p> FIN ACTIVIDAD  </p>
                        </th>
                        <th>
                            <p> AUTORIZANTE REGISTRO  </p>
                        </th>
                        <th>
                            <p> AUTORIZANTE FIN ACTIVIDAD  </p>
                        </th>
                        <th>
                            <p> MOTIVO </p>
                        </th>
                        <th>
                            <p></p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    <div class="alumnos-body2">

                        <?php

                        while ($arrAlumnos = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            echo '<form method="post" action="php/closeControl.php">';
                            echo "<tr>";
                            $nia = $arrAlumnos['nia'];
                            echo "<td>".$nia."</td>";
                            echo '<input type="hidden" name="nia" value="'.$nia.'">';
                            $nombre = $arrAlumnos['nombre'];
                            echo "<td>".$nombre."</td>";
                            echo '<input type="hidden" name="nombre" value="'.$nombre.'">';
                            $apellido_1 = $arrAlumnos['apellido_1'];
                            echo "<td>".$apellido_1."</td>";
                            echo '<input type="hidden" name="apellido_1" value="'.$apellido_1.'">';
                            $id_curso = $arrAlumnos['id_curso'];
                            echo "<td>".$id_curso."</td>";
                            echo '<input type="hidden" name="id_curso" value="'.$id_curso.'">';
                            $fecha_registrar = $arrAlumnos['fecha_registrar'];
                            echo "<td>".$fecha_registrar."</td>";
                            echo '<input type="hidden" name="fecha_registrar" value="'.$fecha_registrar.'">';
                            $fecha_fin_actividad = $arrAlumnos['fecha_fin_actividad'];
                            echo "<td>".$fecha_fin_actividad."</td>";
                            echo '<input type="hidden" name="fecha_fin_actividad" value="'.$fecha_fin_actividad.'">';
                            $id_personal_registrar = $arrAlumnos['id_personal_registrar'];
                            echo "<td>".$id_personal_registrar."</td>";
                            echo '<input type="hidden" name="id_personal_registrar" value="'.$id_personal_registrar.'">';
                            $id_personal_fin_actividad = $arrAlumnos['id_personal_fin_actividad'];
                            echo "<td>".$id_personal_fin_actividad."</td>";
                            echo '<input type="hidden" name="id_personal_fin_actividad" value="'.$id_personal_fin_actividad.'">';
                            $id_motivo = $arrAlumnos['id_motivo'];
                            echo "<td>".$id_motivo."</td>";
                            echo '<input type="hidden" name="id_motivo" value="'.$id_motivo.'">';
                            $autorizado = $arrAlumnos['autorizado'];
                            echo "<td>".$autorizado."</td>";
                            echo '<input type="hidden" name="autorizado" value="'.$autorizado.'">';
                            if ($fecha_fin_actividad==null) {
                                echo '<td><button type="submit" formaction="php/closeAct.php" name="closeAct">Validar control</button></td>';
                            } else {
                                echo '<td><button type="submit" formaction="php/closeControl.php" name="closeControl">Cerrar control</button></td>';
                            }
                            echo "</tr>";
                            echo "</form>";
                        }
                        ?>
                    </div>
                    </tbody>
                </table>
                </form>
            </div>
        </div>

    </body>
    </html>
    <?php

# Para liberar los recursos utilizados en la consulta SELECT
    $stmt = null;
    $conexion = null;
}
catch(PDOException $e) {
    echo $e->getMessage();

    $stmt = null;
    $conexion = null;
}