<?php
session_start();
require_once '../../config/db.php';

// Verificar si el usuario está autenticado y es analista
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'analista') {
    header('Location: ../acceso_denegado.php');
    exit();
}

$mensaje = '';
$consultas = [];
$usuarios = [];

// Obtener todos los usuarios para el combo box
$stmtUsuarios = $pdo->prepare("SELECT id, nombre FROM usuarios WHERE rol = 'usuario' ORDER BY nombre");
$stmtUsuarios->execute();
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

// Filtrando las consultas
$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin = $_POST['fecha_fin'] ?? '';
$palabras_clave_consulta = $_POST['palabras_clave_consulta'] ?? '';
$palabras_clave_respuesta = $_POST['palabras_clave_respuesta'] ?? '';
$usuario_id = $_POST['usuario_id'] ?? '';

// Guardar copias limpias para mostrar en los inputs
$fecha_inicio_input = $fecha_inicio;
$fecha_fin_input = $fecha_fin;
$palabras_clave_consulta_input = str_replace('%', '', $palabras_clave_consulta);
$palabras_clave_respuesta_input = str_replace('%', '', $palabras_clave_respuesta);

// Modificar fecha_fin para incluir hasta las 23:59:59
if ($fecha_fin) $fecha_fin .= ' 23:59:59';
if ($palabras_clave_consulta) $palabras_clave_consulta = "%$palabras_clave_consulta%";
if ($palabras_clave_respuesta) $palabras_clave_respuesta = "%$palabras_clave_respuesta%";

$query = "SELECT * FROM consultas WHERE 1";
if ($fecha_inicio) $query .= " AND fecha >= :fecha_inicio";
if ($fecha_fin) $query .= " AND fecha <= :fecha_fin";
if ($palabras_clave_consulta) $query .= " AND consulta LIKE :palabras_clave_consulta";
if ($palabras_clave_respuesta) $query .= " AND respuesta LIKE :palabras_clave_respuesta";
if ($usuario_id) $query .= " AND usuario_id = :usuario_id";

$stmt = $pdo->prepare($query);

if ($fecha_inicio) $stmt->bindParam(':fecha_inicio', $fecha_inicio);
if ($fecha_fin) $stmt->bindParam(':fecha_fin', $fecha_fin);
if ($palabras_clave_consulta) $stmt->bindParam(':palabras_clave_consulta', $palabras_clave_consulta);
if ($palabras_clave_respuesta) $stmt->bindParam(':palabras_clave_respuesta', $palabras_clave_respuesta);
if ($usuario_id) $stmt->bindParam(':usuario_id', $usuario_id);

$stmt->execute();
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Consultas - Analista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style> .select2-container--default .select2-selection--single { padding-top: 1.1rem !important; padding-bottom: 1.1rem !important; display: flex; align-items: center; border: 1px solid #ced4da !important;  /* Gris más suave */ color: #ced4da !important;             /* Texto seleccionado */ position: relative; } .select2-container--default .select2-selection--single .select2-selection__placeholder { color: #ced4da !important;             /* Placeholder gris claro */ } .select2-container--default .select2-selection__arrow { top: 50% !important; transform: translateY(-50%) !important; position: absolute; right: 1rem; } .select2-container--default .select2-selection--single .select2-selection__arrow b { border-color: #ced4da transparent transparent transparent !important;  /* Flechita gris clara */ } </style>
</head>
<body style="background-color: #dce8f8;">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Historial de Consultas</h2>
        <div class="d-flex align-items-center justify-content-between">
            <span class="me-3 h4 mb-0">Hola, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></span>
            <a href="../logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form id="formFiltro" method="POST" action="historial_usuarios.php" class="row g-3">
                <div class="col-md-4">
                    <label for="usuario_id" class="form-label">Usuario:</label>
                    <select name="usuario_id" id="usuario_id" class="form-select">
                        <option value="">Seleccione un usuario</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id']; ?>" <?= ($usuario_id == $usuario['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($usuario['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="palabras_clave_consulta" class="form-label">Palabras clave en Consulta:</label>
                    <input type="text" name="palabras_clave_consulta" class="form-control" value="<?= $palabras_clave_consulta_input; ?>">
                </div>

                <div class="col-md-4">
                    <label for="palabras_clave_respuesta" class="form-label">Palabras clave en Respuesta:</label>
                    <input type="text" name="palabras_clave_respuesta" class="form-control" value="<?= $palabras_clave_respuesta_input; ?>">
                </div>

                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?= $fecha_inicio; ?>">
                </div>

                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?= $fecha_fin_input; ?>">
                </div>

                <div class="col-12 text-end">
                    <button type="button" class="btn btn-secondary mt-2 ms-2" id="limpiarFiltros">Limpiar filtros</button>
                    <button type="submit" class="btn btn-primary mt-2 ms-2">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (empty($consultas)) : ?>
        <div class="alert alert-warning text-center">No se han encontrado consultas.</div>
    <?php else : ?>
        <div class="table-responsive">
            <table id="consultasTable" class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Consulta</th>
                        <th>Respuesta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $consulta) : ?>
                        <tr>
                            <td><?= date('d/m/Y h:i A', strtotime($consulta['fecha'])); ?></td>
                            <td>
                                <?php
                                $stmtUser = $pdo->prepare("SELECT nombre FROM usuarios WHERE id = :id");
                                $stmtUser->bindParam(':id', $consulta['usuario_id']);
                                $stmtUser->execute();
                                $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);
                                echo htmlspecialchars($usuario['nombre']);
                                ?>
                            </td>
                            <td><?= htmlspecialchars($consulta['consulta']); ?></td>
                            <td><?= nl2br(htmlspecialchars($consulta['respuesta'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Toast -->
<div id="toast" class="toast align-items-center text-white bg-danger border-0 position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            La fecha de fin debe ser igual o posterior a la fecha de inicio.
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    // Inicializar DataTable sin buscador
    $('#consultasTable').DataTable({
        searching: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    // Activar Select2 en el combobox
    $('#usuario_id').select2({
        placeholder: "Buscar usuario...",
    });

    // Validar las fechas antes de enviar el formulario
    $('#formFiltro').submit(function(e) {
        const fechaInicio = new Date($('#fecha_inicio').val());
        const fechaFin = new Date($('#fecha_fin').val());

        if (fechaFin < fechaInicio) {
            e.preventDefault();  // Evitar que se envíe el formulario
            $('#toast').toast('show');  // Mostrar el mensaje de validación
        }
    });

    // Limpiar filtros (redirige sin POST)
    $('#limpiarFiltros').click(function() {
        window.location.href = "historial_usuarios.php";
    });

});
</script>
</body>
</html>
