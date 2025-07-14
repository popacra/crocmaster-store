<?php
/* ========================================
   SCRIPT PARA CERRAR SESIÓN
   ======================================== */

// Iniciar la sesión para poder destruirla
session_start();

// Destruir todas las variables de sesión
session_destroy();

// Redirigir al usuario a la página principal
header('Location: index.php');
exit;  // Importante: detener la ejecución después del redirect
?>
