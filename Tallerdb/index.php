<?php
session_start();
include 'conexion_db.php';

$error = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'login.php';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .btn-custom-green {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <?php if (!isset($_SESSION['usuario_id'])): ?>
            <div class="container mt-5">
                <h1>Iniciar Sesión</h1>
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
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
            <div class="d-flex justify-content-between align-items-center">
                <div class="alert alert-success m-0" role="alert">
                    Bienvenido, <?php echo $_SESSION['nombre']; ?>. Has iniciado sesión correctamente.
                </div>
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
            <!-- Aquí puedes agregar más contenido para la página principal -->
        <?php endif; ?>
    </div>
</body>
</html>
