<?php
// Verifica si el método de solicitud es POST, indicando que se ha enviado un formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluye el archivo de conexión a la base de datos
    include 'conexion_db.php';

    // Escapa y asigna el valor del campo 'nombre' del formulario a una variable
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    // Escapa y asigna el valor del campo 'correo_electronico' del formulario a una variable
    $correo_electronico = mysqli_real_escape_string($conn, $_POST['correo_electronico']);
    // Escapa y asigna el valor del campo 'contrasena' del formulario a una variable
    $contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);
    // Asigna la contraseña a una variable sin cifrarla (en un entorno real, deberías usar password_hash())
    $contrasena_hashed = $contrasena;

    // Prepara una consulta SQL para insertar un nuevo usuario en la tabla 'tbl_usuarios'
    $sql = "INSERT INTO tbl_usuarios (nombre, correo_electronico, contrasena) VALUES ('$nombre', '$correo_electronico', '$contrasena_hashed')";

    // Ejecuta la consulta SQL y verifica si se realizó correctamente
    if (mysqli_query($conn, $sql)) {
        // Si la inserción fue exitosa, establece un mensaje de éxito
        $success = "Usuario registrado correctamente. Ahora puedes iniciar sesión.";
    } else {
        // Si hubo un error en la inserción, establece un mensaje de error
        $error = "Error al registrar el usuario: " . mysqli_error($conn);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Metadatos del documento HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <!-- Incluir hojas de estilo de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Contenedor principal de Bootstrap -->
    <div class="container mt-5">
        <h1>Registrar</h1>
        <!-- Mostrar mensaje de error si existe -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <!-- Mostrar mensaje de éxito si existe -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
            <!-- Enlace para volver a la página de inicio de sesión -->
            <a href="index.php" class="btn btn-primary mt-3">Volver a Inicio de Sesión</a>
        <?php endif; ?>
        <!-- Mostrar el formulario de registro si no hay mensaje de éxito -->
        <?php if (!isset($success)): ?>
            <form method="post" action="register.php">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <!-- Campo de entrada para el nombre -->
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="correo_electronico">Correo Electrónico</label>
                    <!-- Campo de entrada para el correo electrónico -->
                    <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <!-- Campo de entrada para la contraseña -->
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>
                <!-- Botón para enviar el formulario de registro -->
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
