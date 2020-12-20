<?php

    require_once("conexion.php");

    if(isset($_POST["Login_continuar"])){
        $daerror = 0;
        $username = $_POST["usuario_login"];
        $password = $_POST["password_login"];

        $consulta = "SELECT * FROM users WHERE nombre_user = '$username' AND password_user = '$password'";
        $resultado = mysqli_query($conn,$consulta);
        $filas = mysqli_num_rows($resultado);

        if($filas > 0){
            session_start();
            $_SESSION['usuario'] = $username;
            header("location: consulta_productos.php");

        }else{
            $daerror = 1;
        }
    }


?>