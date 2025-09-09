<?php
session_start();
require_once '../../config/db.php';

// Verificar si el usuario está autenticado y es admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../acceso_denegado.php');
    exit();
}

// Mensaje de éxito para la acción realizada
$mensaje = '';
$tipo_mensaje = 'success'; // Tipo de mensaje para el toast

// Procesar solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $accion = $_POST['accion'];

    if ($accion === 'aprobar') {
        $stmt = $pdo->prepare("UPDATE usuarios SET analista_aprobado = 1 WHERE id = ?");
        $mensaje = 'Solicitud aprobada';
        $tipo_mensaje = 'success';
    } elseif ($accion === 'rechazar') {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND rol = 'analista' AND analista_aprobado = 0");
        $mensaje = 'Solicitud rechazada';
        $tipo_mensaje = 'danger';
    }

    if (isset($stmt)) {
        $stmt->execute([$id_usuario]);
    }
}

// Obtener solicitudes pendientes
$stmt = $pdo->query("SELECT id, nombre, usuario FROM usuarios WHERE rol = 'analista' AND analista_aprobado = 0");
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Analistas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #dce8f8;">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Solicitudes de Analistas</h2>
        <a href="../logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
    </div>

    <a href="analistas.php" class="btn btn-secondary mb-3">← Volver a Gestión de Analistas</a>

    <?php if (count($solicitudes) === 0): ?>
        <div class="alert alert-info">No hay solicitudes pendientes.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($solicitudes as $sol): ?>
                        <tr>
                            <td><?= htmlspecialchars($sol['nombre']) ?></td>
                            <td><?= htmlspecialchars($sol['usuario']) ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id_usuario" value="<?= $sol['id'] ?>">
                                    <button type="submit" name="accion" value="aprobar" class="btn btn-success btn-sm">Aprobar</button>
                                </form>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id_usuario" value="<?= $sol['id'] ?>">
                                    <button type="submit" name="accion" value="rechazar" class="btn btn-danger btn-sm">Rechazar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Toast para mostrar mensaje de acción -->
<?php if ($mensaje): ?>
<div id="toast" class="toast align-items-center text-white bg-<?= $tipo_mensaje ?> border-0 position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            <?= $mensaje ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Mostrar el toast cuando se haya aprobado o rechazado la solicitud
    var toastEl = document.getElementById('toast');
    if (toastEl) {
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
});
</script>

</body>
</html>