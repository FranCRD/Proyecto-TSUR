<?php
session_start();
include "conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    <link rel="stylesheet" href="editarPerfil.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <title>Editar Perfil</title>
</head>
<body>
    <section id="editar-perfil" class="editar-perfil">
        <h2>Editar Perfil</h2>
        
        <div class="edita-perfil-contenedor">

        <!-- FORMULARIO -->
        <?php if (isset($_SESSION['nombre_usuario'])): ?>
            <form class="form-editar-perfil" method = "POST" enctype="multipart/form-data" action="validacionUpdate-Perfil.php">

                <div class="campo">
                    <label> Foto de Perfil</label><br>
                    <img id="fotoPerfilPreview" 
                    src="<?php echo htmlspecialchars($_SESSION['foto_perfil']); ?>"
                    style="width:120px; height:120px; object-fit:cover; border-radius:50%;"><br>
                </div>

                <div class="campo">
                    <label for="foto_perfil">Cambiar foto de perfil</label>
                    <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">
                </div>

                <button type="button" id="btnQuitarFoto" style="margin-botton:10px;">Quitar foto de perfil</button>
                <input type="hidden" name="quitar_foto" id="quitar_foto" value="0">

                <div id="modalCrop" style="display:none;">
                    <h3>Recortar Imagen</h3>
                    <div> 
                        <img id="imgCrop" style="max-width: 100%;">
                    </div>
                    <button id="cropBtn">Recortar y Guardar</button>
                </div>

                <input type="hidden" name="foto_perfil_final" id="foto_perfil_final">

                <div class="campo">
                    <label for="nombre_usuario">Nombre de usuario</label>
                    <input type="text" name="nombre_usuario" value="<?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>">
                </div>

                <div class="campo">
                    <label for="apellido_usuario">Apellido</label>
                    <input type="text" name="apellido_usuario" value="<?php echo htmlspecialchars($_SESSION['apellido_usuario']); ?>">
                </div>

                <div class="campo">
                    <label for="telefono_usuario">Telefono</label>
                    <input type="tel" pattern="[0-9]{8}" name="telefono_usuario" value="<?php echo htmlspecialchars($_SESSION['telefono_usuario']); ?>">
                </div>

                <div class="campo">
                    <label for="email_usuario">Correo</label>
                    <input type="email" name="email_usuario" value="<?php echo htmlspecialchars($_SESSION['email_usuario']); ?>">
                </div>

                <div class="campo">
                    <label for="password_usuario">Contraseña</label>
                    <input type="password" name="password_usuario" placeholder="Ingrese nueva contraseña">
                </div>

                <div class="campo">
                    <label for="confirmar_password">Confirmar Contraseña</label>
                    <input type="password" name="confirmar_password" placeholder="Confirme nueva contraseña">
                </div>

                <div class="btn">
                    <button type="submit" name="editar_perfil">Guardar Cambios</button>
                </div>
                <a href="index.php">Cancelar</a>
            </form>
        <?php else: ?>
            <p>Debe iniciar sesión para editar su perfil.</p>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <?php
                $error = $_GET['error'];
                switch($error) {
                    case '1':
                        echo "Debe realizar aunque sea un cambio para actualizar el perfil.";
                        break;
                    case '2':
                        echo "Las contraseñas no coinciden.";
                        break;
                    case '3':
                        echo "El correo electrónico no es válido.";
                        break;
                    case '4':
                        echo "Error al actualizar el perfil.";
                        break;
                    case '5':
                        echo "La extensión de la imagen no es permitida. Solo se permiten JPG, JPEG, PNG y WEBP.";
                        break;
                    default:
                        echo "Error desconocido.";
                }
                ?>
            </div>
        <?php endif; ?>
        </div>
    </section>
</body>
<script>

let cropper;

// Cuando seleccionan imagen
document.getElementById('foto_perfil').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(event) {

        // Aseguramos usar la imagen correcta
        const img = document.getElementById('imgCrop');
        img.src = event.target.result;

        // Mostrar el cuadro de recorte
        document.getElementById('modalCrop').style.display = 'block';

        // Destruir cropper previo si existe
        if (cropper) {
            cropper.destroy();
        }

        // Crear cropper
        cropper = new Cropper(img, {
            aspectRatio: 1,
            viewMode: 1,
            movable: true,
            zoomable: true,
            rotatable: false,
            scalable: false
        });
    };

    reader.readAsDataURL(file);
});

// BOTÓN QUITAR FOTO
document.getElementById('btnQuitarFoto').addEventListener('click', function() {

    // Marcar que se quitó la foto
    document.getElementById('quitar_foto').value = "1";

    // Quitar vista previa
    document.getElementById('fotoPerfilPreview').src = "fotos_perfil/default.png";

    // Limpiar input de archivo
    document.getElementById('foto_perfil').value = "";

    // Limpiar foto recortada
    document.getElementById('foto_perfil_final').value = "";

    alert("La foto de perfil será eliminada cuando guardes los cambios.");
});

// Cuando presiona "Recortar y Guardar"
document.getElementById('cropBtn').addEventListener('click', function(event) {
    event.preventDefault();

    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300
    });

    const dataURL = canvas.toDataURL("image/png");

    // Enviar la imagen recortada al PHP
    document.getElementById('foto_perfil_final').value = dataURL;

    // Ocultar modal
    document.getElementById('modalCrop').style.display = 'none';
});
</script>
</html>