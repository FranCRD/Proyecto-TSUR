<?php
include("conexion.php");

// datos del form
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];

$nombre_imagen = $_FILES['imagenes']['name'];
$ruta_temporal = $_FILES['imagenes']['tmp_name'];
$ruta_destino = "proyectos_img/" . basename($nombre_imagen);

if (move_uploaded_file($ruta_temporal, $ruta_destino)) {

    $sql = "INSERT INTO proyectos (titulo_proyectos, proyectos, descripcion_proyectos) 
            VALUES ('$titulo', '$ruta_destino', '$descripcion')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: proyectos.php");
        exit();
    } else {
        echo "Error al insertar: " . $conexion->error;
    }

} else {
    echo "Error al subir la imagen.";
}

?>