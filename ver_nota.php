<?php 
session_start();
include "conexion.php";

if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'estudiante') {

    $usuario_id = $_SESSION['usuario_id'];

    // Obtener ID del estudiante enlazado al usuario
    $sqlEst = "SELECT id FROM estudiante WHERE usuario_id = ?";
    $stmtEst = $conexion->prepare($sqlEst);
    $stmtEst->bind_param("i", $usuario_id);
    $stmtEst->execute();
    $resEst = $stmtEst->get_result();

    if($resEst->num_rows > 0) {
        $est = $resEst->fetch_assoc();
        $estudiante_id = $est['id'];

        // Consulta SOLO para este estudiante
        $sql = "SELECT 
                    n.id,
                    e.nombre AS nombre_estudiante,
                    e.apellido AS apellido_estudiante,
                    a.nombre AS nombre_asignatura,
                    n.nota
                FROM notas n
                INNER JOIN estudiante e ON n.estudiante_id = e.id
                INNER JOIN asignaturas a ON n.asignatura_id = a.id
                WHERE n.estudiante_id = ?";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $estudiante_id);
        $stmt->execute();
        $result = $stmt->get_result();

    } else {
        die("No se encontró información del estudiante.");
    }

} else {
    
    $sql = "SELECT 
                n.id,
                e.nombre AS nombre_estudiante,
                e.apellido AS apellido_estudiante,
                a.nombre AS nombre_asignatura,
                n.nota
            FROM notas n
            INNER JOIN estudiante e ON n.estudiante_id = e.id
            INNER JOIN asignaturas a ON n.asignatura_id = a.id";

    $result = $conexion->query($sql);
}
echo "<h2>Notas</h2>";
echo "<table border='1'>
<tr>
<th>Alumno</th>
<th>Asignatura</th>
<th>Nota</th>
</tr>";

while ($row = $result->fetch_assoc()){
    echo "<tr>
        <td>{$row['nombre_estudiante']} {$row['apellido_estudiante']}</td>
        <td>{$row['nombre_asignatura']}</td>
        <td>{$row['nota']}</td>
    </tr>";
}

echo "</table>";
?>
