<?php


require_once("conexion.php");

session_start();


if($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
    header("location: index.php");
}


$query_select_almacenes = "SELECT id_almacen,nombre_almacen FROM almacenes";
$resultado_select_almacen = mysqli_query($conn,$query_select_almacenes);
$query_select_productos = "SELECT * FROM productos";
$resultado_select_productos = mysqli_query($conn,$query_select_productos);
$resultado_select_almacen_2 = mysqli_query($conn,$query_select_almacenes);
$query_select_all_productos = "SELECT * FROM productos";
//1
$resultado_tabla_all_productos = mysqli_query($conn,$query_select_all_productos);
$filas1 = mysqli_num_rows($resultado_tabla_all_productos);
//fin

//4
$query_select_todo_entradas = "SELECT nombre_almacen,Lugar,nombre_producto,cantidad_producto,costop_producto
FROM productos_almacen pa,productos p ,almacenes a
WHERE (a.id_almacen = pa.id_almacen) AND (p.id_producto = pa.id_producto) ORDER BY pa.id_almacen,lugar";
$resultado_select_todo_entradas = mysqli_query($conn,$query_select_todo_entradas);
$filas4 = mysqli_num_rows($resultado_select_todo_entradas);
//fin


if(isset($_POST['Continuar_2'])){
    if(!empty($_POST['select_almacen'])){
        //2
        $var_almacen = $_POST['select_almacen'];
        $query_select_almacen_todo_productos = "SELECT nombre_almacen,Lugar,nombre_producto,cantidad_producto,costop_producto
        FROM productos_almacen pa,productos p ,almacenes a
        WHERE pa.id_almacen = '$var_almacen' AND (a.id_almacen = pa.id_almacen) AND (p.id_producto = pa.id_producto)";
        $resultado_tabla_almacen_todo_productos = mysqli_query($conn,$query_select_almacen_todo_productos);
        $filas2 = mysqli_num_rows($resultado_tabla_almacen_todo_productos);
        //fin
    }
}

if(isset($_POST['Continuar_3'])){
    if(!empty($_POST['select_almacen_2']) && !empty($_POST['select_producto'])){
        //3
        $var_almacen2 = $_POST['select_almacen_2'];
        $var_producto = $_POST['select_producto'];
        $query_select_todo_almacen_todo_productos = "SELECT nombre_almacen,Lugar,nombre_producto,cantidad_producto,costop_producto
        FROM productos_almacen pa,productos p ,almacenes a
        WHERE pa.id_almacen = '$var_almacen2' AND pa.id_producto = '$var_producto' AND (a.id_almacen = pa.id_almacen) AND (p.id_producto = pa.id_producto)";
        $resultado_tabla_todo_almacen_todo_productos = mysqli_query($conn,$query_select_todo_almacen_todo_productos);
        $filas3 = mysqli_num_rows($resultado_tabla_todo_almacen_todo_productos);
        //fin
    }
}



?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consulta productos</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos_login.css">

