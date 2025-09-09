<?php
// acceso_denegado.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Acceso Denegado</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #dce8f8;">

  <div class="text-center p-5 shadow-lg rounded bg-white">
    <h1 class="text-danger mb-4">⛔ Acceso Denegado</h1>
    <p class="mb-4">No tienes permiso para acceder a esta página. Por favor inicia sesión con una cuenta autorizada.</p>
    
    <a href="logout.php" class="btn btn-primary">Ir al Login</a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
