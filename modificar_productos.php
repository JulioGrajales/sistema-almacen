<?php

    require_once("conexion.php");

    session_start();


    if($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
        header("location: index.php");
    }

    //modificar
    $da_error = 0;
    if(isset($_POST['modificar_continuar'])){ 
        if(empty($_POST['select_productos'])){ 
         
            $da_error = 1;


        }
        else{
            $id_producto = $_POST['select_productos'];
            $nuevo_nombre = $_POST['nuevo_nombre_articulo'];
            $query_modificar_productos = "UPDATE productos SET nombre_producto = '$nuevo_nombre' WHERE id_producto = '$id_producto'";
            if($conn->query($query_modificar_productos) === TRUE){ 
                $da_error = 0;
            }
            else{
                echo "Error, no esta conectada la base de datos: " . $conn->error;
            }
        } 
    } 

    


    $query_get_lista_productos = "SELECT * FROM productos";
    $resultados_get_lista_productos = mysqli_query($conn,$query_get_lista_productos);
    

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modificar productos</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos_login.css">

    <script>
        function ValidaModificar(){
            var nombre_producto = document.forms["Modificar_productos"]["nuevo_nombre_articulo"].value;
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
        <h1 class="text-center">Modificar productos</h1>
    </div>

    <!--NAVEGACION-->
    <?php require_once("navegacion.php"); ?>

    <div class="container">
        <div class="row justify-content-center bg-dark text-light p-3 mb-3">
            <div class="col-12 mb-2">
                <h3 class="text-center">
                    Seleccione producto a modificar:
                </h3>
            </div>
            <form action="" method="POST" id="Modificar_productos" onsubmit="return ValidaModificar()">        
                <div class="col-12 mb-2">
                    <select name="select_productos" class="custom-select mb-3">
                        <option value="" selected disabled>-Selecciona producto-</option>
                            <?php  while($row = mysqli_fetch_array($resultados_get_lista_productos)){ ?>
                                        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                            <?php  } ?>
                    </select>
                </div>
                <div class="col-12 mb-2">
                    <h3 class="text-center">
                        Ingrese nuevo nombre para el producto:
                    </h3>                
                </div>
                <div class="col-12 mb-2">
                    <input type="text" class="form-control mb-3" name="nuevo_nombre_articulo" id="nuevo_nombre_articulo" placeholder="Ingrese nuevo nombre de articulo">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="modificar_continuar">Modificar</button>
                </div>
            </form>
            
        </div>
        <!--ALERTAS ACA-->
        <?php if(isset($_POST['modificar_continuar'])){ 
                     if($da_error == 0){ ?>
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    Producto modificado exitosamente.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                    <?php }else{ ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Por favor, seleccione un producto.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                    <?php  } 
                } ?>

    </div>

<!--TODO: MENSAJES DE EXITO/ERROR, VALIDAR ENTRADA A BD-->

    <!--SCRIPTS DE JAVASCRIPT DE BOOTSTRAP-->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>