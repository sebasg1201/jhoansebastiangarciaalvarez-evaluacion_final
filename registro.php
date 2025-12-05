<?php
include "conexion.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre    = $_POST['nombre'];
    $correo    = $_POST['correo'];
    $password  = $_POST['password'];
    $rol_id    = $_POST['rol_id'];

    $apellido  = $_POST['apellido'] ?? null;
    $documento = $_POST['documento'] ?? null;

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $checkCorreo = $conexion->prepare("SELECT id FROM usuario WHERE correo = ?");
    $checkCorreo->bind_param("s", $correo);
    $checkCorreo->execute();
    $resCorreo = $checkCorreo->get_result();

    if($resCorreo->num_rows > 0){
        echo "<script>alert('El correo ya está registrado'); window.history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO usuario (nombre, correo, password, rol_id) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $correo, $passwordHash, $rol_id);

    if($stmt->execute()){

        $usuario_id = $stmt->insert_id;

        if($rol_id == 3){

            if(empty($apellido) || empty($documento)){
                echo "<script>alert('Debe ingresar apellido y documento para registrar estudiantes'); window.history.back();</script>";
                exit();
            }

            $checkDoc = $conexion->prepare("SELECT id FROM estudiante WHERE documento = ?");
            $checkDoc->bind_param("s", $documento);
            $checkDoc->execute();
            $resDoc = $checkDoc->get_result();

            if($resDoc->num_rows > 0){
                echo "<script>alert('El documento ya está registrado'); window.history.back();</script>";
                exit();
            }

            $sqlEst = "INSERT INTO estudiante (nombre, apellido, documento, usuario_id) 
                       VALUES (?, ?, ?, ?)";
            $stmtEst = $conexion->prepare($sqlEst);
            $stmtEst->bind_param("sssi", $nombre, $apellido, $documento, $usuario_id);

            if(!$stmtEst->execute()){
                echo "Error al registrar estudiante: " . $conexion->error;
                exit();
            }
        }
        echo "<script>alert('Usuario registrado correctamente'); window.location='login.php';</script>";
    } 
    else {
        echo "Error al registrar: " . $conexion->error;
    }
}
?>
<h2>Registrar Usuario</h2>

<form method="post">
    <input type="text" name="nombre" placeholder="Nombre completo" required><br><br>
    <input type="text" name="apellido" placeholder="Apellido del estudiante"><br><br>
    <input type="text" name="documento" placeholder="Documento del estudiante"><br><br>
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
