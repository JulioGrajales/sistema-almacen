<?php
    require_once("conexion.php");

    session_start();
    if($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
        header("location: index.php");
    }

    $query_get_almacenes = "SELECT id_almacen,nombre_almacen FROM almacenes";
    $resultado_get_almacenes = mysqli_query($conn,$query_get_almacenes);
    $resultado_get_almacenes_2 = mysqli_query($conn,$query_get_almacenes);

    $querye_get_productos = "SELECT * FROM productos";
    $resultado_get_productos = mysqli_query($conn,$querye_get_productos);

    $mensaje = '';
    $tipo = '';
    if(isset($_POST['traslado_continuar'])){
        
        if(!empty($_POST['select_almacen_entrada']) && !empty($_POST['select_almacen_salida']) && !empty($_POST['select_producto'])){
            if($_POST['select_almacen_entrada'] != $_POST['select_almacen_salida']){
                $almacen_salida = $_POST['select_almacen_salida'];
                $almacen_entrada = $_POST['select_almacen_entrada'];
                $producto = $_POST['select_producto'];
                $cantidad = $_POST['cantidad_producto'];

                $query_revisar_existencias = "SELECT cantidad_producto FROM productos_almacen WHERE id_almacen = '$almacen_salida' and id_producto = '$producto'";
                $resultados_revisar_existencias = mysqli_query($conn,$query_revisar_existencias);
                $obtener_data = mysqli_fetch_row($resultados_revisar_existencias);
                $filas_revisar_existencias = mysqli_num_rows($resultados_revisar_existencias);
                if($filas_revisar_existencias == 0){
                    $mensaje = "ese producto no tiene ninguna existencia en dicho almacen";
                    $tipo = "alert-warning";
                }else{
                    if($cantidad > $obtener_data[0]){
                        $mensaje = "No hay existencias suficientes de ese producto";
                        $tipo = "alert-warning";
                    }else{
                        
                        $query_salida = "INSERT INTO salidas(id_almacen,id_producto,cantidad,fecha,hora)
                        VALUES ('$almacen_salida','$producto','$cantidad',curdate(),curtime())";
                        $query_actualizar_salida = "UPDATE productos_almacen SET cantidad_producto=cantidad_producto-'$cantidad' WHERE id_almacen = '$almacen_salida' and id_producto = '$producto'";
                        mysqli_query($conn,$query_salida);
                        mysqli_query($conn,$query_actualizar_salida);
    
                        $query_get_precio = "SELECT costop_producto FROM productos_almacen WHERE id_almacen ='$almacen_salida' and id_producto='$producto'";
                        $resultado_get_precio = mysqli_query($conn,$query_get_precio);    
                        $valor_get_precio = mysqli_fetch_row($resultado_get_precio);
                        $precio = $valor_get_precio[0];

                        $query_entrada = "INSERT INTO entradas(id_almacen,id_producto,cantidad,costo,fecha,hora)
                        VALUES ('$almacen_entrada','$producto','$cantidad','$precio',curdate(),curtime())";
                        mysqli_query($conn,$query_entrada);

                        //revisando
                        $query_traslado = "INSERT INTO traspasos(id_almacen_salida,id_almacen_entrada,id_producto,cantidad,costo,fecha,hora)
                        VALUES ('$almacen_salida','$almacen_entrada','$producto','$cantidad','$precio',curdate(),curtime())";
                        mysqli_query($conn,$query_traslado);
                        
                        


                        $mensaje = 'Traspaso realizado con exito';
                        $tipo = 'alert-primary';

                        $query_ya_existe = "SELECT * FROM productos_almacen WHERE id_almacen = '$almacen_entrada' and id_producto = '$producto'";
                        $resultado_ya_existe = mysqli_query($conn,$query_ya_existe);
                        $filas_resultado_ya_existe = mysqli_num_rows($resultado_ya_existe);
                        if($filas_resultado_ya_existe > 0){
                            //SI YA ESTA REGISTRADO
                            $query_actualizar_existencia = "UPDATE productos_almacen SET costop_producto=(cantidad_producto*costop_producto+'$cantidad'*'$precio')/(cantidad_producto+'$cantidad'),
                            cantidad_producto = cantidad_producto+'$cantidad'
                            WHERE id_almacen = '$almacen_entrada' and id_producto = '$producto'";
                            mysqli_query($conn,$query_actualizar_existencia);
                        }else{
                            //SI NO ESTA REGISTRADO
                            $query_obtener_lugar = "SELECT max(lugar) FROM productos_almacen WHERE id_almacen = '$almacen_entrada'";
                            $resultado_obtener_lugar = mysqli_query($conn,$query_obtener_lugar);

                            if(empty($resultado_obtener_lugar)){
                                $lugar = 1;
                            }else{
                                $resultado_lugar = mysqli_fetch_row($resultado_obtener_lugar);
                                $lugar = $resultado_lugar[0] + 1;
                            }

                            $query_nueva_existencia = "INSERT INTO productos_almacen(id_almacen,lugar,id_producto,cantidad_producto,costop_producto)
                            VALUES ('$almacen_entrada','$lugar','$producto','$cantidad','$precio')";
                            mysqli_query($conn,$query_nueva_existencia);
                        }





                    }
                }
                
            }else{
                $mensaje = 'Por favor, seleccione almacenes diferentes.';
                $tipo = 'alert-danger';
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
    <title>Nuevo traslado</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos_login.css">

    <script>
        function ValidaTraslado(){
            var cantidad_producto = document.forms["traslado_form"]["cantidad_producto"].value;            
            
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
        <h1 class="text-center">Nuevo traslado</h1>
    </div>


    <!--NAVEGACION-->
    <?php require_once("navegacion.php"); ?>

    <div class="container">
    
        <div class="row justify-content-center bg-dark text-light p-3 mb-3">
            <div class="col-12 mb-2">
                <h3 class="text-center">
                    Seleccione Almacen de salida:
                </h3>
            </div>
            <form action="" method="POST" id="traslado_form" onsubmit="return ValidaTraslado()">
                <div class="col-12 mb-2">
                
                    <select name="select_almacen_salida" class="custom-select mb-3">
                        <option value="" selected disabled>-Selecciona Almacen-</option>
                            <?php while($row = mysqli_fetch_array($resultado_get_almacenes)){ ?>
                                        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                            <?php } ?>
                    </select>                                    
                </div>
                <div class="col-12 mb-2">
                    <h3 class="text-center">
                        Seleccione Almacen de entrada:
                    </h3>
                </div>
                <div class="col-12 mb-2">
                
                    <select name="select_almacen_entrada" class="custom-select mb-3">
                        <option value="" selected disabled>-Selecciona Almacen-</option>
                            <?php while($row = mysqli_fetch_array($resultado_get_almacenes_2)){ ?>
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
                    <select name="select_producto" class="custom-select mb-3">
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
                    <button type="submit" class="btn btn-primary" name="traslado_continuar">Continuar</button>
                </div>
                                                       
            </form>
        </div>

        <?php if(isset($_POST['traslado_continuar'])){ ?>
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