<?php
session_start();
require_once '../../config/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../acceso_denegado.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id']; // Asegúrate de tener este dato en la sesión
$mensaje = '';
$consultas = [];

// Obtener el nombre del usuario
$stmtUsuario = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = :usuario_id");
$stmtUsuario->bindParam(':usuario_id', $usuario_id);
$stmtUsuario->execute();
$usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
$nombre_usuario = $usuario ? $usuario['nombre'] : 'Usuario';

// Filtrar las consultas según los parámetros
$fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
$palabras_clave = isset($_POST['palabras_clave']) ? $_POST['palabras_clave'] : '';

// Eliminar los signos '%' en el valor mostrado en el input
$fecha_fin_input = $fecha_fin;
if ($fecha_fin) $fecha_fin .= ' 23:59:59';
$palabras_clave_formulario = str_replace('%', '', $palabras_clave);

$query = "SELECT * FROM consultas WHERE usuario_id = :usuario_id";

// Agregar filtros
if ($fecha_inicio) {
    $query .= " AND fecha >= :fecha_inicio";
}
if ($fecha_fin) {
    $query .= " AND fecha <= :fecha_fin";
}
if ($palabras_clave) {
    // Cambiar para que solo busque en la columna `consulta`
    $query .= " AND consulta LIKE :palabras_clave";
}

$stmt = $pdo->prepare($query);
$stmt->bindParam(':usuario_id', $usuario_id);

if ($fecha_inicio) {
    $stmt->bindParam(':fecha_inicio', $fecha_inicio);
}
if ($fecha_fin) {
    $stmt->bindParam(':fecha_fin', $fecha_fin);
}
if ($palabras_clave) {
    // Añadir '%' solo para la consulta SQL
    $palabras_clave_sql = "%" . $palabras_clave . "%";
    $stmt->bindParam(':palabras_clave', $palabras_clave_sql);
}

$stmt->execute();
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi historial de consultas</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Toast CSS (para mostrar el mensaje de validación) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-toast@1.0.0/dist/bootstrap-toast.min.css" rel="stylesheet">
</head>
<body style="background-color: #dce8f8;">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mi historial de consultas</h2>
        <div class="d-flex align-items-center justify-content-between">
            <span class="me-3 h4 mb-0">Hola, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></span>
            <a href="../logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="historial.php" class="row g-3" id="formFiltro">
                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= htmlspecialchars($fecha_inicio) ?>">
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?= htmlspecialchars($fecha_fin_input); ?>">
                </div>
                <div class="col-md-4">
                    <label for="palabras_clave" class="form-label">Palabras clave:</label>
                    <!-- Mostrar las palabras clave sin '%' -->
                    <input type="text" id="palabras_clave" name="palabras_clave" class="form-control" value="<?= htmlspecialchars($palabras_clave_formulario) ?>">
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary mt-2 ms-2">Filtrar</button>
                    <button type="button" class="btn btn-secondary mt-2 ms-2" id="limpiarFiltros">Limpiar filtros</button>
                    <a href="consultas.php" class="btn btn-success mt-2 ms-2">Realizar nueva consulta</a>
                </div>
            </form>
        </div>
    </div>

    <?php if (empty($consultas)) : ?>
        <div class="alert alert-info">No se han encontrado consultas.</div>
    <?php else : ?>
        <div class="table-responsive">
            <table id="consultasTable" class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Consulta</th>
                        <th>Respuesta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $consulta) : ?>
                        <tr>
                        <td><?= date('d/m/Y h:i A', strtotime($consulta['fecha'])); ?></td>
                            <td><?= htmlspecialchars($consulta['consulta']) ?></td>
                            <td><?= htmlspecialchars($consulta['respuesta']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Toast para validación -->
<div id="toast" class="toast align-items-center text-white bg-danger border-0 position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            La fecha de fin debe ser igual o posterior a la fecha de inicio.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap Toast JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-toast@1.0.0/dist/bootstrap-toast.min.js"></script>

<script>
$(document).ready(function() {
    // Inicializar DataTable y desactivar la opción de búsqueda
    $('#consultasTable').DataTable({
        searching: false,  // Desactivar la barra de búsqueda
        language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.2/i18n/es-ES.json'  // Configuración del idioma en español
    }
    });

    // Validar las fechas antes de enviar el formulario
    $('#formFiltro').submit(function(e) {
        const fechaInicio = new Date($('[name="fecha_inicio"]').val());
        const fechaFin = new Date($('[name="fecha_fin"]').val());

        if (fechaFin < fechaInicio) {
            e.preventDefault();  // Evitar que se envíe el formulario
            $('#toast').toast('show');  // Mostrar el mensaje de validación
        }
    });

    // Limpiar filtros
    $('#limpiarFiltros').click(function() {
        window.location.href = "historial.php";
    });

});
</script>

</body>
</html>
