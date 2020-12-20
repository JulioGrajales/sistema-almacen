<?php
    require_once("conexion.php");

    session_start();
    if($_SESSION['usuario'] == null || $_SESSION['usuario'] == ''){
        header("location: index.php");
    }

    $query_get_almacenes = "SELECT * FROM almacenes";
    $resultado_get_almacenes = mysqli_query($conn,$query_get_almacenes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consultar almacenes</title>

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos_login.css">

</head>
<body>
    <!--TITULAR-->
    <div class="jumbotron mb-0 p-4" >
        <a href="index.php">Cerrar sesion</a>
        <p> <?php echo "Usuario: " . $_SESSION['usuario'] ?> </p>
        <h1 class="text-center">Consultar almacenes</h1>
    </div>

    <!--NAVEGACION-->
    <?php require_once("navegacion.php"); ?>

    <div class="container">

        <div class="table-responsive">


        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Almacen</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Codigo postal</th>
                </tr>            
            </thead>
            <tbody>
            <?php while($row = mysqli_fetch_array($resultado_get_almacenes)){ ?>
                        <tr>
                            <th scope="row"> <?php echo $row[0]; ?> </th>
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo $row[2]; ?></td>
                            <td><?php echo $row[3]; ?></td>
                            <td><?php echo $row[4]; ?></td>
                        </tr>
            <?php } ?>
            </tbody>
        </table>

        </div>


    </div>
    

    <!--SCRIPTS DE JAVASCRIPT DE BOOTSTRAP-->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>