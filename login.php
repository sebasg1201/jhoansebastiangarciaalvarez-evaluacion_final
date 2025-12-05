<?php 
session_start();
include "conexion.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $correo = $_POST['correo'];
    $pass = $_POST['password'];

    $sql = "SELECT u.id, u.nombre, u.correo, u.password, u.rol_id, r.nombre_rol 
            FROM usuario u
            INNER JOIN rol r ON u.rol_id = r.id
            WHERE u.correo = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();

        if(password_verify($pass, $user['password'])){

            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['nombre']     = $user['nombre'];
            $_SESSION['rol']        = $user['nombre_rol'];
            if($user['nombre_rol'] == 'admin'){
                header("Location: panel.php");
                exit();
            }
            if($user['nombre_rol'] == 'estudiante'){
                header("Location: estudiante_panel.php");
                exit();
            }
            echo "Rol no reconocido.";
        } 
        else {
            echo "Contraseña incorrecta";
        }
    } 
    else {
        echo "Usuario no existente";
    }
}
?>
<form action="" method="post">
    <input type="email" name="correo" placeholder="correo" required>
    <input type="password" name="password" placeholder="contraseña" required>
    <button type="submit">Ingresar</button>
    <a href="registro.php">registrar</a>
</form>
