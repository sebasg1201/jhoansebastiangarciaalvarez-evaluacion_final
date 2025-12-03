<?php
    $hostname = "127.0.0.1";
    $database = "sistema_notas"; 
    $username = "root";
    $password = "";
    $charset = "utf8";

    $conexion = new mysqli($hostname, $username, $password,$database);

    if ($conexion->connect_errno){
        die("error de conexion".$conexion->connect_error);
    }
?>
