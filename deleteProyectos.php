<?php
include_once("conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido";
    exit();
}

if (!isset($_POST["id"]) || empty($_POST["id"])) {
    echo "No se recibió ID";
    exit();
}

$id = intval($_POST["id"]);

$sql = "DELETE FROM proyectos WHERE idproyectos = $id";

if ($conexion->query($sql) === TRUE) {
    echo "ok";
} else {
    echo "Error al eliminar: " . $conexion->error;
}
$conexion->close();
?>
