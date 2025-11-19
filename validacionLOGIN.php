<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    //Consulta solo por nombre usando sentencia preparada para evitar inyecciones SQL
    $sql = $conexion->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
    $sql->bind_param("s", $nombre);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows > 0) {

        $usuario = $resultado->fetch_assoc();
        //Verificar la contraseña encriptada
        if (password_verify($contrasena, $usuario['password'])) {
        $_SESSION['nombre_usuario'] = $nombre;

        //Si es admin
        if (isset($usuario['es_admin'])) {
            $_SESSION['es_admin'] = $usuario['es_admin'];
        }

        header("Location: index.php");
        exit();
     }
} 
    // Si no coincide el usuario o la contraseña
    header("Location: login.php?error=1");
    exit();
}
?>
