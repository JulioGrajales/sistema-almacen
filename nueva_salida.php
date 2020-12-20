<?php
    require_once("conexion.php");

    session_start();
    if($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
        header("location: index.php");
    }

    $query_get_almacenes = "SELECT id_almacen,nombre_almacen FROM almacenes";
    $resultado_get_almacenes = mysqli_query($conn,$query_get_almacenes);

    $query_get_productos = "SELECT * FROM productos";
    $resultado_get_productos = mysqli_query($conn,$query_get_productos);


    $mensaje = '';
    $tipo = '';
    if(isset($_POST['salida_continuar'])){
        if(!empty($_POST['select_productos']) && !empty($_POST['select_almacenes'])){
            $almacen = $_POST['select_almacenes'];
            $producto = $_POST['select_productos'];
            $cantidad = $_POST['cantidad_producto'];
            
            $query_revisar = "SELECT * FROM productos_almacen WHERE id_almacen = '$almacen' and id_producto = '$producto'";
            $resultado_revisar = mysqli_query($conn,$query_revisar);
            $filas = mysqli_num_rows($resultado_revisar);
            if($filas == 0){
                $mensaje = "ese producto no tiene ninguna existencia en dicho almacen";
                $tipo = "alert-warning";
            }else{

                $query_revisar_existencias = "SELECT cantidad_producto FROM productos_almacen WHERE id_almacen = '$almacen' and id_producto = '$producto'";
                $resultados_revisar_existencias = mysqli_query($conn,$query_revisar_existencias);
                $obtener_data = mysqli_fetch_row($resultados_revisar_existencias);
                if($cantidad > $obtener_data[0]){
                    $mensaje = "No hay existencias suficientes de ese producto";
                    $tipo = "alert-warning";
                }else{
                    $query_salida = "INSERT INTO salidas(id_almacen,id_producto,cantidad,fecha,hora)
                    VALUES ('$almacen','$producto','$cantidad',curdate(),curtime());";
                    $query_actualizar = "UPDATE productos_almacen SET cantidad_producto = cantidad_producto-'$cantidad' WHERE id_almacen = '$almacen' and id_producto = '$producto'";
                    mysqli_query($conn, $query_actualizar);
                    if(mysqli_query($conn,$query_salida)){
                        $mensaje = 'Salida realizada exitosamente';
                        $tipo = "alert-primary";
                    }else{
                        echo "Error " . $conn->error;
                        die();
                    }
                }

                
            }
        }else{
            $mensaje = 'Por favor, seleccione todas las opciones.';
            $tipo = 'alert-danger';
        }
    }

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nueva salida</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos_login.css">

    <script>
        


        function ValidaSalida(){
            var cantidad_producto = document.forms["salida_form"]["cantidad_producto"].value;            
            
            if(cantidad_producto != ""){
                
                if(cantidad_producto.length > 3){
                    alert("La cantidad es muy grande");
                    return false;
                }
                if(cantidad_producto <= 0){
                    alert("La cantidad no puede ser 0 o menor");
                    return false;
                }
                                
                return true;
                
            }else{
                alert("El campo no puede estar vacio");
                return false;
            }
        }
    
    
    </script>

</head>
<body>
    <div class="jumbotron mb-0 p-4">
        <a href="index.php">Cerrar sesion</a>
        <p> <?php echo "Usuario: " . $_SESSION['usuario'] ?> </p>
        <h1 class="text-center">Nueva salida</h1>
    </div>


    <!--NAVEGACION-->
    <?php require_once("navegacion.php"); ?>

    <div class="container">
    
        <div class="row justify-content-center bg-dark text-light p-3 mb-3">
            <div class="col-12 mb-2">
                <h3 class="text-center">
                    Seleccione Almacen:
                </h3>
            </div>
            <form action="" method="POST" id="salida_form" onsubmit="return ValidaSalida()">
                <div class="col-12 mb-2">
                
                    <select name="select_almacenes" class="custom-select mb-3">
                        <option value="" selected disabled>-Selecciona Almacen-</option>
                            <?php while($row = mysqli_fetch_array($resultado_get_almacenes)){ ?>
                                        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                            <?php } ?>
                    </select>                                    
                </div>
                <div class="col-12 mb-2">
                    <h3 class="text-center">
                        Seleccione Producto:
                    </h3>                                
                </div>
                <div class="col-12 mb-2">
                    <select name="select_productos" class="custom-select mb-3">
                        <option value="" selected disabled>-Selecciona Producto-</option>
                            <?php while($row = mysqli_fetch_array($resultado_get_productos)){ ?>
                                        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                            <?php } ?>
                    </select>                                
                </div>
                <div class="col-12 mb-2">
                    <h3 class="text-center">
                        Ingrese cantidad:
                    </h3>                                
                </div>
                <div class="col-12 mb-2">
                    <input type="number" class="form-control mb-3" name="cantidad_producto" id="cantidad_producto" placeholder="Ingrese cantidad saliente">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="salida_continuar">Continuar</button>
                </div>
                                                       
            </form>
            

        </div>

        <?php if(isset($_POST['salida_continuar'])){ ?>
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