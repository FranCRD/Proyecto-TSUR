<?php
include("conexion.php");

// Comprobar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método no permitido";
    exit();
}

// datos del form
$titulo = $_POST['titulo'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';

if (empty($titulo) || empty($descripcion)) {
    echo "Faltan datos";
    exit();
}

// Verificar que llegó el archivo
if (!isset($_FILES['imagenes']) || $_FILES['imagenes']['error'] !== UPLOAD_ERR_OK) {
    echo "Error al recibir la imagen";
    exit();
}

$nombre_imagen = $_FILES['imagenes']['name'];
$ruta_temporal = $_FILES['imagenes']['tmp_name'];
$ruta_destino = "proyectos_img/" . basename($nombre_imagen);

if (move_uploaded_file($ruta_temporal, $ruta_destino)) {

    $sql = "INSERT INTO proyectos (titulo_proyectos, proyectos, descripcion_proyectos) 
            VALUES ('$titulo', '$ruta_destino', '$descripcion')";

    if ($conexion->query($sql) === TRUE) {
        echo "ok";  // Esto es lo que revisa el JS
    } else {
        echo "Error al insertar: " . $conexion->error;
    }

} else {
    echo "Error al subir la imagen.";
}

$conexion->close();
?>
