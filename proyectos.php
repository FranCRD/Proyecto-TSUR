<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="stylesheet" href="index.css"></link>
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
      <a href="citas.php">Citas</a>
      <a href="login.php">Iniciar sesión</a>
    </nav>
</header>

<br>
<p><strong>A continuacion se muestran algunos de nuestros proyectos en los que el equipo de TSUR ha trabajado</strong></p>
<br>
<?php if (isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1): ?>
    <!-- Contenido exclusivo para administradores -->   
<p><strong>Para agregar un proyecto, haz click abajo:</strong></p>
<br>
<form action="insertProyectos.php" method="POST" enctype="multipart/form-data">

    <label><strong>Título del proyecto:</strong></label><br>
    <input type="text" name="titulo" placeholder="Escribe el título" required>
    <br><br>

    <label><strong>Descripción del proyecto:</strong></label><br>
    <textarea name="descripcion" placeholder="Escribe una breve descripción" rows="4" required></textarea>
    <br><br>

    <label><strong>Selecciona una imagen:</strong></label><br>
    <input type="file" name="imagenes" accept="image/*" required>
    <br><br>

    <button type="submit">Subir Proyecto</button><br>
</form>

<h3>Reemplazar una imagen (sube una nueva imagen para el ID indicado)</h3>
 <form method="POST" action="updateProyectos.php" enctype="multipart/form-data">

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

    <button type="submit">Actualizar proyecto</button><br>
</form>

  <h2>Eliminar imagen por ID</h2>
    <form method="POST" action="deleteProyectos.php">
        <label for="id">ID de la imagen a eliminar:</label>
        <input type="number" name="id" id="id" required>
        <br><br>
        <button type="submit">Eliminar</button>
    </form>

    <?php if (!empty($error)): ?>
        <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
<?php endif; ?>
<br>
<hr>
<h3>Proyectos Destacados</h3>
    <div> 
        <ul class="proyectos_img" id="proyectos_img"></ul>
    </div>


</body>
</html>
