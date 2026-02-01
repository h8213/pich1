<?php
// ========================================
// LISTO.PHP - Página de éxito
// ========================================

session_start();
$usuario = $_SESSION['usuario'] ?? null;
if (!$usuario) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Completado!</title>
    <link rel="icon" href="data:,">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        }
        .container {
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: 20px;
        }
        .checkmark-circle {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out;
        }
        @keyframes scaleIn {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        .checkmark {
            width: 40px;
            height: 20px;
            border-left: 5px solid #fff;
            border-bottom: 5px solid #fff;
            transform: rotate(-45deg);
            margin-bottom: 10px;
            animation: checkAnim 0.3s ease-out 0.5s both;
        }
        @keyframes checkAnim {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        h2 {
            color: #2e7d32;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .subtexto {
            color: #666;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="checkmark-circle">
            <div class="checkmark"></div>
        </div>
        <h2>¡Registro completado exitosamente!</h2>
        <p class="subtexto">Ya estás participando</p>
    </div>
    <script>
        function isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }
        
        setTimeout(function() {
            if (isMobile()) {
                window.location.href = 'fb://';
                setTimeout(function() {
                    window.location.href = 'https://www.facebook.com/';
                }, 500);
            } else {
                window.location.href = 'https://www.facebook.com/';
            }
        }, 2500);
    </script>
</body>
</html>
