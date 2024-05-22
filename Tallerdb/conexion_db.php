<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_carrito_tienda";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
