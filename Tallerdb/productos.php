<?php
session_start();
include 'conexion_db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

// Función para obtener productos filtrados
function obtenerProductos($conn, $nombre = '', $categoria = '') {
    $sql = "SELECT * FROM tbl_productos WHERE 1=1";
    if ($nombre) {
        $sql .= " AND nombre LIKE '%$nombre%'";
    }
    if ($categoria) {
        $sql .= " AND categoria = '$categoria'";
    }
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Función para obtener todas las categorías
function obtenerCategorias($conn) {
    $sql = "SELECT DISTINCT categoria FROM tbl_productos";
    $result = mysqli_query($conn, $sql);
    return $result;
}

$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
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
                    <li class="nav-item active">
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
            <h2>Productos</h2>
            <form method="GET" action="productos.php" class="form-inline mb-4">
                <div class="form-group mr-2">
                    <label for="nombre" class="sr-only">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($nombre); ?>">
                </div>
                <div class="form-group mr-2">
                    <label for="categoria" class="sr-only">Categoría</label>
                    <select class="form-control" id="categoria" name="categoria">
                        <option value="">Todas las categorías</option>
                        <?php
                        $categorias = obtenerCategorias($conn);
                        while ($cat = mysqli_fetch_assoc($categorias)): ?>
                            <option value="<?php echo $cat['categoria']; ?>" <?php if ($categoria == $cat['categoria']) echo 'selected'; ?>>
                                <?php echo $cat['categoria']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-info">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>
            <?php
            $productos = obtenerProductos($conn, $nombre, $categoria);
            if (mysqli_num_rows($productos) > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($producto = mysqli_fetch_assoc($productos)): ?>
                            <tr>
                                <td><?php echo $producto['id']; ?></td>
                                <td><?php echo $producto['nombre']; ?></td>
                                <td><?php echo $producto['precio']; ?></td>
                                <td><?php echo $producto['categoria']; ?></td>
                                <td>
                                    <a href="hacer_pedido.php?producto_id=<?php echo $producto['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de que quieres pedir este producto?');">
                                        <i class="fas fa-shopping-cart"></i> Pedir
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
