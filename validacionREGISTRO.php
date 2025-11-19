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
    $sql_check = "SELECT * FROM usuarios WHERE email_usuario = '$email'";
    $resultado_check = $conexion->query($sql_check);

    if ($resultado_check->num_rows > 0) {
        header("Location: registro.php?error=2"); //error si el correo ya esta registrado
        exit();
    }

    //Verificar que el email sea valido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: registro.php?error=4"); //error si el correo no es valido
        exit();
    }

    //Encriptar la contraseña
    $password_hash = password_hash($contrasena, PASSWORD_DEFAULT);


    // Insertar nuevo usuario con contraseña encriptada
    $sql = "INSERT INTO usuarios (nombre_usuario, apellido_usuario, telefono_usuario, email_usuario, password) 
            VALUES ('$nombre_usuario', '$apellido_usuario', '$telefono_usuario', '$email', '$password_hash')";
    
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
