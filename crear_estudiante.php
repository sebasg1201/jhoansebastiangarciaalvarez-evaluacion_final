<?php
session_start();
include "conexion.php";

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin'){
    header("Location: login.php");
    exit();
}
if($_POST){

    $nombre     = $_POST['nombre'];
    $apellido   = $_POST['apellido'];
    $documento  = $_POST['documento'];
    $correo     = $_POST['correo'];
    $password   = $_POST['password'];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sqlUser = "INSERT INTO usuario (nombre, correo, password, rol_id) VALUES (?, ?, ?, 3)";
    $stmtUser = $conexion->prepare($sqlUser);
    $stmtUser->bind_param("sss", $nombre, $correo, $passwordHash);

    if($stmtUser->execute()){

        $usuario_id = $stmtUser->insert_id;

        $sqlEst = "INSERT INTO estudiante(nombre, apellido, documento, usuario_id) VALUES (?, ?, ?, ?)";
        $stmtEst = $conexion->prepare($sqlEst);
        $stmtEst->bind_param("sssi", $nombre, $apellido, $documento, $usuario_id);

        if($stmtEst->execute()){
            echo "<script>alert('Estudiante registrado correctamente'); window.location='panel.php';</script>";
        } else {
            echo "Error al registrar estudiante: " . $conexion->error;
        }

    } else {
        echo "Error al crear usuario: " . $conexion->error;
    }
}
?>
<h2>Registrar Estudiante</h2>
<form action="" method="post">
    <input name="nombre" placeholder="Nombre" required><br><br>
    <input name="apellido" placeholder="Apellido" required><br><br>
    <input name="documento" placeholder="Documento" required><br><br>
    <input type="email" name="correo" placeholder="Correo del estudiante" required><br><br>
    <input type="password" name="password" placeholder="Contraseña" required><br><br>
    <button type="submit">Guardar estudiante</button>
</form>
