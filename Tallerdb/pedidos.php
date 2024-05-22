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

// Función para obtener los pedidos del usuario
function obtenerPedidos($conn, $usuario_id) {
    // Prepara una consulta SQL para seleccionar los detalles de los pedidos del usuario
    $sql = "SELECT p.id, p.nombre, pd.cantidad, pd.fecha, pd.id as pedido_id
            FROM tbl_pedidos pd
            JOIN tbl_productos p ON pd.producto_id = p.id
            WHERE pd.usuario_id = $usuario_id";
    // Ejecuta la consulta SQL y almacena el resultado en la variable $result
    $result = mysqli_query($conn, $sql);
    // Devuelve el resultado de la consulta
    return $result;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Metadatos del documento HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus Pedidos</title>
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
                    <!-- Enlace a la página de productos -->
                    <li class="nav-item">
                        <a class="nav-link" href="productos.php">Productos</a>
                    </li>
                    <!-- Enlace a la página de pedidos, activo -->
                    <li class="nav-item active">
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
            <h2>Tus Pedidos</h2>
            <!-- Mostrar mensaje si existe un parámetro 'msg' en la URL -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-info">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>
            <!-- Obtener y mostrar los pedidos del usuario -->
            <?php
            // Llama a la función obtenerPedidos para obtener los pedidos del usuario actual
            $pedidos = obtenerPedidos($conn, $_SESSION['usuario_id']);
            // Comprueba si hay pedidos
            if (mysqli_num_rows($pedidos) > 0): ?>
                <!-- Tabla para mostrar los pedidos -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Producto</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Iterar sobre los pedidos y mostrarlos en la tabla -->
                        <?php while ($pedido = mysqli_fetch_assoc($pedidos)): ?>
                            <tr>
                                <td><?php echo $pedido['id']; ?></td>
                                <td><?php echo $pedido['nombre']; ?></td>
                                <td><?php echo $pedido['cantidad']; ?></td>
                                <td><?php echo $pedido['fecha']; ?></td>
                                <td>
                                    <a href="ver_pedido.php?id=<?php echo $pedido['pedido_id']; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="editar_pedido.php?id=<?php echo $pedido['pedido_id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="eliminar_pedido.php?id=<?php echo $pedido['pedido_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <!-- Mostrar mensaje si no hay pedidos -->
                <p>No has realizado ningún pedido.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Incluir scripts de jQuery, Popper.js y Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
