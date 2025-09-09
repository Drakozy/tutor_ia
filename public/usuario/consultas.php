<?php
session_start();
require_once '../../config/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../acceso_denegado.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$sqlHistorial = $pdo->prepare("SELECT usuario_id, consulta, respuesta, fecha FROM consultas WHERE usuario_id = :usuario_id AND DATE(fecha) = CURDATE() ORDER BY fecha ASC");
$sqlHistorial->execute(['usuario_id' => $usuario_id]);
$consultasDelDia = $sqlHistorial->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta al Tutor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style> .chat-box { max-height: 400px; overflow-y: auto; padding: 10px; background-color: #f9f9f9; border-radius: 10px; margin-top: 20px; scroll-behavior: smooth; } .mensaje { display: flex; margin-bottom: 20px; } .mensaje.tu { justify-content: flex-end; } .mensaje.tutor { justify-content: flex-start; } .mensaje .bubble { max-width: 70%; padding: 10px; border-radius: 20px; font-size: 14px; line-height: 1.5; } .mensaje.tu .bubble { background-color: #0d6efd; color: white; } .mensaje.tutor .bubble { background-color: #e9ecef; color: black; } .spinner-container { display: none; text-align: center; margin-top: 20px; } </style>
</head>
<body style="background-color: #dce8f8;">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Consulta al Tutor</h2>
        <div class="d-flex align-items-center justify-content-between">
            <span class="me-3 h4 mb-0">Hola, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></span>
            <a href="../logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
        </div>
    </div>

    <!-- Historial de consultas en formato chat -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">Consultas de hoy</div>
        <div class="card-body chat-box" id="historialConsultas">
            <?php foreach ($consultasDelDia as $fila) : ?>
                <!-- Mostrar consulta del usuario -->
                <div class="mensaje <?= ($fila['usuario_id'] == $usuario_id) ? 'tu' : 'tutor' ?>">
                    <div class="bubble consulta">
                        <p><strong><?= ($fila['usuario_id'] == $usuario_id) ? 'Tú' : 'Tutor' ?>:</strong></p>
                        <p><?= nl2br(htmlspecialchars($fila['consulta'])) ?></p>
                    </div>
                </div>

                <!-- Mostrar respuesta del tutor -->
                <?php if ($fila['respuesta']) : ?>
                    <div class="mensaje tutor">
                        <div class="bubble respuesta">
                            <p><strong>Respuesta:</strong></p>
                            <p><?= nl2br(htmlspecialchars($fila['respuesta'])) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" id="formConsulta">
                <div class="mb-3">
                    <label for="consulta" class="card-header bg-primary text-white"><strong>Consulta:</strong></label>
                    <textarea name="consulta" id="consulta" class="form-control" rows="4" required placeholder="Escribe tu pregunta aquí..."></textarea>
                </div>
                <div class="col-12 text-end">
                    <a href="historial.php" class="btn btn-secondary ms-2">Regresar al historial</a>
                    <button type="submit" class="btn btn-primary ms-2" id="submitBtn">Enviar consulta</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Spinner de carga -->
    <div class="spinner-container" id="spinnerContainer">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#formConsulta').submit(function (e) {
        e.preventDefault();
        const consulta = $('#consulta').val().trim();

        if (consulta === '') return;

        $('#spinnerContainer').show();
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: 'procesar_consulta.php',
            data: { consulta: consulta },
            success: function () {
                location.reload();
            },
            error: function () {
                alert('Ocurrió un error al enviar la consulta');
                $('#spinnerContainer').hide();
                $('#submitBtn').prop('disabled', false);
            }
        });
    });

    // Scroll automático hacia el último mensaje
    const chatBox = document.getElementById('historialConsultas');
    chatBox.scrollTop = chatBox.scrollHeight;
});
</script>

</body>
</html>
