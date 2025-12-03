<?php
include "conexion.php";

$estudiantes = $conexion->query("SELECT * FROM estudiante");
$asignaturas = $conexion->query("SELECT * FROM asignaturas");

if ($_POST){
    $estudiante = $_POST['estudiante'];
    $asignatura = $_POST['asignatura'];
    $nota = $_POST['nota'];
    
    $sql = "INSERT INTO notas (estudiante_id, asignatura_id, nota) 
            VALUES ('$estudiante','$asignatura','$nota')";
    $conexion->query($sql);

    echo "<script>alert('Nota registrada correctamente');</script>";
}
?>
<form action="" method="post">
    Estudiante:
    <select name="estudiante" required>
        <?php while($e = $estudiantes->fetch_assoc()){?>
            <option value="<?= $e['id'] ?>"><?= $e['nombre'] ?> <?= $e['apellido'] ?></option>
        <?php } ?>
    </select>

    Asignatura:
    <select name="asignatura" required>
        <?php while($a = $asignaturas->fetch_assoc()){?>
            <option value="<?= $a['id'] ?>"><?= $a['nombre'] ?></option>
        <?php } ?>
    </select>

    <input name="nota" placeholder="Nota (0-5)" type="number" step="0.1" required>

    <button type="submit">Guardar</button>
</form>
