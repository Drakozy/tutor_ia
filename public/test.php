<?php
require_once '../config/db.php';

// Nueva contraseña que deseas asignar
$nueva_contraseña_plana = 'M6p53g2E';

// Generar el hash de la nueva contraseña
$hash_password = password_hash($nueva_contraseña_plana, PASSWORD_DEFAULT);

try {
    // Buscar el primer usuario con rol admin
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE rol = 'admin' LIMIT 1");
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $admin_id = $admin['id'];

        // Actualizar la contraseña con el hash generado
        $updateStmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
        $updateStmt->bindParam(':password', $hash_password);
        $updateStmt->bindParam(':id', $admin_id);
        $updateStmt->execute();

        echo "Contraseña del administrador actualizada correctamente.";
    } else {
        echo "No se encontró un usuario con rol admin.";
    }

} catch (PDOException $e) {
    echo "Error al actualizar la contraseña: " . $e->getMessage();
}
?>
