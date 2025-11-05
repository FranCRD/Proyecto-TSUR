<?php

$conexion = mysqli_connect("localhost", "root", "", "tsur_bd");
if (mysqli_connect_errno()) {
    printf("Fallo la conexion: %s\n", mysqli_connect_error());
} 

?>