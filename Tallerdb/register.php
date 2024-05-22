<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion_db.php';

    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $correo_electronico = mysqli_real_escape_string($conn, $_POST['correo_electronico']);
    $contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);
    $contrasena_hashed = $contrasena;  // Aquí no ciframos las contraseñas, pero en un entorno real deberíamos usar password_hash()

    $sql = "INSERT INTO tbl_usuarios (nombre, correo_electronico, contrasena) VALUES ('$nombre', '$correo_electronico', '$contrasena_hashed')";

    if (mysqli_query($conn, $sql)) {
        $success = "Usuario registrado correctamente. Ahora puedes iniciar sesión.";
    } else {
        $error = "Error al registrar el usuario: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Registrar</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
            <a href="index.php" class="btn btn-primary mt-3">Volver a Inicio de Sesión</a>
        <?php endif; ?>
        <?php if (!isset($success)): ?>
            <form method="post" action="register.php">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="correo_electronico">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
