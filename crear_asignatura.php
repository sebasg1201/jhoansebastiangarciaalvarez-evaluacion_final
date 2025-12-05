<?php
include "conexion.php";

if($_POST){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO asignaturas(nombre, descripcion) values ('$nombre','$descripcion')";
    $conexion->query($sql);
    echo "Asignatura creada!";
}
?>
<form action="" method="post">
    <input name="nombre" placeholder="Nombre asignatura">
    <input name="descripcion" placeholder="Descripcion">
    <button type="submit">guardar</button>
</form>
<a href="panel.php">Volver</a>
