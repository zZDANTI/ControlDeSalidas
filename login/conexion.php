<?php

$host='localhost';
$dbname='control_de_salidas';
$user='root';
$pass='';

$conn = mysqli_connect($host, $dbname, $user, $pass);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
mysqli_close($conn);
?>