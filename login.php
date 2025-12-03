<?php
session_start();
include "conexion.php";

if($_POST){
    $correo = $_POST['correo'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE correo = '$correo'";
    $result = $conexion->query($sql);
    
    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($pass, $user['password'])){
            $_SESSION['admin'] = $user['nombre'];
            header("location: panel.php");
            exit(); 
        }else{
            echo "Contraseña incorrecta";
        }
    }else{
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
