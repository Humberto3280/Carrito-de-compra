<?php
session_start();
include 'conexion_db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: pedidos.php?msg=Pedido no especificado");
    exit();
}

$pedido_id = $_GET['id'];

// Función para obtener los detalles de un pedido
function obtenerDetallesPedido($conn, $pedido_id) {
    $sql = "SELECT p.id, p.nombre, pd.cantidad, pd.fecha, pd.usuario_id
            FROM tbl_pedidos pd
            JOIN tbl_productos p ON pd.producto_id = p.id
            WHERE pd.id = $pedido_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Función para obtener los detalles del usuario
function obtenerDetallesUsuario($conn, $usuario_id) {
    $sql = "SELECT nombre, correo_electronico FROM tbl_usuarios WHERE id = $usuario_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

$pedido = obtenerDetallesPedido($conn, $pedido_id);

if (!$pedido) {
    header("Location: pedidos.php?msg=Pedido no encontrado");
    exit();
}

$usuario = obtenerDetallesUsuario($conn, $pedido['usuario_id']);

if (!$usuario) {
    header("Location: pedidos.php?msg=Usuario no encontrado");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Pedido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">Tienda en Línea</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productos.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pedidos.php">Tus Pedidos</a>
                    </li>
                </ul>
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
        </nav>
        <div class="mt-4">
            <h2>Detalle del Pedido</h2>
            <table class="table table-bordered">
                <tr>
                    <th>ID del Producto</th>
                    <td><?php echo $pedido['id']; ?></td>
                </tr>
                <tr>
                    <th>Nombre del Producto</th>
                    <td><?php echo $pedido['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Cantidad</th>
                    <td><?php echo $pedido['cantidad']; ?></td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td><?php echo $pedido['fecha']; ?></td>
                </tr>
                <tr>
                    <th>Nombre del Usuario</th>
                    <td><?php echo $usuario['nombre']; ?></td>
                </tr>
                <tr>
                    <th>Correo Electrónico</th>
                    <td><?php echo $usuario['correo_electronico']; ?></td>
                </tr>
            </table>
            <a href="pedidos.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Volver a Pedidos
            </a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
