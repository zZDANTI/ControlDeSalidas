<?php 

session_start();

include('conexion.php');

$email=$_POST["email"];
$contrasenya=$_POST["contrasenya"];

$validar_login = "SELECT * FROM personal WHERE email='$email' and contrasenya='$contrasenya'";
$stmt = $conexion->prepare($validar_login);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


if($row >0){
    $_SESSION['usuario'] = $email;
    

    header("location: ../prueba.php");
    

    exit;
}else{
    echo ' 
        <script> 
            alert("Usuario no existe");
            window.location = "../index.php";
        </script>
    ';
    exit;
}
?>