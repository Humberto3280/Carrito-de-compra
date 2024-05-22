<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion_db.php';
    
    $correo_electronico = mysqli_real_escape_string($conn, $_POST['correo_electronico']);
    $contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);

    $sql = "SELECT id, nombre, contrasena FROM tbl_usuarios WHERE correo_electronico='$correo_electronico'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($contrasena === $row['contrasena']) {  // Comparar la contraseña directamente
            session_start();
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            header("Location: index.php");
            exit();
        } else {
            $error = "La contraseña es incorrecta.";
        }
    } else {
        $error = "No se encontró una cuenta con ese correo electrónico.";
    }
    mysqli_close($conn);
}
