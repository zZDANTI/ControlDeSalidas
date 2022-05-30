<?php
	include('php/bloqueo.php'); 	
	include('php/conexion.php');
	$idUsuario = $_SESSION['usuario'];

	$sql_personal = "SELECT * FROM personal WHERE email='$idUsuario'";

	$stmt = $conexion->prepare($sql_personal);
    $stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Perfil del Profesor</title>
	<link rel="stylesheet" type="text/css" href="css/controlSalidas.css">
	<script src="https://kit.fontawesome.com/7e5b2d153f.js" crossorigin="anonymous"></script>
	<script defer src="js/header.js"></script>
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
                    <a href="#" class="nav-menu-link nav_link"><img src="Imgs/control_home.png" alt="" width="40px"></a>
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

	<div class="perfilEntero">
		<img src="Imgs/icono_usuario.jpg" class="imagenPerfil">
	
		<div class="perfil">
			
			<ul class="datos_perfil">
				<li class="palabras">
					NOMBRE: <?php echo $row['nombre']; ?>
				</li>
				<li class="palabras">
					1&#176;APELLIDO:  <?php echo $row['apellido_1']; ?>
				</li>
				<li class="palabras">
					2&#176;APELLIDO: <?php echo $row['apellido_2']; ?>
				</li>
				<li class="palabras">
					EMAIL: <?php echo $row['email']; ?>
				</li>
			</ul>
		</div>
		
	</div>

	<div class="salir">
		<a href="php/cerrarSesion.php"><img src="Imgs/cerrar_sesion.png" alt="cerrar_sesion" width="50px"></a>
	</div>

</body>
</html>