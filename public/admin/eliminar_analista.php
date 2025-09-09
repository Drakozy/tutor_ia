<?php
// En eliminar_analista.php
session_start();
require_once '../../config/db.php';

// Verificar si el usuario está autenticado y es admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../acceso_denegado.php');
    exit();
}

$mensaje = '';

if (isset($_GET['id'])) {
    $id_analista = $_GET['id'];

    // Eliminar analista
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id AND rol = 'analista'");
    $stmt->bindParam(':id', $id_analista);

    if ($stmt->execute()) {
        $mensaje = 'Analista eliminado con éxito.';
    } else {
        $mensaje = 'Hubo un error al eliminar al analista.';
    }

    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = 'success';
}

header('Location: analistas.php');
exit();
?>
