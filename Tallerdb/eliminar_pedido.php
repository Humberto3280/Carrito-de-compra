<?php
// Inicia una nueva sesión o reanuda la sesión existente
session_start();

// Incluye el archivo de conexión a la base de datos
include 'conexion_db.php';

// Verifica si la variable de sesión 'usuario_id' no está configurada o si no existe el parámetro 'id' en la URL
if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    // Redirige al usuario a la página principal si no está configurada la sesión o no existe el parámetro 'id'
    header("Location: index.php");
    // Termina la ejecución del script para asegurar que no se ejecute código adicional después de la redirección
    exit();
}

// Asigna el valor del parámetro 'id' de la URL a la variable $pedido_id
$pedido_id = $_GET['id'];
// Asigna el valor de la variable de sesión 'usuario_id' a la variable $usuario_id
$usuario_id = $_SESSION['usuario_id'];

// Prepara una consulta SQL para verificar que el pedido pertenece al usuario actual
$sql = "SELECT * FROM tbl_pedidos WHERE id = $pedido_id AND usuario_id = $usuario_id";
// Ejecuta la consulta SQL y almacena el resultado en la variable $result
$result = mysqli_query($conn, $sql);

// Comprueba si se ha encontrado exactamente un resultado (un pedido que pertenece al usuario actual)
if (mysqli_num_rows($result) == 1) {
    // Prepara una consulta SQL para eliminar el pedido
    $sql = "DELETE FROM tbl_pedidos WHERE id = $pedido_id";
    // Ejecuta la consulta SQL para eliminar el pedido
    if (mysqli_query($conn, $sql)) {
        // Si la eliminación fue exitosa, redirige al usuario a la página de pedidos con un mensaje de éxito
        header("Location: pedidos.php?msg=Pedido eliminado correctamente");
        // Termina la ejecución del script para asegurar que no se ejecute código adicional después de la redirección
        exit();
    } else {
        // Si hubo un error en la eliminación, redirige al usuario a la página de pedidos con un mensaje de error
        header("Location: pedidos.php?msg=Error al eliminar el pedido");
        // Termina la ejecución del script para asegurar que no se ejecute código adicional después de la redirección
        exit();
    }
} else {
    // Si no se encontró un pedido que pertenece al usuario actual, redirige a la página de pedidos con un mensaje de error
    header("Location: pedidos.php?msg=No tienes permiso para eliminar este pedido");
    // Termina la ejecución del script para asegurar que no se ejecute código adicional después de la redirección
    exit();
}
