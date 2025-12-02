<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre_usuario   = $_POST['nombre_usuario'];
    $apellido_usuario = $_POST['apellido_usuario'];
    $telefono_usuario = $_POST['telefono_usuario'];
    $email_usuario    = trim($_POST['email_usuario']);
    $password_usuario = $_POST['password_usuario'];
    $confirmar_password = $_POST['confirmar_password'];

    // FOTO ACTUAL
    $fotoPerfilRuta = isset($_SESSION['foto_perfil']) ? $_SESSION['foto_perfil'] : null;

    // ¿Se quiere quitar la foto?
    $quitarFoto = isset($_POST['quitar_foto']) && $_POST['quitar_foto'] == '1';

    // ¿Hay nueva foto subida?
    $hayFoto = (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0);

    // SIN CAMBIOS
    $sinCambios =
        $nombre_usuario === $_SESSION['nombre_usuario'] &&
        $apellido_usuario === $_SESSION['apellido_usuario'] &&
        $telefono_usuario === $_SESSION['telefono_usuario'] &&
        $email_usuario === $_SESSION['email_usuario'] &&
        empty($password_usuario) &&
        !$hayFoto &&
        empty($_POST['foto_perfil_final']) &&
        !$quitarFoto; 

    if ($sinCambios) {
        header("Location: editarPerfil.php?error=1");
        exit();
    }

    // CONTRASEÑAS
    if (!empty($password_usuario) && $password_usuario !== $confirmar_password) {
        header("Location: editarPerfil.php?error=2");
        exit();
    }

    // EMAIL
    if (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
        header("Location: editarPerfil.php?error=3");
        exit();
    }


    // SI SE QUIERE QUITAR FOTO → asignar default y saltar procesamiento
    if ($quitarFoto) {

        // Eliminar foto anterior si existía y no era default
        if (
            $_SESSION['foto_perfil'] !== "fotos_perfil/default.png" &&
            file_exists($_SESSION['foto_perfil'])
        ) {
            unlink($_SESSION['foto_perfil']);
        }

        // Asignar foto default
        $fotoPerfilRuta = "fotos_perfil/default.png";

        // Ignorar recorte y subida
        $_POST['foto_perfil_final'] = "";
        $hayFoto = false;

    } else {

    // FOTO RECORTADA
    if (!empty($_POST['foto_perfil_final'])) {

        $imgBase64 = $_POST['foto_perfil_final'];
        $imgBase64 = str_replace('data:image/png;base64,', '', $imgBase64);
        $imgBase64 = base64_decode($imgBase64);

        $ruta = 'fotos_perfil/perfil_' . uniqid() . '.png';
        file_put_contents($ruta, $imgBase64);

        $fotoPerfilRuta = $ruta;

    } else if ($hayFoto) {

        // FOTO SIN RECORTE (archivo normal)
        $directorioDestino = 'fotos_perfil/';

        if (!file_exists($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }

        $nombreTemp = $_FILES['foto_perfil']['tmp_name'];
        $nombreArchivo = basename($_FILES['foto_perfil']['name']);
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

        $extPermitidas = ["jpg", "jpeg", "png", "webp"];

        if (!in_array($extension, $extPermitidas)) {
            header("Location: editarPerfil.php?error=5");
            exit();
        }

        $nuevoNombre = "perfil_" . uniqid() . "." . $extension;
        $destino = $directorioDestino . $nuevoNombre;

        if (move_uploaded_file($nombreTemp, $destino)) {
            $fotoPerfilRuta = $destino;
        } else {
            header("Location: editarPerfil.php?error=6");
            exit();
        }
    }
}

    //Si quiere quitar foto, ignoramos todo los demas de foto
    if (
        $fotoPerfilRuta !== $_SESSION['foto_perfil'] &&
        $_SESSION['foto_perfil'] !== "fotos_perfil/default.png" &&
        file_exists($_SESSION['foto_perfil'])
    ) {
        unlink($_SESSION['foto_perfil']);
    }

    // UPDATE
    $sql_update = "UPDATE usuarios SET
        nombre_usuario = '$nombre_usuario',
        apellido_usuario = '$apellido_usuario',
        telefono_usuario = '$telefono_usuario',
        email_usuario = '$email_usuario',
        foto_perfil = '$fotoPerfilRuta'";

    if (!empty($password_usuario)) {
        $password_hash = password_hash($password_usuario, PASSWORD_DEFAULT);
        $sql_update .= ", password = '$password_hash'";
    }

    // WHERE del UPDATE
    $sql_update .= " WHERE id_usuario = " . intval($_SESSION['id_usuario']);

    // Ejecutar UPDATE
    if ($conexion->query($sql_update) === TRUE) {

        $_SESSION['nombre_usuario'] = $nombre_usuario;
        $_SESSION['apellido_usuario'] = $apellido_usuario;
        $_SESSION['telefono_usuario'] = $telefono_usuario;
        $_SESSION['email_usuario'] = $email_usuario;
        $_SESSION['foto_perfil'] = $fotoPerfilRuta;

        header("Location: index.php?update=1");
        exit();

    } else {
        header("Location: editarPerfil.php?error=4");
        exit();
    }
}

$conexion->close();
?>

