<?php
// Comprueba si la solicitud es de tipo POST, indicando que se ha enviado un formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluye el archivo de conexión a la base de datos
    include 'conexion_db.php';
    
    // Escapa y asigna el valor del campo 'correo_electronico' del formulario a una variable
    $correo_electronico = mysqli_real_escape_string($conn, $_POST['correo_electronico']);
    // Escapa y asigna el valor del campo 'contrasena' del formulario a una variable
    $contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);

    // Prepara una consulta SQL para seleccionar el id, nombre y contraseña del usuario con el correo electrónico proporcionado
    $sql = "SELECT id, nombre, contrasena FROM tbl_usuarios WHERE correo_electronico='$correo_electronico'";
    // Ejecuta la consulta SQL y almacena el resultado en la variable $result
    $result = mysqli_query($conn, $sql);

    // Comprueba si se ha encontrado exactamente un resultado (un usuario con el correo electrónico proporcionado)
    if (mysqli_num_rows($result) == 1) {
        // Obtiene la fila de resultados como un array asociativo
        $row = mysqli_fetch_assoc($result);
        // Comprueba si la contraseña proporcionada coincide con la contraseña almacenada en la base de datos
        if ($contrasena === $row['contrasena']) {
            // Inicia una sesión
            session_start();
            // Almacena el id del usuario en una variable de sesión
            $_SESSION['usuario_id'] = $row['id'];
            // Almacena el nombre del usuario en una variable de sesión
            $_SESSION['nombre'] = $row['nombre'];
            // Redirige al usuario a la página principal
            header("Location: index.php");
            // Termina la ejecución del script
            exit();
        } else {
            // Establece un mensaje de error si la contraseña es incorrecta
            $error = "La contraseña es incorrecta.";
        }
    } else {
        // Establece un mensaje de error si no se encuentra una cuenta con el correo electrónico proporcionado
        $error = "No se encontró una cuenta con ese correo electrónico.";
    }
    // Cierra la conexión a la base de datos
    mysqli_close($conn);
}
