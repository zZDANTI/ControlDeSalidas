<?php

$host='localhost';
$dbname='control_de_salidas';
$user='root';
$pass='';

$conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

$conexion ->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


?>