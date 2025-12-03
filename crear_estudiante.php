<?php
include "conexion.php";

if($_POST){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento = $_POST['documento'];

    $sql = "INSERT INTO estudiante(nombre, apellido, documento) VALUES ('$nombre','$apellido','$documento')";
    $conexion->query($sql);  
    echo "Alumno registrado!";
}
?>
<form action="" method="post">
    <input name="nombre" placeholder="Nombre" required>
    <input name="apellido" placeholder="Apellido" required>
    <input name="documento" placeholder="Documento" required>
    <button type="submit">Guardar</button>
</form>
