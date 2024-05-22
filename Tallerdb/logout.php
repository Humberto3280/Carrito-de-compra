<?php
// Inicia una nueva sesión o reanuda la sesión existente
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión actual
session_destroy();

// Redirige al usuario a la página principal (index.php)
header("Location: index.php");

// Termina la ejecución del script para asegurar que no se ejecute código adicional después de la redirección
exit();
