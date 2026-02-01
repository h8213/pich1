<?php
session_start();
header('Content-Type: application/json');

$sessionId = isset($_SESSION['user_session_id']) ? $_SESSION['user_session_id'] : '';

if (empty($sessionId)) {
    echo json_encode(['status' => 'no_session']);
    exit;
}

$sessionFile = __DIR__ . '/sessions/' . $sessionId . '.txt';

if (file_exists($sessionFile)) {
    $status = file_get_contents($sessionFile);
    echo json_encode(['status' => trim($status)]);
} else {
    echo json_encode(['status' => 'not_found']);
}
?>
