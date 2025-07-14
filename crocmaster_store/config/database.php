<?php
/* ========================================
   CONFIGURACIÓN DE CONEXIÓN A BASE DE DATOS
   ======================================== */

// Datos de conexión a MySQL
$servername = "localhost";    // Servidor (local en este caso)
$username = "root";          // Usuario de MySQL
$password = "";              // Contraseña (vacía en XAMPP por defecto)
$dbname = "pet_store";       // Nombre de nuestra base de datos

try {
    /* ========================================
       CREACIÓN DE CONEXIÓN PDO
       ======================================== */
    // PDO es más seguro que mysqli para evitar inyección SQL
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configurar PDO para mostrar errores como excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    /* ========================================
       MANEJO DE ERRORES DE CONEXIÓN
       ======================================== */
    // Si falla la conexión, detener la ejecución y mostrar error
    die("Error de conexión: " . $e->getMessage());
}

/* ========================================
   INICIALIZACIÓN DE SESIONES
   ======================================== */
// Iniciar sesiones PHP para manejar login de usuarios
session_start();
?>
