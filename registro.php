<?php
include "conexion.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $rol_id = $_POST['rol_id'];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (nombre, correo, password, rol_id) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $correo, $passwordHash, $rol_id);

    if($stmt->execute()){

        echo "<script>alert('Usuario registrado correctamente'); window.location='login.php';</script>";

    } else {
        echo "Error al registrar: " . $conexion->error;
    }
}
?>
<h2>Registrar Usuario</h2>

<form method="post">
    <input type="text" name="nombre" placeholder="Nombre completo" required><br><br>
    <input type="email" name="correo" placeholder="Correo electrónico" required><br><br>
    <input type="password" name="password" placeholder="Contraseña" required><br><br>

    <label>Seleccionar rol:</label><br>
    <select name="rol_id" required>
        <option value="">Seleccione un rol</option>
        <option value="1">Administrador</option>
        <option value="3">Estudiante</option>
    </select>
    <br><br>
    <button type="submit">Registrar</button>
</form>
