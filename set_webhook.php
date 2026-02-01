<?php
/**
 * Configura el webhook de Telegram.
 * Abre esta URL una vez en el navegador (desde tu Heroku):
 * https://pichi-5d7869caf014.herokuapp.com/set_webhook.php
 */
header('Content-Type: text/plain; charset=utf-8');

include 'data.php';

$baseUrl = 'https://pichi-5d7869caf014.herokuapp.com';
$webhookUrl = $baseUrl . '/webhook.php';

$apiUrl = "https://api.telegram.org/bot{$botToken}/setWebhook";
$postData = ['url' => $webhookUrl];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

if ($data && !empty($data['ok'])) {
    echo "Webhook configurado correctamente.\n";
    echo "URL: " . $webhookUrl . "\n";
    echo "Respuesta: " . $response . "\n";
} else {
    echo "Error al configurar el webhook.\n";
    echo "HTTP: " . $httpCode . "\n";
    echo "Respuesta: " . $response . "\n";
}
