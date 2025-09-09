<?php
require_once '../../config/db.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../acceso_denegado.php');
    exit();
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // Validaciones de nombre, usuario y contraseña
    if (empty($nombre) || empty($usuario) || empty($password)) {
        $_SESSION['mensaje'] = 'Todos los campos son obligatorios.';
        $_SESSION['tipo'] = 'danger';  // Rojo para error
        header("Location: analistas.php");
        exit();
    }

    // Validar caracteres permitidos para nombre y usuario
    if (!preg_match('/^[a-zA-Z0-9 ]+$/', $nombre)) {
        $_SESSION['mensaje'] = 'El nombre solo puede contener letras, números y espacios.';
        $_SESSION['tipo'] = 'warning';  // Amarillo para advertencia
        header("Location: analistas.php");
        exit();
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $usuario)) {
        $_SESSION['mensaje'] = 'El nombre de usuario solo puede contener letras, números y guiones bajos.';
        $_SESSION['tipo'] = 'warning';  // Amarillo para advertencia
        header("Location: analistas.php");
        exit();
    } elseif (!preg_match('/^(?=.*\d)(?=.*[a-zA-Z]).{6,20}$/', $password)) {
        $_SESSION['mensaje'] = 'La contraseña debe tener entre 6 y 20 caracteres, incluyendo al menos un número y una letra.';
        $_SESSION['tipo'] = 'warning';  // Amarillo para advertencia
        header("Location: analistas.php");
        exit();
    } else {
        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioExistente) {
            if ($usuarioExistente['analista_aprobado'] == 0) {
                // Si el usuario existe pero está pendiente de aprobación
                $_SESSION['mensaje'] = "El usuario ya existe, pero está pendiente de aprobación.";
                $_SESSION['tipo'] = 'warning';  // Amarillo para advertencia
            } else {
                // Si el usuario ya está aprobado
                $_SESSION['mensaje'] = "El usuario ya existe.";
                $_SESSION['tipo'] = 'danger';  // Rojo para error
            }
        } else {
            // Insertar nuevo analista directamente aprobado
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, usuario, password, rol, analista_aprobado, fecha_registro) 
                                   VALUES (?, ?, ?, 'analista', 1, NOW())");
            $stmt->execute([$nombre, $usuario, $passwordHash]);

            $_SESSION['mensaje'] = "Analista creado exitosamente.";
            $_SESSION['tipo'] = 'success';  // Verde para éxito
        }
    }

    // Redirigir a la página de analistas con el mensaje
    header("Location: analistas.php");
    exit();
}
?>
