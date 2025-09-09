<?php
session_start();

// Verifica que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario_id'], $_SESSION['rol'])) {
    header("Location: acceso_denegado.php");
    exit;
}

// Redirige según el rol
switch ($_SESSION['rol']) {
    case 'admin':
        header("Location: admin/analistas.php");
        exit;
    case 'analista':
        header("Location: analista/historial_usuarios.php");
        exit;
    case 'usuario':
        header("Location: usuario/historial.php");
        exit;
    default:
        // Rol desconocido, cerrar sesión por seguridad
        session_destroy();
        header("Location: acceso_denegado.php");
        exit;
}
