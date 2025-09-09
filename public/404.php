<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logueado = isset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página no encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> .error-container { max-width: 500px; padding: 30px; background-color: #ffffff; border-radius: 15px; box-shadow: 0 0 15px rgba(0,0,0,0.1); } </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100" style="background-color: #dce8f8;">
    <div class="text-center error-container">
        <h1 class="display-1 text-danger fw-bold">404</h1>
        <p class="h4 mb-4">La página que buscas no existe</p>
        <?php if ($logueado): ?>
            <a href="../dashboard.php" class="btn btn-primary">Ir al Panel</a>
        <?php else: ?>
            <a href="index.php" class="btn btn-outline-secondary">Iniciar sesión</a>
        <?php endif; ?>
    </div>
</body>
</html>
