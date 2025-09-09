<?php
$host = 'localhost';
$db = 'php_tutor';
$user = 'root';
$pass = ''; // cambia si tu XAMPP/MAMP tiene contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
