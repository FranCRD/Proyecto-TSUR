<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="proyectos.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="funciones.js"></script>
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

<br>
<p><strong>A continuacion se muestran algunos de nuestros proyectos en los que el equipo de TSUR ha trabajado</strong></p>
<br>

    <!-- Contenido exclusivo para administradores -->   
     <?php if (isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1): ?>
<p><strong>Para agregar un proyecto, haz click abajo:</strong></p>
<br>

<form class="formInsertProyectos" id="formInsertProyectos" method="POST" enctype="multipart/form-data">
        <label><strong>Título del proyecto:</strong></label><br>
    <input type="text" name="titulo" placeholder="Escribe el título" required>
    <br><br>

    <label><strong>Descripción del proyecto:</strong></label><br>
    <textarea name="descripcion" placeholder="Escribe una breve descripción" rows="4" required></textarea>
    <br><br>

    <label><strong>Selecciona una imagen:</strong></label><br>
    <input type="file" name="imagenes" accept="image/*" required>
    <br><br>

    <button type="button" name="agregar_proyecto" onclick="insertProyectos()">Subir Proyecto</button><br>
</form>
<div id="mensajeInsert" class="mensaje"></div>
<br>

<h3>Reemplazar una imagen (sube una nueva imagen para el ID indicado)</h3>
 <form id="formUpdateProyectos" enctype="multipart/form-data">

    <label>ID del proyecto:</label>
    <input type="number" name="id" required>
    <br><br>

    <label>Nuevo Título:</label>
    <input type="text" name="titulo" required>
    <br><br>

    <label>Nueva Descripción:</label>
    <textarea name="descripcion" rows="3" required></textarea>
    <br><br>

    <label>Nueva imagen (opcional):</label>
    <input type="file" name="imagenes" accept="image/*">
    <br><br>

    <button type="button" onclick="updateProyectos()">Actualizar proyectos</button>
</form>

<div id="mensajeUpdate" class="mensaje"></div>
<br>

  <h2>Eliminar imagen por ID</h2>
<form id="formDeleteProyecto">
    <label for="id">ID de la imagen a eliminar:</label>
    <input type="number" name="id" id="idEliminar" required>
    <br><br>
    <button type="button" onclick="deleteProyectos()">Eliminar</button>
</form>

<p id="mensajeDelete" style="font-weight:bold;"></p>
<?php endif; ?>
<br>
<hr>
<h3>Proyectos Destacados</h3>
    <div> 
        <ul class="proyectos_img" id="proyectos_img"></ul>
    </div>
</body>
</html>
