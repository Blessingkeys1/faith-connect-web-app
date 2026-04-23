<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($email) || empty($password)) {
            header("Location: register.php?error=" . urlencode("Please fill in all required fields."));
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: register.php?error=" . urlencode("Invalid email format."));
            exit;
        }

        if (strlen($password) < 6) {
            header("Location: register.php?error=" . urlencode("Password must be at least 6 characters."));
            exit;
        }

        if ($password !== $confirm_password) {
            header("Location: register.php?error=" . urlencode("Passwords do not match."));
            exit;
        }

        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        if ($stmt->fetch()) {
            header("Location: register.php?error=" . urlencode("Email or Username already exists."));
            exit;
        }

        // Hash and store
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$username, $email, $hash])) {
            header("Location: login.php?registered=1");
            exit;
        } else {
            header("Location: register.php?error=" . urlencode("Registration failed. Please try again."));
            exit;
        }

    } elseif ($action === 'login') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            header("Location: login.php?error=" . urlencode("Please provide email and password."));
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Login success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            header("Location: login.php?error=" . urlencode("Invalid email or password."));
            exit;
        }
    }
}
?>
