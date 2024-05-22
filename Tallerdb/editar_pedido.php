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
    $sql = "SELECT p.id, p.nombre, pd.cantidad, pd.fecha
            FROM tbl_pedidos pd
            JOIN tbl_productos p ON pd.producto_id = p.id
            WHERE pd.id = $pedido_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

$pedido = obtenerDetallesPedido($conn, $pedido_id);

if (!$pedido) {
    header("Location: pedidos.php?msg=Pedido no encontrado");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = $_POST['cantidad'];
    $fecha_actual = date('Y-m-d H:i:s');  // Fecha y hora actual

    $sql = "UPDATE tbl_pedidos 
            SET cantidad = ?, fecha = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $cantidad, $fecha_actual, $pedido_id);

    if ($stmt->execute()) {
        header("Location: pedidos.php?msg=Pedido actualizado correctamente");
        exit();
    } else {
        $error = "Error al actualizar el pedido: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
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
            <h2>Editar Pedido</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" value="<?php echo htmlspecialchars($pedido['nombre']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($pedido['cantidad']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="pedidos.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a Pedidos
                </a>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
