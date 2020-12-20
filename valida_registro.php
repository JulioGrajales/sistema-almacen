<?php

    require_once("conexion.php");

    
    if(isset($_POST["Registro_continuar"])){
        $mensaje = '';
        $tipo = '';

        $user_n = $_POST['usuario_registro'];
        $user_p = $_POST['password_registro'];
        $consulta = "SELECT * FROM users WHERE nombre_user = '$user_n' AND password_user = '$user_p'";
        $resultado = mysqli_query($conn,$consulta);
        $filas = mysqli_num_rows($resultado);
        
        

        if($filas==0){
            $consulta2 = "INSERT INTO users(nombre_user,password_user) VALUES ('$user_n','$user_p')";
            
            if (mysqli_query($conn, $consulta2)) {
                $mensaje = 'Usuario registrado exitosamente!';
                $tipo = 'alert-primary';
            }else{
                echo "Error " . $conn->error;
                die();
            }
        }else {
            $tipo = 'alert-danger';
            $mensaje = 'Ese usuario ya esta registrado';
        }
    }


?>