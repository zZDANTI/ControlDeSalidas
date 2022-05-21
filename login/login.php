<?php 

session_start();

include('conexion.php');

$email=$_POST["email"];
$contrasenya=$_POST["contrasenya"];

$validar_login = mysqli_query($conexion, "SELECT * FROM personal WHERE email='$email' and contrasenya='$contrasenya'");

if(mysqli_num_rows($validar_login)>0){
    $_SESSION['usuario'] = $email;
    header("location: prueba.php");
    exit;
}else{
    echo ' 
        <script> 
            alert("Usuario no existe");
            window.location = "index.html";
        </script>
    ';
    exit;
}
?>