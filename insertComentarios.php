<!-- ===== SECCIÓN COMENTARIOS EN EL INICIO ===== -->
<?php
session_start();
include "conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<header class="header">
    <div class="logo">TSUR</div>
    <nav class="nav">
      <a href="index.php">Inicio</a>
      <a href="#">Sobre nosotros</a>
      <a href="proyectos.php">Proyectos</a>
        <a href="insertComentarios.php">Comentarios</a>
        <?php if (!isset($_SESSION['nombre_usuario'])): ?>
          <!-- Usuario no logueado -->
            <a href="login.php">Iniciar sesión</a>
        <?php else: ?>
            <!-- Usuario logueado -->
             <div class="user-menu">
             <a href="#" class="user-icon">👤 <?php echo $_SESSION['nombre_usuario']; ?></a>
        <div class="user-dropdown">
            <a href="editar_perfil.php">Editar perfil</a>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div> 
        <?php endif; ?>
    </nav>
</header>

<section id="comentarios" class="comentarios">
    <h2>Comentarios</h2>

    <div class="comentarios-contenedor">

        <!-- FORMULARIO -->
        <?php if (isset($_SESSION['nombre_usuario'])): ?>
            <form class="form-comentarios" method="post" action="">

                <div class="campo">
                    <label for="nombre_usuario">Nombre de usuario</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario"
                           value="<?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>"
                           readonly>
                </div>

                <div class="campo">
                    <label for="valoracion">Calificación</label>
                    <select id="valoracion" name="valoracion" required>
                        <option value="">Seleccione una calificación</option>
                        <option value="1">1 / 5</option>
                        <option value="2">2 / 5</option>
                        <option value="3">3 / 5</option>
                        <option value="4">4 / 5</option>
                        <option value="5">5 / 5</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="TituloComentario">Título</label>
                    <input type="text" id="TituloComentario" name="TituloComentario"
                           placeholder="Título del comentario" required>
                </div>

                <div class="campo">
                    <label for="Comentario">Comentario</label>
                    <textarea id="Comentario" name="Comentario" rows="4"
                              placeholder="Escriba su comentario" required></textarea>
                </div>

                
                <button type="submit" name="enviar">Publicar</button>
            </form>
        <?php else: ?>
            <p>Debe iniciar sesión para poder publicar un comentario.</p>
        <?php endif; ?>


        <!-- LISTA DE COMENTARIOS -->
        <div class="lista-comentarios">
            <?php
            $result = $conexion->query("SELECT * FROM comentario ORDER BY idComentario DESC");

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div style="border:1px solid #ccc; padding:10px; margin:10px 0;">';
                    echo '<b>Usuario:</b> '.$row["nombre_usuario"].'<br>';
                    echo '<b>Calificación:</b> '.$row["valoracion"].'/5<br>';
                    echo '<h4>'.htmlspecialchars($row["TituloComentario"]).'</h4>';
                    echo '<p>'.nl2br(htmlspecialchars($row["Comentario"])).'</p>';        
                    
                    echo '<small>'.$row["Fecha"].'</small>';
                    echo '</div>';
                }
            } else {
                echo "<p>No hay comentarios aún.</p>";
            }
            ?>
        </div>
    </div>
</section>

<?php
// ===== INSERT DE COMENTARIOS=====
if (isset($_POST['enviar'])) {

    $usuario    = $_SESSION['nombre_usuario'];
    $titulo     = $_POST['TituloComentario'];
    $comentario = $_POST['Comentario'];
    $valoracion = $_POST['valoracion'];
    $fecha      = date("Y-m-d H:i:s");

    $stmt = $conexion->prepare("
        INSERT INTO comentario (TituloComentario, Comentario, nombre_usuario, valoracion, Fecha)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssds", $titulo, $comentario, $usuario, $valoracion, $fecha);

    if ($stmt->execute()) {
        header("Location: insertComentarios.php");
        exit();
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>
<footer class="footer"> 
    <div class="footer-content">
    <p>© 2024 TSUR. Todos los derechos reservados.</p>
    </div>
</footer>
</body>
</html>
