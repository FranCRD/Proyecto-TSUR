<?php
include("conexion.php");

// Recibir datos del formulario
$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];

// Obtener la imagen actual por si NO suben una nueva
$sql_img = "SELECT proyectos FROM proyectos WHERE idproyectos = $id";
$resultado = $conexion->query($sql_img);

if ($resultado->num_rows == 0) {
    echo "Error: El proyecto con ese ID no existe.";
    exit();
}

$datos = $resultado->fetch_assoc();
$imagen_actual = $datos['proyectos'];

// Procesar imagen nueva (si la mandan)
$nueva_imagen = $_FILES['imagenes']['name'];

if (!empty($nueva_imagen)) {

    $ruta_temp = $_FILES['imagenes']['tmp_name'];
    $ruta_destino = "proyectos_img/" . basename($nueva_imagen);

    if (!move_uploaded_file($ruta_temp, $ruta_destino)) {
        echo "Error al subir la nueva imagen.";
        exit();
    }

} else {
    // Mantener la imagen actual
    $ruta_destino = $imagen_actual;
}

// UPDATE final
$sql_update = "UPDATE proyectos 
               SET titulo_proyectos = '$titulo',
                   proyectos = '$ruta_destino',
                   descripcion_proyectos = '$descripcion'
               WHERE idproyectos = $id";

if ($conexion->query($sql_update) === TRUE) {
    header("Location: proyectos.php");
    exit();
} else {
    echo "Error al actualizar: " . $conexion->error;
}

$conexion->close();
?>
