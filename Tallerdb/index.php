<?php
// Inicia una nueva sesión o reanuda la sesión existente
session_start();

// Incluye el archivo de conexión a la base de datos
include 'conexion_db.php';

// Inicializa una variable para almacenar errores
$error = null;

// Comprueba si el método de solicitud es POST, indicando que se ha enviado un formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluye el archivo login.php que maneja el proceso de inicio de sesión
    include 'login.php';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Metadatos del documento HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <!-- Incluir hojas de estilo de Bootstrap y FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Definir un estilo personalizado para un botón verde */
        .btn-custom-green {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Contenedor principal de Bootstrap -->
    <div class="container mt-5">
        <?php if (!isset($_SESSION['usuario_id'])): ?>
            <!-- Mostrar formulario de inicio de sesión si el usuario no ha iniciado sesión -->
            <div class="container mt-5">
                <h1>Iniciar Sesión</h1>
                <?php if ($error): ?>
                    <!-- Mostrar mensaje de error si hay uno -->
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <!-- Formulario de inicio de sesión -->
                <form method="post" action="index.php">
                    <div class="form-group">
                        <label for="correo_electronico">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                    </div>
                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-custom-green mr-2">Iniciar Sesión</button>
                        <a href="register.php" class="btn btn-primary">Registrar</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <!-- Mostrar navegación y bienvenida si el usuario ha iniciado sesión -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.php">Haz tu pedido ya!!!</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="productos.php">Productos</a>
                        </li>
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
            <div id="home" class="mt-4">
                <!-- Mensaje de bienvenida -->
                <div class="alert alert-success" role="alert">
                    Bienvenido, <?php echo $_SESSION['nombre']; ?>. Has iniciado sesión correctamente.
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!-- Incluir scripts de jQuery, Popper.js y Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
