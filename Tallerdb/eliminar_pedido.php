<?php
session_start();
include 'conexion_db.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$pedido_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Verificar que el pedido pertenece al usuario actual
$sql = "SELECT * FROM tbl_pedidos WHERE id = $pedido_id AND usuario_id = $usuario_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    // Eliminar el pedido
    $sql = "DELETE FROM tbl_pedidos WHERE id = $pedido_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: pedidos.php?msg=Pedido eliminado correctamente");
        exit();
    } else {
        header("Location: pedidos.php?msg=Error al eliminar el pedido");
        exit();
    }
} else {
    header("Location: pedidos.php?msg=No tienes permiso para eliminar este pedido");
    exit();
}
