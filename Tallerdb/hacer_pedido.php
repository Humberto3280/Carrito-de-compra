<?php
session_start();
include 'conexion_db.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['producto_id'])) {
    header("Location: index.php");
    exit();
}

$producto_id = $_GET['producto_id'];
$usuario_id = $_SESSION['usuario_id'];
$cantidad = 1;  // Puedes ajustar esto para permitir al usuario seleccionar la cantidad

$sql = "INSERT INTO tbl_pedidos (usuario_id, producto_id, cantidad, fecha) VALUES ($usuario_id, $producto_id, $cantidad, NOW())";
if (mysqli_query($conn, $sql)) {
    header("Location: productos.php?msg=Pedido realizado correctamente");
    exit();
} else {
    header("Location: productos.php?msg=Error al realizar el pedido");
    exit();
}
