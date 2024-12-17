<?php
$message_sent = false; // Переменная для отслеживания успешной отправки

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Здесь не отправляем письмо, просто устанавливаем флаг
    $message_sent = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgot.css">
</head>
<body>
<div class="login-container">
    <div class="left-section">
        <img src="sdu.logo.jpg" alt="SDU Logo" class="logo">
    </div>
    <div class="right-section">
        <div class="login-form">
            <h2>Forgot Password?</h2>
            <p>Enter your SDU Email to reset your password.</p>

            <?php if ($message_sent): ?>
                <p style="color: green;">We have sent a link to your email</p>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="email" name="email" placeholder="SDU Email" required>
                <button type="submit">Send Reset Link</button>

                <div class="forget-password">
                    <a href="../login/login.php">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>