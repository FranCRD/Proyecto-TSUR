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
      <a href="citas.php">Citas</a>
        <?php if (!isset($_SESSION['nombre_usuario'])): ?>
          <!-- Usuario no logueado -->
            <a href="login.php">Iniciar sesión</a>
        <?php else: ?>
            <!-- Usuario logueado -->
             <div clas="user-menu">
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
<footer class="footer"> 
    <div class="footer-content">
    <p>© 2024 TSUR. Todos los derechos reservados.</p>
    </div>
</footer>
</body>
</html>

