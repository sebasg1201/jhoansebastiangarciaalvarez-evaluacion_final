<?php
session_start();

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante'){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
    <p>Selecciona una opción:</p>
    <a href="ver_nota.php">Ver mis notas</a><br><br>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
