<?php
session_start();
require_once '../../config/db.php';

// Verificar si el usuario está autenticado y es admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../acceso_denegado.php');
    exit();
}

$mensaje = '';
$analista = null;

if (isset($_GET['id'])) {
    $id_analista = $_GET['id'];

    // Obtener detalles del analista
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id AND rol = 'analista'");
    $stmt->bindParam(':id', $id_analista);
    $stmt->execute();
    $analista = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$analista) {
        $mensaje = 'Analista no encontrado.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Analista</title>
</head>
<body>

<?php if ($mensaje) echo "<p>$mensaje</p>"; ?>

<?php if ($analista): ?>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($analista['nombre']); ?></p>
    <p><strong>Usuario:</strong> <?php echo htmlspecialchars($analista['usuario']); ?></p>
    <p><strong>Fecha de Registro:</strong> <?php echo htmlspecialchars($analista['fecha_registro']); ?></p>
<?php endif; ?>

</body>
</html>
