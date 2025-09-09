<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../acceso_denegado.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener analistas aprobados
$query = "SELECT id, nombre, usuario, fecha_registro FROM usuarios WHERE rol = 'analista' AND analista_aprobado = 1";
$stmt = $pdo->prepare($query);
$stmt->execute();
$analistas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener notificaciones
$stmtNoti = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'analista' AND analista_aprobado = 0");
$notificaciones = $stmtNoti->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Analistas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap y DataTables -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/7.2.96/css/materialdesignicons.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body style="background-color: #dce8f8;">

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Analistas</h2>
    <div>
      <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#crearAnalistaModal">Agregar Nuevo Analista</button>
      <a href="solicitudes.php" class="btn btn-primary position-relative me-2">
        Solicitudes
        <?php if ($notificaciones > 0): ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $notificaciones ?></span>
        <?php endif; ?>
      </a>
      <a href="../logout.php" class="btn btn-outline-danger me-2">Cerrar sesión</a>
    </div>
  </div>

  <div class="card shadow">
    <div class="card-body">
      <table id="analistasTable" class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($analistas as $analista): ?>
            <tr>
              <td><?= htmlspecialchars($analista['nombre']) ?></td>
              <td><?= htmlspecialchars($analista['usuario']) ?></td>
              <td><?= htmlspecialchars($analista['fecha_registro']) ?></td>
              <td>
                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#detallesModal" data-id="<?= $analista['id'] ?>">Ver</button>
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarEliminarModal" data-id="<?= $analista['id'] ?>">Eliminar</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Toasts -->
<?php if (isset($_SESSION['mensaje'], $_SESSION['tipo'])): ?>
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="toastMensaje" class="toast text-white bg-<?= $_SESSION['tipo'] ?> border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body"><?= $_SESSION['mensaje'] ?></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Modal crear analista -->
<div class="modal fade" id="crearAnalistaModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="crear_analista.php">
      <div class="modal-header">
        <h5 class="modal-title">Crear Nuevo Analista</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nombre:</label>
          <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Usuario:</label>
          <input type="text" name="usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" required
                        pattern=".{6,30}"
                        title="Mínimo 6 y máximo 30 caracteres.">
                    <button type="button" class="btn btn-outline-secondary btn-sm toggle-password" data-target="password">
                        <i class="mdi mdi-eye"></i>
                    </button>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Crear Analista</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal detalles -->
<div class="modal fade" id="detallesModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalles del Analista</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detallesContenido">
        <p>Cargando detalles...</p>
      </div>
    </div>
  </div>
</div>

<!-- Modal eliminar -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="GET" action="eliminar_analista.php">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar este analista?
        <input type="hidden" name="id" id="analistaEliminarId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger">Eliminar</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Mostrar/ocultar contraseña con clase .toggle-password
  document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function () {
      const targetId = this.getAttribute('data-target');
      const input = document.getElementById(targetId);

      if (input) {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        const icon = this.querySelector('i');
        icon.classList.toggle('mdi-eye');
        icon.classList.toggle('mdi-eye-off');
      }
    });
  });


  $('#detallesModal').on('show.bs.modal', function (event) {
    const id = $(event.relatedTarget).data('id');
    $('#detallesContenido').html('Cargando...');
    $.get('ver_detalles.php', { id }, function (data) {
      $('#detallesContenido').html(data);
    });
  });

  $('#confirmarEliminarModal').on('show.bs.modal', function (event) {
    const id = $(event.relatedTarget).data('id');
    $('#analistaEliminarId').val(id);
  });

  $(document).ready(function () {
    $('#analistasTable').DataTable({ language: { url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es_es.json' } });

    <?php if (isset($_SESSION['mensaje'], $_SESSION['tipo'])): ?>
    new bootstrap.Toast(document.getElementById('toastMensaje')).show();
    <?php unset($_SESSION['mensaje'], $_SESSION['tipo']); ?>
    <?php endif; ?>

  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
