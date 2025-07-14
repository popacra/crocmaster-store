<?php
/* ========================================
   PROCESAMIENTO DEL FORMULARIO DE LOGIN
   ======================================== */
require_once 'config/database.php';

$error = '';  // Variable para almacenar mensajes de error

// Si se envió el formulario (método POST)
if ($_POST) {
    // Obtener datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validar que ambos campos tengan contenido
    if ($email && $password) {
        /* ========================================
           VERIFICACIÓN DE CREDENCIALES
           ======================================== */
        // Buscar usuario por email (consulta preparada para seguridad)
        $stmt = $pdo->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar si existe el usuario y la contraseña es correcta
        if ($usuario && password_verify($password, $usuario['password'])) {
            /* ========================================
               LOGIN EXITOSO - CREAR SESIÓN
               ======================================== */
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            
            // Redirigir a la página principal
            header('Location: index.php');
            exit;
        } else {
            // Credenciales incorrectas
            $error = 'Email o contraseña incorrectos';
        }
    } else {
        // Campos vacíos
        $error = 'Por favor completa todos los campos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ========================================
         CONFIGURACIÓN DEL HEAD
         ======================================== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - CrocMaster Store</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="styles/main.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <!-- ========================================
                     TARJETA DEL FORMULARIO DE LOGIN
                     ======================================== -->
                <div class="card shadow">
                    <div class="card-body p-4">
                        <!-- Header del formulario -->
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">
                                <i class="fas fa-paw me-2"></i>CrocMaster Store
                            </h2>
                            <p class="text-muted">Iniciar Sesión</p>
                        </div>

                        <!-- ========================================
                             MOSTRAR ERRORES SI EXISTEN
                             ======================================== -->
                        <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                        </div>
                        <?php endif; ?>

                        <!-- ========================================
                             FORMULARIO DE LOGIN
                             ======================================== -->
                        <form method="POST">
                            <!-- Campo de email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            </div>
                            
                            <!-- Campo de contraseña -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <!-- Botón de envío -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">
                        
                        <!-- ========================================
                             ENLACES ADICIONALES
                             ======================================== -->
                        <div class="text-center">
                            <p class="mb-2">¿No tienes cuenta?</p>
                            <a href="registro.php" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus me-2"></i>Registrarse
                            </a>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="index.php" class="text-muted">
                                <i class="fas fa-arrow-left me-1"></i>Volver al inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
