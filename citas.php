<!-- ESTE CODIGO LUEGO SE ARREGLARA PORQUE ESTA UN POCO DESORNADOO PERO FUNCIONA -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
</head>
<body>
<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "tsur_bd");
if ($conexion->connect_error) {
    die("<p style='color:red;'>Error de conexión: " . $conexion->connect_error . "</p>");
}
   
?>

<h2>Formulario para Insertar cita</h2>
<form method="POST">
     <input type="hidden" name="accion" value="insertar">
    <label for="id">ID de la Cita:</label><br>
    <input type="text" id="id" name="id" required><br>
    <label for="nombre_cliente">Nombre del Cliente:</label><br>
    <input type="text" id="nombre_cliente" name="nombre_cliente" required><br>
    <label for="apellido_cliente">Apellido del Cliente:</label><br>
    <input type="text" id="apellido_cliente" name="apellido_cliente" required><br>
    <label for="fecha_cita">Fecha de la Cita:</label><br>
    <input type="date" id="fecha_cita" name="fecha_cita" required><br>
    <button type="submit">Insertar</button>
</form>

<br><br><br>

<h2>Formulario para Editar Cliente</h2>
<form method="POST">
    <input type="hidden" name="accion" value="editar">
    <label for="id">ID de la Cita:</label><br>
    <input type="text" id="id" name="id" required><br>
    <label for="nombre_cliente">Nombre del Cliente:</label><br>
    <input type="text" id="nombre_cliente" name="nombre_cliente" required><br>
    <label for="apellido_cliente">Apellido del Cliente:</label><br>
    <input type="text" id="apellido_cliente" name="apellido_cliente" required><br>
    <label for="fecha_cita">Fecha de la Cita:</label><br>
    <input type="date" id="fecha_cita" name="fecha_cita" required><br>
    <button type="submit">Insertar</button>
    </select><br><br>
    <button type="submit">Actualizar</button>
</form>

<br><br><br>

<h2>Formulario para Eliminar Cliente</h2>
<form method="POST">
    <input type="hidden" name="accion" value="eliminar">

<hr>
<?php
$sql = "SELECT id_cita, nombre_cliente, apellido_cliente, fecha_cita FROM citas";
$resultado = $conexion->query($sql);

echo "<h2>Lista de Citas</h2>";

if ($resultado->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>
            <tr style='background-color: #f2f2f2;'>
                <th>id</th>
                <th>Nombre del Cliente</th>
                <th>Apellido del Cliente</th>
                <th>Fecha de la Cita</th>
            </tr>";

    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['id_cita']}</td>
                <td>{$fila['nombre_cliente']}</td>
                <td>{$fila['apellido_cliente']}</td>
                <td>{$fila['fecha_cita']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No hay citas registradas.</p>";
}

$conexion->close();
?>

<?php

$conexion = new mysqli("localhost", "root", "", "tsur_bd");
if ($conexion->connect_error) {
    die("<p style='color:red;'>Error de conexión: " . $conexion->connect_error . "</p>");
} else {
    echo "<p style='color:green;'>¡CONEXIÓN ESTABLE CON LA BASE DE DATOS!</p>";
}

/* INSERTAR O EDITAR (ACCION DEPENDIENDO DE LA DESICION) */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"];

    if ($accion === "insertar") {
        $nombre_cliente = $_POST["nombre_cliente"];
        $apellido_cliente = $_POST["apellido_cliente"];
        $fecha_cita = $_POST["fecha_cita"];

        $sql = "INSERT INTO citas (nombre_cliente, apellido_cliente, fecha_cita)
                VALUES ('$nombre_cliente', '$apellido_cliente', '$fecha_cita')";
        
        if ($conexion->query($sql) === TRUE) {
            echo "<p style='color:green;'>Registro insertado correctamente.</p>";
        } else {
            echo "<p style='color:red;'>Error al insertar: " . $conexion->error . "</p>";
        }

    } elseif ($accion === "editar") {
        $id_cita = intval($_POST["id_cita"]);
        $nombre_cliente = $_POST["nombre_cliente"];
        $apellido_cliente = $_POST["apellido_cliente"];
        $fecha_cita = $_POST["fecha_cita"];

        $sql = "UPDATE citas
                SET nombre_cliente = '$nombre_cliente',
                    apellido_cliente = '$apellido_cliente',
                    fecha_cita = '$fecha_cita'
                WHERE id_cita = $id_cita";
        if ($conexion->query($sql) === TRUE) {
            echo "<p style='color:blue;'>Registro actualizado correctamente.</p>";
        } else {
            echo "<p style='color:red;'>Error al actualizar: " . $conexion->error . "</p>";
        }

    } elseif ($accion === "eliminar") {
        $id_cliente_eliminar = intval($_POST["id_cliente_eliminar"]);

        $sql = "DELETE FROM citas WHERE id_cita = $id_cliente_eliminar";

        if ($conexion->query($sql) === TRUE) {
            echo "<p style='color:orange;'>Registro eliminado correctamente.</p>";
        } else {
            echo "<p style='color:red;'>Error al eliminar: " . $conexion->error . "</p>";
        }
    }
}
$conexion->close();
?>
</body>
</html>