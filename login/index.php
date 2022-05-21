<?php
    session_start();

    if(isset($_SESSION['usuario'])){
        header("location: prueba.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Control De Salidas</title>
	<meta charset="UTF-8">
	
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../Imgs/favicon/favicon_campico.ico"/>

	<link rel="stylesheet" type="text/css" href="css/login.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div>
		<div class="fondoLogin" style="background-image: url('../Imgs/login/fondo_login.jpg');">
			<div class="cajaLogin">
				
				<span class="loginCampico">
					<img src="../Imgs/login/logo_campico.jpg" alt="logoCampico" width="100%">
				</span>

				<span class="tituloLogin">
					Login
				</span>
				
				<form action="login.php" method="post">

			
					<div class="loginFormulario" data-validate = "Enter username">
						<input class="loginCuenta" type="text" name="email" placeholder="Email">

					</div>

					<div class="loginFormulario" data-validate="Enter password">
						<input class="loginCuenta" type="password" name="contrasenya" placeholder="Contraseña">
					</div>
					
					<div class="botonEntrar">
						<button class="letraBoton">
							<input type="submit" value="Entrar">
						</button>
					</div>

					
				</form>
			</div>
		</div>
	</div>
	

</body>
</html>