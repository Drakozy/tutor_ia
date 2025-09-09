<?php
session_start();
require_once '../config/db.php';

$mensaje = '';
$tipo = 'danger';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    if (empty($usuario) || empty($password)) {
        $mensaje = 'Debes completar todos los campos.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                if ($user['rol'] === 'analista' && $user['analista_aprobado'] == 0) {
                    $mensaje = 'Tu solicitud como analista está pendiente de aprobación.';
                } else {
                    $_SESSION['usuario'] = $user['usuario'];
                    $_SESSION['rol'] = $user['rol'];
                    $_SESSION['nombre'] = $user['nombre'];
                    $_SESSION['usuario_id'] = $user['id'];

                    header('Location: dashboard.php');
                    exit;
                }
            } else {
                $mensaje = 'Contraseña incorrecta.';
            }
        } else {
            $mensaje = 'Usuario no encontrado.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Tutor IA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/7.2.96/css/materialdesignicons.min.css">
</head>
<body class="d-flex align-items-center" style="height: 100vh; background-color: #dce8f8;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="text-center mb-4">Iniciar Sesión</h2>

                    <form method="POST" action="index.php">
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text" name="usuario" class="form-control" required
                                   pattern="[a-zA-Z0-9_]{3,20}"
                                   title="Solo letras, números y guiones bajos. Mínimo 3 y máximo 20 caracteres.">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="passwordLogin" required
                                       pattern=".{6,30}"
                                       title="Mínimo 6 y máximo 30 caracteres.">
                                    <button type="button" class="btn btn-outline-secondary btn-sm toggle-password" data-target="password">
                                        <i class="mdi mdi-eye"></i>
                                    </button>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>

                        <p class="text-center">¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
                    </form>
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
