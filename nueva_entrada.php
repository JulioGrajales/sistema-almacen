<?php
    require_once("conexion.php");

    session_start();
    if($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
        header("location: index.php");
    }

    $query_get_almacenes = "SELECT id_almacen,nombre_almacen FROM almacenes";
    $resultado_get_almacenes = mysqli_query($conn,$query_get_almacenes);

    $querye_get_productos = "SELECT * FROM productos";
    $resultado_get_productos = mysqli_query($conn,$querye_get_productos);

    $mensaje = '';
    $tipo = '';
    $lugar = '';
    if(isset($_POST['entrada_continuar'])){
        if(!empty($_POST['select_productos']) && !empty($_POST['select_almacenes'])){
            $almacen = $_POST['select_almacenes'];
            $producto = $_POST['select_productos'];
            $cantidad = $_POST['cantidad_producto'];
            $precio = $_POST['precio_producto'];
            
            $query_ya_existe = "SELECT * FROM productos_almacen WHERE id_almacen = '$almacen' and id_producto = '$producto'";
            $resultado_ya_existe = mysqli_query($conn,$query_ya_existe);
            $filas_resultado_ya_existe = mysqli_num_rows($resultado_ya_existe);

            $query_crear_registro = "INSERT INTO entradas(id_almacen,id_producto,cantidad,costo,fecha,hora)
            VALUES ('$almacen','$producto','$cantidad','$precio',curdate(),curtime())";
            if(mysqli_query($conn,$query_crear_registro)){
                $mensaje = 'Entrada realizada exitosamente';
                $tipo = "alert-primary";
            }

            if($filas_resultado_ya_existe > 0){
                //SI YA ESTA REGISTRADO
                $query_actualizar_existencia = "UPDATE productos_almacen SET costop_producto=(cantidad_producto*costop_producto+'$cantidad'*'$precio')/(cantidad_producto+'$cantidad'),
                cantidad_producto = cantidad_producto+'$cantidad'
                WHERE id_almacen = '$almacen' and id_producto = '$producto'";
                mysqli_query($conn,$query_actualizar_existencia);                                                

            }else{
                //SI NO ESTA REGISTRADO
                $query_obtener_lugar = "SELECT max(lugar) FROM productos_almacen WHERE id_almacen = '$almacen'";
                $resultado_obtener_lugar = mysqli_query($conn,$query_obtener_lugar);

                if(empty($resultado_obtener_lugar)){
                    $lugar = 1;
                }else{
                    $resultado_lugar = mysqli_fetch_row($resultado_obtener_lugar);
                    $lugar = $resultado_lugar[0] + 1;
                }

                $query_nueva_existencia = "INSERT INTO productos_almacen(id_almacen,lugar,id_producto,cantidad_producto,costop_producto)
                VALUES ('$almacen','$lugar','$producto','$cantidad','$precio')";
                mysqli_query($conn,$query_nueva_existencia);
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
    <title>Nueva entrada</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos_login.css">


    <script>
        


        function ValidaEntrada(){
            var cantidad_producto = document.forms["entrada_form"]["cantidad_producto"].value;            
            var precio_producto = document.forms["entrada_form"]["precio_producto"].value;

            if(cantidad_producto != "" && precio_producto != ""){
                
                if(cantidad_producto.length > 3 ){
                    alert("La cantidad es muy grande");
                    return false;
                }
                if(precio_producto.length > 10){
                    alert("El precio es muy grande");
                    return false;
                }
                if(cantidad_producto <= 0){
                    alert("La cantidad no puede ser 0 o menor");
                    return false;
                }
                if(precio_producto <= 0){
                    alert("El precio no puede ser 0 o menor");
                    return false;
                }
                                
                return true;
                
            }else{
                alert("Los campos no pueden estar vacio");
                return false;
            }
        }
    
    
    </script>

</head>
<body>
    <div class="jumbotron mb-0 p-4">
        <a href="index.php">Cerrar sesion</a>
        <p> <?php echo "Usuario: " . $_SESSION['usuario'] ?> </p>
        <h1 class="text-center">Nueva entrada</h1>
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
            <form action="" method="POST" id="entrada_form" onsubmit="return ValidaEntrada()">
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
                        Ingrese precio:
                    </h3>                                
                </div>
                <div class="col-12 mb-2">
                    <input type="number" step="0.01" class="form-control mb-3" name="precio_producto" id="precio_producto" placeholder="Ingrese precio">
                </div>
                <div class="col-12 mb-2">
                    <h3 class="text-center">
                        Ingrese cantidad:
                    </h3>                                
                </div>
                <div class="col-12 mb-2">
                    <input type="number" class="form-control mb-3" name="cantidad_producto" id="cantidad_producto" placeholder="Ingrese cantidad entrante">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="entrada_continuar">Continuar</button>
                </div>
                                                       
            </form>
        </div>

        <?php if(isset($_POST['entrada_continuar'])){ ?>
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