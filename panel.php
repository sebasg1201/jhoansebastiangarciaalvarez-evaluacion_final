<?php
session_start();

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin'){
    header("location: login.php");
    exit();
}
?>
<h2>Bienvenido Administrador: <?php echo $_SESSION['nombre']; ?></h2>
<br><br>
<a href="crear_estudiante.php">Registrar alumno</a> |
<a href="crear_asignatura.php">Registrar asignatura</a> |
<a href="registrar_nota.php">Registrar notas</a> |
<a href="ver_nota.php">Ver notas</a> |
<a href="logout.php">Cerrar sesión</a>
