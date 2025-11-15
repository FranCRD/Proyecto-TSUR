<?php
session_start(); // Inicia la sesión para poder manipularla

session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirige al usuario al login o página principal
header("Location: login.php");
exit();
?>