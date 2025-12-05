<?php
session_start();
include "conexion.php";

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin'){
    header("Location: login.php");
    exit();
}

$estudiantes = $conexion->query("
    SELECT e.id, e.nombre, e.apellido, u.correo 
    FROM estudiante e
    INNER JOIN usuario u ON e.usuario_id = u.id
");
$asignaturas = $conexion->query("SELECT * FROM asignaturas");

if ($_POST){
    $estudiante = $_POST['estudiante'];
    $asignatura = $_POST['asignatura'];
    $nota       = $_POST['nota'];

    if($nota < 0 || $nota > 5){
        echo "<script>alert('La nota debe estar entre 0.0 y 5.0');</script>";
    } else {

        $check = $conexion->prepare("
        SELECT id FROM notas WHERE estudiante_id = ? AND asignatura_id = ?");
        $check->bind_param("ii", $estudiante, $asignatura);
        $check->execute();
        $resultCheck = $check->get_result();

        if($resultCheck->num_rows > 0){
            echo "<script>alert('Este estudiante ya tiene una nota registrada para esta asignatura.');</script>";
        } else {

            $sql = "INSERT INTO notas (estudiante_id, asignatura_id, nota) VALUES (?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("iid", $estudiante, $asignatura, $nota);

            if($stmt->execute()){
                echo "<script>alert('Nota registrada correctamente');</script>";
            } else {
                echo "Error: " . $conexion->error;
            }
        }
    }
}
?>
<h2>Registrar Nota</h2>
<form action="" method="post">

    <label>Estudiante:</label><br>
    <select name="estudiante" required>
        <?php while($e = $estudiantes->fetch_assoc()){ ?>
            <option value="<?= $e['id'] ?>">
                <?= $e['nombre'] ?> <?= $e['apellido'] ?> (<?= $e['correo'] ?>)
            </option>
        <?php } ?>
    </select>

    <label>Asignatura:</label><br>
    <select name="asignatura" required>
        <?php while($a = $asignaturas->fetch_assoc()){ ?>
            <option value="<?= $a['id'] ?>"><?= $a['nombre'] ?></option>
        <?php } ?>
    </select>

    <label>Nota (0.0 - 5.0):</label><br>
    <input name="nota" type="number" step="0.1" min="0" max="5" required>
    
    <button type="submit">Guardar Nota</button>
</form>
