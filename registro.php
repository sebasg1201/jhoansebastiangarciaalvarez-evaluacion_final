<?php
include "conexion.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    
    $sql = "INSERT INTO usuario (nombre, correo, password, rol) VALUES (?,?,?, 'admin')";
    $stmt = $conexion->prepare($sql);

    
    $stmt->bind_param("sss", $nombre, $correo, $passwordHash);
    
    if($stmt->execute()){
        echo "<script>alert('Usuario registrado correctamente'); window.location='login.php';</script>";
    } else {
        echo "Error al registrar: " . $conexion->error;
    }
}
?>

<h2>Registro administradores</h2>
<form method="post">
    <input type="text" name="nombre" placeholder="Nombre" required><br><br>
    <input type="email" name="correo" placeholder="Correo" required><br><br>
    <input type="password" name="password" placeholder="Contraseña" required><br><br>
    <button type="submit">crear usuario</button>
</form>
