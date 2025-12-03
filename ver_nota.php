<?php
include "conexion.php";

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