</head>
<body>
    
    <div class="jumbotron mb-0 p-4" >
        <a href="index.php">Cerrar sesion</a>
        <p> <?php echo "Usuario: " . $_SESSION['usuario'] ?> </p>
        <h1 class="text-center">Consulta productos</h1>
    </div>

    <!--NAVBAR-->
    <?php require_once("navegacion.php"); ?>

    <!--FORMULARIOS-->
    <div class="container">
        
        <!--MOSTRAR TODOS LOS PRODUCTOS REGISTRADOS-->
        <div class="row">
                <div class="col-12 col-md-6 text-center  mb-3">
                <!--MOSTRAR TODOS LOS PRODUCTOS REGISTRADOS-->
                    <form action="" method="POST">
                        <button type="submit" class="btn btn-secondary" name="Continuar_1">Mostrar todos los productos registrados</button>
                    </form>                
                </div>
            


                
            
                <div class="col-12 col-md-6 text-center  mb-3">
                <!--MOSTRAR TODO-->
                    <form action="" method="POST">
                        <button type="submit" class="btn btn-secondary" name="Continuar_4">Mostrar todos los productos en almacenes</button>
                    </form>                
                </div>
        </div>


        <div class="row mb-3 justify-content-center bg-dark text-light p-2">
            <div class="col-12">
                <h3 class="text-center">Mostrar todos los productos de almacen:</h3>
            </div>

            <!--MOSTRAR TODOS LOS PRODUCTOS DE ALMACEN-->
            <form action="" method="POST">
                <div class="col-12">


                    <select class="custom-select mb-3" name="select_almacen">
                        <option value=""  selected disabled>-Selecciona Almacen-</option>
                        <?php while($row = mysqli_fetch_array($resultado_select_almacen)){ ?>
                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                        <?php }  ?>
                    </select>


                </div>
                

                <div class="col-12 text-center">

                    <button type="submit" class="btn btn-primary" name="Continuar_2">Continuar</button>

                </div>

                
            </form>
            
        </div>


        <!--VALIDACIONES Y PRUEBAS-->
        <?php
        
        if(isset($_POST['Continuar_2'])){
            if(empty($_POST['select_almacen'])){ ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Por favor, seleccione un almacen.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            <?php } 
                                          
        }                    
                         
        ?>

        <!--MOSTRAR PRODUCTO DETERMINADO EL ALMACEN DETERMINADO-->
        <div class="row mb-3 justify-content-center bg-dark text-light p-2">
            <div class="col-12">
                <h3 class="text-center">Mostrar determinado producto en determinado almacen.</h3>
            </div>
            <form action="" method="POST">

                <div class="col-12">
                    <select class="custom-select mb-3" name="select_almacen_2">
                        <option value=""  selected disabled>-Selecciona Almacen-</option>
                        <?php while($row = mysqli_fetch_array($resultado_select_almacen_2)){ ?>
                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                        <?php }  ?>
                    </select>
                </div>

                <div class="col-12">
                    <select class="custom-select mb-3" name="select_producto">
                        <option value=""  selected disabled>-Selecciona producto-</option>
                        <?php while($row = mysqli_fetch_array($resultado_select_productos)){ ?>
                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                        <?php }  ?>
                    </select>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary" name="Continuar_3">Continuar</button>
                </div>

            </form>

            

        </div>

        <!--VALIDACIONES-->
        <?php
        
        if(isset($_POST['Continuar_3'])){
            if(empty($_POST['select_almacen_2'])){ ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Por favor, seleccione un almacen.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            <?php } 
                
                
                        
            if(empty($_POST['select_producto'])){ ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Por favor, seleccione un producto.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            <?php } 

        }
                        
        ?>



        

        <!--TABLAS DE RESULTADOS-->
        
        
            <?php if(isset($_POST['Continuar_1'])){ ?>
                <?php if($filas1 > 0){ ?>


            <!--TABLA-->

            <div class="table-responsive">
            <table class="table table-striped table-bordered">

            <thead class="thead-dark">
                <tr>
                <th scope="col">Id</th>
                <th scope="col">Producto</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            while($row = $resultado_tabla_all_productos->fetch_assoc()) { ?>
                <tr>
                    <th scope="row"><?php echo $row['id_producto']; ?></th>
                    <td><?php echo $row['nombre_producto']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
            </table>
            </div>
            <?php }else{ ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        No hay registros
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
            
            <?php } ?>
            
            <?php if(isset($_POST['Continuar_2']) && !empty($_POST['select_almacen'])){ ?>
                <?php if($filas2 > 0){ ?>

            <!--TABLA-->
            <div class="table-responsive">
            <table class="table table-striped table-bordered">

                <thead class="thead-dark">
                    <tr>
                    <th scope="col">Almacen</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Costo promedio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = $resultado_tabla_almacen_todo_productos->fetch_assoc()){ ?>
                        <tr>
                            <th scope="row"> <?php echo $row['nombre_almacen']; ?> </th>
                            <th scope="row"> <?php echo $row['Lugar']; ?> </th>
                            <th scope="row"> <?php echo $row['nombre_producto']; ?> </th>
                            <td><?php echo $row['cantidad_producto']; ?></td>
                            <td> <?php echo $row['costop_producto']; ?> </td>
                        </tr>
                    <?php } ?>
                </tbody>
                </table>
                </div>
                    <?php }else{ ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        No hay registros
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    <?php } ?>
                    
            <?php } ?>
            
            <?php if(isset($_POST['Continuar_3']) && !empty($_POST['select_almacen_2']) && !empty($_POST['select_producto'])){ ?>
                <?php if($filas3 > 0){ ?>

                <!--TABLA-->
                <div class="table-responsive">
                <table class="table table-striped table-bordered">

                <thead class="thead-dark">
                    <tr>
                    <th scope="col">Almacen</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Costo promedio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = $resultado_tabla_todo_almacen_todo_productos->fetch_assoc()){ ?>
                    <tr>
                        <th scope="row"> <?php echo $row['nombre_almacen']; ?> </th>
                        <th scope="row"> <?php echo $row['Lugar']; ?> </th>
                        <th scope="row"> <?php echo $row['nombre_producto']; ?> </th>
                        <td><?php echo $row['cantidad_producto']; ?></td>
                        <td> <?php echo $row['costop_producto']; ?> </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
                </div>
                    <?php }else{ ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        No hay registros
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    <?php } ?>
                    
                    <?php } ?>
                    
            <?php if(isset($_POST['Continuar_4'])){ ?>

                <?php if($filas4 > 0){ ?>

                    <div class="table-responsive">
                <table class="table table-striped table-bordered">

                <thead class="thead-dark">
                    <tr>
                    <th scope="col">Almacen</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Costo promedio</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
                    while($row = $resultado_select_todo_entradas->fetch_assoc()){ ?>
                    <tr>
                        <th scope="row"> <?php echo $row['nombre_almacen']; ?> </th>
                        <th scope="row"> <?php echo $row['Lugar']; ?> </th>
                        <th scope="row"> <?php echo $row['nombre_producto']; ?> </th>
                        <td><?php echo $row['cantidad_producto']; ?></td>
                        <td> <?php echo $row['costop_producto']; ?> </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
                </div>
                <?php }else{ ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        No hay registros
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>          
                    <?php } ?>
                    
                <?php } ?>
                
        


       



    </div>


    <!--SCRIPTS DE JAVASCRIPT DE BOOTSTRAP-->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>