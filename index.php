<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="index.css"></link>
</head>
<body>
<header class="header">
    <div class="logo">TSUR</div>
    <nav class="nav">
      <a href="index.php">Inicio</a>
      <a href="#">Sobre nosotros</a>
      <a href="proyectos.php">Proyectos</a>
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
    <!-- ===== SECCIÓN PRINCIPAL ===== -->
    <main class="hero">
        <div class="hero-content">
            <h1>Construimos confianza, no solo proyectos</h1>
            <p>En TSUR ofrecemos asesoría técnica y consultoría en construcción, garantizando calidad, seguridad y eficiencia en cada obra.</p><br>
            <button>Solicitar asesoría</button> <!-- agregar enlace para que funcione el boton -->
        </div>
    </main>
    <!-- ===== SECCIÓN COMENTARIOS EN EL INICIO ===== -->
<section id="comentarios" class="comentarios">
    <h2>Comentarios</h2>
    <p>Inicio de sesión requerido para comentar.</p>
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
                    <label for="calificacion">Calificación</label>
                    <select id="calificacion" name="calificacion" required>
                        <option value="">Seleccione una calificación</option>
                        <option value="1">1 / 5</option>
                        <option value="2">2 / 5</option>
                        <option value="3">3 / 5</option>
                        <option value="4">4 / 5</option>
                        <option value="5">5 / 5</option>
                    </select>
                </div>
                <div class="campo">
                    <label for="titulo_comentario">Título</label>
                    <input type="text" id="titulo_comentario" name="titulo_comentario"
                           placeholder="Título del comentario" required>
                </div>
                <div class="campo">
                    <label for="comentario">Comentario</label>
                    <textarea id="comentario" name="comentario" rows="4"
                              placeholder="Escriba su comentario" required></textarea>
                </div>
                <button type="submit">Publicar</button>
            </form>
        <?php else: ?>
            <p>Debe iniciar sesión para poder publicar un comentario.</p>
        <?php endif; ?>
        <div class="lista-comentarios">
            <p>Aquí se mostrarán los comentarios registrados.</p>
        </div>
    </div>
</section>
<footer class="footer"> 
    <div class="footer-content">
    <p>© 2024 TSUR. Todos los derechos reservados.</p>
    </div>
</footer>
</body>
</html>





