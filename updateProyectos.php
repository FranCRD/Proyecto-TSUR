<?php
include("conexion.php");

// Verificar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido";
    exit();
}

// Recibir datos
$id = $_POST['id'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';

if (empty($id) || empty($titulo) || empty($descripcion)) {
    echo "Faltan datos";
    exit();
}

// Obtener imagen actual
$sql_img = "SELECT proyectos FROM proyectos WHERE idproyectos = $id";
$resultado = $conexion->query($sql_img);

if ($resultado->num_rows === 0) {
    echo "Proyecto no encontrado";
    exit();
}

$datos = $resultado->fetch_assoc();
$imagen_actual = $datos['proyectos'];

// Manejar imagen nueva
if (isset($_FILES['imagenes']) && $_FILES['imagenes']['error'] === UPLOAD_ERR_OK) {

    $nombre = $_FILES['imagenes']['name'];
    $tmp = $_FILES['imagenes']['tmp_name'];
    $ruta_nueva = "proyectos_img/" . basename($nombre);

    if (!move_uploaded_file($tmp, $ruta_nueva)) {
        echo "Error al subir la imagen";
        exit();
    }

} else {
    // Si no envían imagen, usamos la existente
    $ruta_nueva = $imagen_actual;
}

// UPDATE
$sql_update = "UPDATE proyectos 
               SET titulo_proyectos = '$titulo',
                   proyectos = '$ruta_nueva',
                   descripcion_proyectos = '$descripcion'
               WHERE idproyectos = $id";

if ($conexion->query($sql_update) === TRUE) {
    echo "ok"; // respuesta que tu AJAX espera
} else {
    echo "Error al actualizar: " . $conexion->error;
}

$conexion->close();
?>

