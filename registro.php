<?php
/* ========================================
   PROCESAMIENTO DEL FORMULARIO DE REGISTRO
   ======================================== */
require_once 'config/database.php';

$error = '';    // Variable para errores
$success = '';  // Variable para mensajes de éxito

// Si se envió el formulario
if ($_POST) {
    // Obtener y limpiar datos del formulario
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validar que todos los campos estén llenos
    if ($nombre && $email && $password && $confirm_password) {
        // Verificar que las contraseñas coincidan
        if ($password === $confirm_password) {
            /* ========================================
               VERIFICAR SI EL EMAIL YA EXISTE
               ======================================== */
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                // Email ya registrado
                $error = 'Este email ya está registrado';
            } else {
                /* ========================================
                   CREAR NUEVO USUARIO
                   ======================================== */
                // Encriptar la contraseña de forma segura
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Insertar nuevo usuario en la base de datos
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
                
                if ($stmt->execute([$nombre, $email, $password_hash])) {
                    $success = 'Cuenta creada exitosamente. Ya puedes iniciar sesión.';
                } else {
                    $error = 'Error al crear la cuenta. Intenta nuevamente.';
                }
            }
        } else {
            $error = 'Las contraseñas no coinciden';
        }
    } else {
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
    <title>Registrarse - CrocMaster Store</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="styles/main.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <!-- ========================================
                     TARJETA DEL FORMULARIO DE REGISTRO
                     ======================================== -->
                <div class="card shadow">
                    <div class="card-body p-4">
                        <!-- Header del formulario -->
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">
                                <i class="fas fa-paw me-2"></i>CrocMaster Store
                            </h2>
                            <p class="text-muted">Crear Cuenta</p>
                        </div>

                        <!-- ========================================
                             MOSTRAR MENSAJES DE ERROR O ÉXITO
                             ======================================== -->
                        <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                        </div>
                        <?php endif; ?>

                        <!-- ========================================
                             FORMULARIO DE REGISTRO
                             ======================================== -->
                        <form method="POST">
                            <!-- Campo nombre completo -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required 
                                       value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                            </div>
                            
                            <!-- Campo email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            </div>
                            
                            <!-- Campo contraseña -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <!-- Campo confirmar contraseña -->
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            
                            <!-- Botón de envío -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">
                        
                        <!-- ========================================
                             ENLACES ADICIONALES
                             ======================================== -->
                        <div class="text-center">
                            <p class="mb-2">¿Ya tienes cuenta?</p>
                            <a href="login.php" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
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
