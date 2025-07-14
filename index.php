<?php
/* ========================================
   PÁGINA PRINCIPAL - OBTENER DATOS
   ======================================== */
require_once 'config/database.php';  // Incluir conexión a BD

// Consulta para obtener productos destacados (máximo 6)
$stmt = $pdo->query("SELECT * FROM productos WHERE activo = 1 LIMIT 6");
$productos_destacados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ========================================
         CONFIGURACIÓN DEL HEAD
         ======================================== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrocMaster Store - Comederos Automáticos para Mascotas</title>
    
    <!-- Enlaces a librerías externas -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="styles/main.css" rel="stylesheet">
</head>
<body>
    <!-- ========================================
         BARRA DE NAVEGACIÓN PRINCIPAL
         ======================================== -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <!-- Logo/Marca de la tienda -->
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-paw me-2"></i>CrocMaster Store
            </a>
            
            <!-- Botón hamburguesa para móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menú principal de navegación -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productos.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productos.php?categoria=comedero">Comederos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productos.php?categoria=alimento">Alimentos</a>
                    </li>
                </ul>
                
                <!-- ========================================
                     MENÚ DE USUARIO (LOGIN/LOGOUT)
                     ======================================== -->
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <!-- Si el usuario está logueado -->
                        <li class="nav-item">
                            <span class="navbar-text me-3">Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    <?php else: ?>
                        <!-- Si el usuario NO está logueado -->
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registro.php">Registrarse</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ========================================
         SECCIÓN HERO (PORTADA PRINCIPAL)
         ======================================== -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <!-- Columna izquierda: Texto principal -->
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-white mb-4">
                        Comederos Automáticos para tus Mascotas
                    </h1>
                    <p class="lead text-white mb-4">
                        Mantén a tu mascota bien alimentada con nuestros comederos automáticos de alta calidad y alimentos premium. Tecnología y nutrición para el bienestar de tu mejor amigo.
                    </p>
                    <!-- Botones de acción principales -->
                    <div class="d-flex gap-3">
                        <a href="productos.php" class="btn btn-warning btn-lg px-4">
                            <i class="fas fa-shopping-cart me-2"></i>Ver Productos
                        </a>
                        <a href="#productos-destacados" class="btn btn-outline-light btn-lg px-4">
                            Conocer Más
                        </a>
                    </div>
                </div>
                <!-- Columna derecha: Imagen principal -->
                <div class="col-lg-6 text-center">
                    <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=500&h=400&fit=crop" 
                         alt="Comedero Automático" class="img-fluid rounded-3 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         SECCIÓN DE CARACTERÍSTICAS PRINCIPALES
         ======================================== -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <!-- Característica 1: Alimentación Programada -->
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                        <h4>Alimentación Programada</h4>
                        <p class="text-muted">Programa horarios de comida automáticos para mantener la rutina de tu mascota.</p>
                    </div>
                </div>
                <!-- Característica 2: Control Remoto -->
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-wifi fa-3x text-primary mb-3"></i>
                        <h4>Control Remoto</h4>
                        <p class="text-muted">Controla el comedero desde tu smartphone, estés donde estés.</p>
                    </div>
                </div>
                <!-- Característica 3: Alimentos Premium -->
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-heart fa-3x text-primary mb-3"></i>
                        <h4>Alimentos Premium</h4>
                        <p class="text-muted">Ofrecemos alimentos balanceados de la más alta calidad nutricional.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================
         SECCIÓN DE PRODUCTOS DESTACADOS
         ======================================== -->
    <section id="productos-destacados" class="py-5">
        <div class="container">
            <!-- Título de la sección -->
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Productos Destacados</h2>
                <p class="lead text-muted">Descubre nuestros productos más populares</p>
            </div>
            
            <!-- Grid de productos -->
            <div class="row">
                <?php foreach ($productos_destacados as $producto): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <!-- Imagen del producto -->
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        
                        <!-- Contenido de la tarjeta -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                            <p class="card-text text-muted flex-grow-1">
                                <?php echo htmlspecialchars(substr($producto['descripcion'], 0, 100)) . '...'; ?>
                            </p>
                            
                            <!-- Precio y botón -->
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h4 text-primary mb-0">$<?php echo number_format($producto['precio'], 2); ?></span>
                                <a href="productos.php?id=<?php echo $producto['id']; ?>" class="btn btn-primary">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Botón para ver todos los productos -->
            <div class="text-center mt-4">
                <a href="productos.php" class="btn btn-outline-primary btn-lg">Ver Todos los Productos</a>
            </div>
        </div>
    </section>

    <!-- ========================================
         FOOTER DE LA PÁGINA
         ======================================== -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-paw me-2"></i>PetFeeder Store</h5>
                    <p class="text-muted">Tu tienda de confianza para comederos automáticos y alimentos para mascotas.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">&copy; 2024 PetFeeder Store. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- ========================================
         SCRIPTS DE JAVASCRIPT
         ======================================== -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
