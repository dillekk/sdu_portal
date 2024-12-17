<?php
// Enable error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = "localhost";
$username = "root"; // Default username for XAMPP/WAMP/MAMP
$password = ""; // Default password is empty
$dbname = "sdu_portal"; // Replace with your database name

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = trim($_POST['id']);
    $password = trim($_POST['password']);

    try {
        // Query to find the student by ID
        $stmt = $conn->prepare("SELECT * FROM student WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and verify the password
        if ($user && $password === $user['password']) {
            // Store user information in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name']; // Assuming a 'name' column exists
            $_SESSION['user_email'] = $user['email']; // Assuming an 'email' column exists

            // Redirect to profile page
            header("Location: ../profile/profile.php");
            exit();
        } else {
            $message = "Invalid ID or password!";
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDU University Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="login-container">
    <div class="left-section">
        <img src="sdu.logo.jpg" alt="SDU Logo" class="logo">
    </div>

    <div class="right-section">
        <div class="login-form">
            <h2>Sign-in</h2>
            <form method="POST" action="login.php">
                <input type="text" name="id" placeholder="Student ID" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>

                <div class="forget-password">
                    <a href="../forgot/forgot.php">Forget password?</a>
                </div>
            </form>
            <?php if (!empty($message)): ?>
                <p style="color: red; margin-top: 15px;"><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
