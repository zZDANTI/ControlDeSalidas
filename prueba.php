<?php
    include('php/bloqueo.php');  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/controlSalidas.css">
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
                    <a href="#" class="nav-menu-link nav_link">PonerAQUI</a>
                </li>
                <li class="nav-menu-item">
                    <a href="#" class="nav-menu-link nav_link">PonerAQUI</a>
                </li>
                <li class="nav-menu-item">
                    <a href="#" class="nav-menu-link nav_link">PonerAQUI</a>
                </li>
                <li class="nav-menu-item">
                    <a href="perfilProfesor.php" class="nav-menu-link nav_link">Perfil</a>
                </li>
            </ul>

        </nav>
    </header>
    <a href="php/cerrarSesion.php">Cerrar sesion</a>
</body>
</html>