<?php
include ("conexion.php");
// Verificamos que se haya enviado el ID
if (isset($_POST["id"])) {
    $id_proyecto = intval($_POST["id"]);

    // Consulta para eliminar el registro
    $sql = "DELETE FROM proyectos WHERE idproyectos = $id_proyecto";

    if ($conexion->query($sql) === TRUE) {
        // Redirigir a main.php si se eliminó correctamente
        header("Location: proyectos.php");
        exit();
    } else {
        echo " Error al eliminar: " . $conexion->error;
    }
} else {
    echo "No se recibió el ID para eliminar.";
}

$conexion->close();
?>
