<?php

    require_once("conexion.php");

    session_start();


    if($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
        header("location: index.php");
    }


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Altas productos</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos_login.css">

    <script>
        function ValidaAlta(){
            var nombre_producto = document.forms["alta_producto"]["nombre_articulo"].value;
            
            if(nombre_producto != ""){
                if(nombre_producto.length >= 50){
                    alert("El nombre no puede ser tan largo");
                    return false;
                }
                return true;
            }else{
                alert("El nombre no puede estar vacio");
                return false;
            }
        }


    </script>

</head>
<body>
    <!--TITULAR-->
    <div class="jumbotron mb-0 p-4" >
        <a href="index.php">Cerrar sesion</a>
        <p> <?php echo "Usuario: " . $_SESSION['usuario'] ?> </p>
        <h1 class="text-center">Altas productos</h1>
    </div>

    <!--NABVAR-->
    <?php require_once("navegacion.php"); ?>
    <!--FORMULARIO-->
    <div class="container">
        <div class="row justify-content-center bg-dark text-light p-3 mb-3">
            <div class="col-12 mb-2">
                <h3 class="text-center">Ingrese nuevo nombre de producto</h3>
            </div>
            <div class="col-12">
                <form action="" method="POST" onsubmit="return ValidaAlta()" id="alta_producto">
                    
                    <input type="text" class="form-control mb-3" name="nombre_articulo" id="nombre_articulo" placeholder="Ingrese nombre de articulo">
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="alta_continuar">Registrar</button>
                    </div>
                                        
                </form>
            </div>
        </div>

        <!--VALIDACIONES Y ACCIONES-->
        <?php 
            if(isset($_POST['alta_continuar'])){
                $mensaje = '';
                $tipo = '';

                $nombre = $_POST['nombre_articulo'];
                $consulta_validar = "SELECT nombre_producto FROM productos WHERE nombre_producto ='$nombre'";
                $resultado = mysqli_query($conn,$consulta_validar);
                $num_filas = mysqli_num_rows($resultado);

                if($num_filas == 0){
                    $consulta_insertar = "INSERT INTO productos(nombre_producto) VALUES ('$nombre')";
                    if (mysqli_query($conn, $consulta_insertar)) {
                        $mensaje = 'Producto registrado exitosamente!';
                        $tipo = 'alert-primary';
                    }else{
                        echo "Error " . $conn->error;
                        die();
                    }
                }else{
                    $mensaje = 'Producto ya registrado con el mismo nombre';
                    $tipo = 'alert-danger';
                }
        ?>
                <div class="alert <?php echo $tipo; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

        <?php } ?>
        
        
    </div>
    


    <!--SCRIPTS DE JAVASCRIPT DE BOOTSTRAP-->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>