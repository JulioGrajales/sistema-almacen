<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "empresa_almacenes";

    $conn = mysqli_connect($servername, $username, $password,$db_name);
    if (!$conn) {
        die("Conexion fallida: ". mysqli_connect_error());
    }
?>