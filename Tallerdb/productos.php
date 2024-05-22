<?php
// Inicia una nueva sesión o reanuda la sesión existente
session_start();

// Incluye el archivo de conexión a la base de datos
include 'conexion_db.php';

// Verifica si la variable de sesión 'usuario_id' está configurada
if (!isset($_SESSION['usuario_id'])) {
    // Si no está configurada, redirige al usuario a la página principal
    header("Location: index.php");
    // Termina la ejecución del script para asegurar que no se ejecute código adicional después de la redirección
    exit();
}

// Función para obtener productos filtrados
function obtenerProductos($conn, $nombre = '', $categoria = '') {
    // Prepara una consulta SQL para seleccionar todos los productos
    $sql = "SELECT * FROM tbl_productos WHERE 1=1";
    // Añade un filtro por nombre si se proporciona
    if ($nombre) {
        $sql .= " AND nombre LIKE '%$nombre%'";
    }
    // Añade un filtro por categoría si se proporciona
    if ($categoria) {
        $sql .= " AND categoria = '$categoria'";
    }
    // Ejecuta la consulta SQL y almacena el resultado en la variable $result
    $result = mysqli_query($conn, $sql);
    // Devuelve el resultado de la consulta
    return $result;
}

// Función para obtener todas las categorías
function obtenerCategorias($conn) {
    // Prepara una consulta SQL para seleccionar todas las categorías distintas
    $sql = "SELECT DISTINCT categoria FROM tbl_productos";
    // Ejecuta la consulta SQL y almacena el resultado en la variable $result
    $result = mysqli_query($conn, $sql);
    // Devuelve el resultado de la consulta
    return $result;
}

// Obtiene los valores de los parámetros 'nombre' y 'categoria' de la URL, si existen
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Metadatos del documento HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- Incluir hojas de estilo de Bootstrap y FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Contenedor principal de Bootstrap -->
    <div class="container mt-5">
        <!-- Barra de navegación de Bootstrap -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- Enlace a la página principal -->
            <a class="navbar-brand" href="index.php">Tienda en Línea</a>
            <!-- Botón para el menú desplegable en pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Contenido del menú desplegable -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <!-- Enlace a la página principal -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <!-- Enlace a la página de productos, activo -->
                    <li class="nav-item active">
                        <a class="nav-link" href="productos.php">Productos</a>
                    </li>
                    <!-- Enlace a la página de pedidos -->
                    <li class="nav-item">
                        <a class="nav-link" href="pedidos.php">Tus Pedidos</a>
                    </li>
                </ul>
                <!-- Enlace para cerrar sesión -->
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
        </nav>
        <!-- Contenedor para el contenido principal -->
        <div class="mt-4">
            <h2>Productos</h2>
            <!-- Formulario para filtrar productos -->
            <form method="GET" action="productos.php" class="form-inline mb-4">
                <div class="form-group mr-2">
                    <label for="nombre" class="sr-only">Nombre del Producto</label>
                    <!-- Campo de entrada para filtrar por nombre -->
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($nombre); ?>">
                </div>
                <div class="form-group mr-2">
                    <label for="categoria" class="sr-only">Categoría</label>
                    <!-- Lista desplegable para filtrar por categoría -->
                    <select class="form-control" id="categoria" name="categoria">
                        <option value="">Todas las categorías</option>
                        <?php
                        // Obtener todas las categorías
                        $categorias = obtenerCategorias($conn);
                        // Iterar sobre las categorías y crear opciones para la lista desplegable
                        while ($cat = mysqli_fetch_assoc($categorias)): ?>
                            <option value="<?php echo $cat['categoria']; ?>" <?php if ($categoria == $cat['categoria']) echo 'selected'; ?>>
                                <?php echo $cat['categoria']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- Botón para enviar el formulario de filtrado -->
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
            <!-- Mostrar mensaje si existe un parámetro 'msg' en la URL -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-info">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>
            <!-- Obtener y mostrar los productos filtrados -->
            <?php
            // Llama a la función obtenerProductos para obtener los productos filtrados
            $productos = obtenerProductos($conn, $nombre, $categoria);
            // Comprueba si hay productos disponibles
            if (mysqli_num_rows($productos) > 0): ?>
                <!-- Tabla para mostrar los productos -->
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
                        <!-- Iterar sobre los productos y mostrarlos en la tabla -->
                        <?php while ($producto = mysqli_fetch_assoc($productos)): ?>
                            <tr>
                                <td><?php echo $producto['id']; ?></td>
                                <td><?php echo $producto['nombre']; ?></td>
                                <td><?php echo $producto['precio']; ?></td>
                                <td><?php echo $producto['categoria']; ?></td>
                                <td>
                                    <!-- Enlace para hacer un pedido del producto, con confirmación -->
                                    <a href="hacer_pedido.php?producto_id=<?php echo $producto['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de que quieres pedir este producto?');">
                                        <i class="fas fa-shopping-cart"></i> Pedir
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <!-- Mostrar mensaje si no hay productos disponibles -->
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Incluir scripts de jQuery, Popper.js y Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
