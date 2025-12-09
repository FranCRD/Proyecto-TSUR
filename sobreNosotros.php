<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - TSUR</title>
    <link rel="stylesheet" href="sobreNosotros.css"></link>
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
          <a href="login.php">Iniciar sesión</a>
      <?php else: ?>
        <div class="user-menu">
            <a href="#" class="user-icon">
                <img src="<?php echo htmlspecialchars($_SESSION['foto_perfil']); ?>" class="user-photo">
                <span class="user-name"><?php echo $_SESSION['nombre_usuario']; ?></span>
            </a>
            <div class="user-dropdown">
                <a href="editarPerfil.php">Editar perfil</a>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>
      <?php endif; ?>
    </nav>
</header>

<!-- =================== SOBRE NOSOTROS =================== -->
<section class="sobre">
    <div class="sobre-contenido">
        <img src="logo.png" alt="Logo TSUR" class="logo-sobre">
        <h1>Sobre TSUR Construcciones</h1>
        <p>
            TSUR es una empresa especializada en construcción, consultoría y gestión de proyectos.
            Nos enfocamos en brindar resultados de alta calidad, con transparencia, responsabilidad y un enfoque
            completamente profesional desde el primer contacto.
        </p>
        <p>
            Nuestro compromiso es construir espacios seguros, modernos y duraderos, aplicando técnicas actualizadas
            y materiales certificados para asegurar la satisfacción total de nuestros clientes.
        </p>
    </div>

    <div class="sobre-info">
        <div class="card">
            <h2>Fundador</h2>
            <div class="owner">
                <img src="owner.jpg" class="owner-photo" alt="Dueño">
                <div>
                    <h3>Papá de Juan</h3>
                    <p>Director General</p>
                </div>
            </div>
            <p class="bio">Con mas de tantos x años de experiencia (bla bla bla bla).</p>
        </div>

        <div class="card">
            <h2>Ubicación</h2>
            <p>San José, Costa Rica</p>
            <p><small>Atendemos proyectos en todo el territorio nacional.</small></p>
        </div>

        <div class="card">
            <h2>Servicios</h2>
            <ul>
                <li>Construcción residencial</li>
                <li>Proyectos comerciales e industriales</li>
                <li>Remodelaciones</li>
                <li>Asesoría y consultoría técnica</li>
                <li>Gestión y dirección de obra</li>
            </ul>
        </div>
    </div>
</section>

<footer class="footer"> 
    <div class="footer-content">
        <p>© 2024 TSUR. Todos los derechos reservados.</p>
    </div>
</footer>
