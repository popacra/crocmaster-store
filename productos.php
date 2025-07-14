<?php
/* ========================================
   PÁGINA DE PRODUCTOS - OBTENER PARÁMETROS
   ======================================== */
require_once 'config/database.php';

// Obtener parámetros de la URL
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';  // Filtro por categoría
$producto_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;         // ID de producto específico

/* ========================================
   CONSULTA PARA PRODUCTO INDIVIDUAL
   ======================================== */
// Si se solicita un producto específico por ID
if ($producto_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ? AND activo = 1");
    $stmt->execute([$producto_id]);
    $producto_detalle = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* ========================================
   CONSULTA PARA LISTA DE PRODUCTOS
   ======================================== */
// Construir consulta base
$sql = "SELECT * FROM productos WHERE activo = 1";
$params = [];

// Si hay filtro por categoría, agregarlo a la consulta
if ($categoria) {
    $sql .= " AND categoria = ?";
    $params[] = $categoria;
}

// Ordenar por nombre y ejecutar consulta
$sql .= " ORDER BY nombre";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ========================================
         CONFIGURACIÓN DEL HEAD DINÁMICO
         ======================================== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título dinámico según si es producto individual o lista -->
    <title><?php echo $producto_detalle ? htmlspecialchars($producto_detalle['nombre']) : 'Productos'; ?> - PetFeeder Store</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="styles/main.css" rel="stylesheet">
</head>
<body>
    <!-- ========================================
         BARRA DE NAVEGACIÓN (IGUAL QUE INDEX)
         ======================================== -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-paw me-2"></i>PetFeeder Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menú con clases 'active' dinámicas según la página actual -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo !$categoria ? 'active' : ''; ?>" href="productos.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $categoria == 'comedero' ? 'active' : ''; ?>" href="productos.php?categoria=comedero">Comederos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $categoria == 'alimento' ? 'active' : ''; ?>" href="productos.php?categoria=alimento">Alimentos</a>
                    </li>
                </ul>
                
                <!-- Menú de usuario (igual que en index.php) -->
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <li class="nav-item">
                            <span class="navbar-text me-3">Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    <?php else: ?>
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

    <div class="container mt-4 py-4">
        <?php if ($producto_detalle): ?>
            <!-- ========================================
                 VISTA DE PRODUCTO INDIVIDUAL
                 ======================================== -->
            <!-- Breadcrumb para navegación -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="productos.php">Productos</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($producto_detalle['nombre']); ?></li>
                </ol>
            </nav>

            <div class="row">
                <!-- Columna izquierda: Imagen del producto -->
                <div class="col-lg-6 mb-4">
                    <img src="<?php echo htmlspecialchars($producto_detalle['imagen']); ?>" 
                         class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($producto_detalle['nombre']); ?>">
                </div>
                
                <!-- Columna derecha: Información del producto -->
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($producto_detalle['nombre']); ?></h1>
                    <p class="lead text-muted mb-4"><?php echo htmlspecialchars($producto_detalle['descripcion']); ?></p>
                    
                    <!-- Información de precio y stock -->
                    <div class="mb-4">
                        <span class="badge bg-secondary text-uppercase mb-2">
                            <?php echo $producto_detalle['categoria'] == 'comedero' ? 'Comedero Automático' : 'Alimento Premium'; ?>
                        </span>
                        <h2 class="text-primary">$<?php echo number_format($producto_detalle['precio'], 2); ?></h2>
                        <p class="text-success"><i class="fas fa-check-circle me-1"></i>En stock (<?php echo $producto_detalle['stock']; ?> disponibles)</p>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-grid gap-2 d-md-flex">
                        <button class="btn btn-primary btn-lg me-md-2" onclick="comprar(<?php echo $producto_detalle['id']; ?>)">
                            <i class="fas fa-shopping-cart me-2"></i>Comprar Ahora
                        </button>
                        <a href="productos.php" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Productos
                        </a>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- ========================================
                 VISTA DE LISTA DE PRODUCTOS
                 ======================================== -->
            <!-- Header con título dinámico y filtros -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6 fw-bold">
                    <?php 
                    if ($categoria == 'comedero') echo 'Comederos Automáticos';
                    elseif ($categoria == 'alimento') echo 'Alimentos Premium';
                    else echo 'Todos los Productos';
                    ?>
                </h1>
                
                <!-- Botones de filtro -->
                <div class="btn-group" role="group">
                    <a href="productos.php" class="btn <?php echo !$categoria ? 'btn-primary' : 'btn-outline-primary'; ?>">Todos</a>
                    <a href="productos.php?categoria=comedero" class="btn <?php echo $categoria == 'comedero' ? 'btn-primary' : 'btn-outline-primary'; ?>">Comederos</a>
                    <a href="productos.php?categoria=alimento" class="btn <?php echo $categoria == 'alimento' ? 'btn-primary' : 'btn-outline-primary'; ?>">Alimentos</a>
                </div>
            </div>

            <!-- Grid de productos -->
            <div class="row">
                <?php foreach ($productos as $producto): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <!-- Imagen del producto -->
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        
                        <div class="card-body d-flex flex-column">
                            <!-- Badge de categoría -->
                            <div class="mb-2">
                                <span class="badge bg-secondary">
                                    <?php echo $producto['categoria'] == 'comedero' ? 'Comedero' : 'Alimento'; ?>
                                </span>
                            </div>
                            
                            <!-- Información del producto -->
                            <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                            <p class="card-text text-muted flex-grow-1">
                                <?php echo htmlspecialchars(substr($producto['descripcion'], 0, 120)) . '...'; ?>
                            </p>
                            
                            <!-- Precio, stock y botones -->
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="h4 text-primary mb-0">$<?php echo number_format($producto['precio'], 2); ?></span>
                                    <small class="text-success">Stock: <?php echo $producto['stock']; ?></small>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="productos.php?id=<?php echo $producto['id']; ?>" class="btn btn-outline-primary">
                                        Ver Detalles
                                    </a>
                                    <button class="btn btn-primary" onclick="comprar(<?php echo $producto['id']; ?>)">
                                        <i class="fas fa-shopping-cart me-1"></i>Comprar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- ========================================
                 MENSAJE SI NO HAY PRODUCTOS
                 ======================================== -->
            <?php if (empty($productos)): ?>
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h3>No se encontraron productos</h3>
                <p class="text-muted">Intenta con otra categoría o vuelve más tarde.</p>
                <a href="productos.php" class="btn btn-primary">Ver Todos los Productos</a>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Footer (igual que en index.php) -->
    <footer class="bg-dark text-white py-4 mt-5">
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
         JAVASCRIPT Y FUNCIÓN DE COMPRA
         ======================================== -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para manejar la compra de productos
        function comprar(productoId) {
            <?php if (isset($_SESSION['usuario_id'])): ?>
                // Si el usuario está logueado, mostrar mensaje (funcionalidad en desarrollo)
                alert('¡Funcionalidad de compra en desarrollo! Producto ID: ' + productoId);
                // Aquí implementarías la lógica de compra real
            <?php else: ?>
                // Si no está logueado, redirigir al login
                alert('Debes iniciar sesión para comprar productos.');
                window.location.href = 'login.php';
            <?php endif; ?>
        }
    </script>
</body>
</html>
