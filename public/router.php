<?php
session_start();

// Obtiene la ruta solicitada
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

// Elimina `/php_Tutor/public` del path si es necesario (ajusta según tu estructura real)
$basePath = '/php_Tutor/public';
$cleanPath = str_replace($basePath, '', $path);

// Ruta completa física en el servidor
$fullPath = __DIR__ . $cleanPath;

// Si existe el archivo, lo carga normalmente
if (file_exists($fullPath) && !is_dir($fullPath)) {
    return require $fullPath;
}

// Si no existe, muestra 404
http_response_code(404);
require '404.php';
