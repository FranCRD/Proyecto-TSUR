<?php
session_start();
include("conexion.php");

$mensaje_error = ""; // Variable para almacenar el mensaje de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre' AND password = '$contrasena'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $_SESSION['nombre_usuario'] = $nombre;
        header("Location: index.php");
        exit();
    } else {
        // Si los datos no coinciden, guardamos un mensaje genérico
        header("Location: login.php?error=1");

    }
} 
?>