<?php
session_start();
require_once '../../config/db.php';
$config = require '../../config/cohere.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../acceso_denegado.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $consulta = trim($_POST['consulta']);
    $usuario_id = $_SESSION['usuario_id'];

    if (empty($consulta)) {
        exit();
    }

    try {
        // Obtener respuesta de Cohere
        $respuesta = obtenerRespuestaCohere($consulta);

        // Si la respuesta es válida, guardar la consulta y la respuesta en la base de datos
        if ($respuesta !== 'Lo siento, no pude obtener una respuesta en este momento.') {
            // Guardar consulta con respuesta
            $stmt = $pdo->prepare("INSERT INTO consultas (consulta, respuesta, usuario_id) VALUES (:consulta, :respuesta, :usuario_id)");
            $stmt->bindParam(':consulta', $consulta);
            $stmt->bindParam(':respuesta', $respuesta);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();

            // Obtener el id de la consulta insertada
            $consulta_id = $pdo->lastInsertId();

            // Devolver HTML para insertar en el historial
            echo '
            <div class="mensaje">
                <p><strong>Tú:</strong> ' . htmlspecialchars($consulta) . '</p>
                <p><strong>Respuesta del tutor:</strong> ' . nl2br(htmlspecialchars($respuesta)) . '</p>
                <hr>
            </div>';
        } else {
            // Si no se obtiene respuesta, no guardamos nada en la base de datos
            echo '<p>No se pudo obtener una respuesta. Intenta nuevamente más tarde.</p>';
        }

    } catch (Exception $e) {
        // Si ocurre algún error, mostrar un mensaje y no guardar nada en la base de datos
        echo '<p>Error al procesar la consulta: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
}

// Función para llamar a Cohere
function obtenerRespuestaCohere($consulta) {
    global $config;  // Acceder al array de configuración

    $apiKey = $config['api_key'];

    $url = 'https://api.cohere.ai/v1/generate';

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ];

    $prompt = "Responde en español de forma clara, corta y precisa.\n\nPregunta: $consulta";

    $data = [
        'model' => 'command',
        'prompt' => $prompt,
        'max_tokens' => 600,
        'temperature' => 0.7
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception('Error en la conexión con Cohere: ' . curl_error($ch));
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['generations'][0]['text'])) {
        return trim($responseData['generations'][0]['text']);
    } else {
        return 'Lo siento, no pude obtener una respuesta en este momento.';
    }
}
