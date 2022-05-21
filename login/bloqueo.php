<?php

    session_start();

    if (!isset($_SESSION['usuario'])){
        echo ' 
            <script> 
                alert("Por favor debes iniciar sesión");
                window.location = "index.html";
            </script>
        ';
        session_destroy();
        die();
    }    
?>