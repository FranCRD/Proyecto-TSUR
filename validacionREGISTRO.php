<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $apellido_usuario = $_POST['apellido_usuario'];
    $telefono_usuario = $_POST['telefono_usuario'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Verificar si las contraseñas coinciden
    if ($contrasena !== $confirmar_contrasena) {
        header("Location: registro.php?error=1"); //si no coinciden las contraseñas dara error
        exit();
    }

    // Verificar si el usuario ya existe
    $sql_check = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
    $resultado_check = $conexion->query($sql_check);

    if ($resultado_check->num_rows > 0) {
        header("Location: registro.php?error=2");
        exit();
    }


    // Insertar nuevo usuario
    $sql = "INSERT INTO usuarios (nombre_usuario, apellido_usuario, telefono_usuario, email_usuario, password) 
            VALUES ('$nombre_usuario', '$apellido_usuario', '$telefono_usuario', '$email', '$contrasena')";
    
    if ($conexion->query($sql)) {
        // Registro exitoso, redirigir al login
        header("Location: login.php?registro=1");
        exit();
    } else {
        header("Location: registro.php?error=3");
        exit();
    }
}
?>