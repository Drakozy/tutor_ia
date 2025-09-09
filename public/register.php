<?php
require_once '../config/db.php';

$mensaje = '';
$tipo = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    if (empty($nombre) || empty($usuario) || empty($password) || empty($rol)) {
        $mensaje = 'Todos los campos son obligatorios.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            if ($resultado['rol'] === 'analista' && $resultado['analista_aprobado'] == 0) {
                $mensaje = 'Tu cuenta como analista ya fue registrada y está pendiente de aprobación.';
                $tipo = 'warning';
            } else {
                $mensaje = 'El nombre de usuario ya está en uso.';
                $tipo = 'danger';
            }
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $analista_aprobado = ($rol === 'analista') ? 0 : 1;
            $fecha_registro = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, usuario, password, rol, analista_aprobado, fecha_registro) 
                                   VALUES (:nombre, :usuario, :password, :rol, :analista_aprobado, :fecha_registro)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':password', $hash);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':analista_aprobado', $analista_aprobado);
            $stmt->bindParam(':fecha_registro', $fecha_registro);

            if ($stmt->execute()) {
                $mensaje = 'Usuario registrado exitosamente.';
                $tipo = 'success';
            } else {
                $mensaje = 'Error al registrar usuario.';
                $tipo = 'danger';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Tutor IA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/7.2.96/css/materialdesignicons.min.css">
</head>
<body style="background-color: #dce8f8;">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Registro de Usuario</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="register.php">
                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" name="nombre" required
                                   pattern="[a-zA-ZÀ-ÿ\s]{3,50}"
                                   title="Solo letras y espacios. Mínimo 3 y máximo 50 caracteres.">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" name="usuario" required
                                   pattern="[a-zA-Z0-9_]{3,20}"
                                   title="Solo letras, números y guiones bajos. Mínimo 3 y máximo 20 caracteres.">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="passwordRegister" required
                                       pattern=".{6,30}"
                                       title="Mínimo 6 y máximo 30 caracteres.">
                                    <button type="button" class="btn btn-outline-secondary btn-sm toggle-password" data-target="password">
                                        <i class="mdi mdi-eye"></i>
                                    </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select class="form-select" name="rol" required>
                                <option value="usuario">Usuario</option>
                                <option value="analista">Analista</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a></p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Toast -->
<?php if (!empty($mensaje)) : ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div class="toast show align-items-center text-bg-<?= $tipo ?> border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <?= htmlspecialchars($mensaje) ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-target');
        const input = document.querySelector(`input[name="${targetId}"]`);
        const icon = btn.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('mdi-eye');
            icon.classList.add('mdi-eye-off');
        } else {
            input.type = 'password';
            icon.classList.remove('mdi-eye-off');
            icon.classList.add('mdi-eye');
        }
    });
});
</script>
</body>
</html>
