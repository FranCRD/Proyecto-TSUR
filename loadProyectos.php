<?php
include("conexion.php");

$sql = "SELECT idproyectos, titulo_proyectos, proyectos, descripcion_proyectos 
        FROM proyectos 
        ORDER BY idproyectos DESC";

$result = $conexion->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "
        <li class='card'>
            <h3>" . htmlspecialchars($row['titulo_proyectos']) . "</h3>
            <img src='" . htmlspecialchars($row['proyectos']) . "'>
            <p>" . htmlspecialchars($row['descripcion_proyectos']) . "</p>
        </li>
    ";
}
?>
