<?php
session_start();
require_once 'config.php';

$token = $_GET['token'] ?? '';
$message = '';
$valid_token = false;

if (!empty($token)) {
    // Validate token
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $reset = $stmt->fetch();
    if ($reset) {
        $valid_token = true;
    } else {
        $message = "<div style='color: red; margin-bottom: 20px;'>Invalid or expired reset link.</div>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($password) || strlen($password) < 6) {
        $message = "<div style='color: red; margin-bottom: 20px;'>Password must be at least 6 characters.</div>";
    } elseif ($password !== $confirm_password) {
        $message = "<div style='color: red; margin-bottom: 20px;'>Passwords do not match.</div>";
    } else {
        // Hash and update
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        if ($stmt->execute([$hash, $reset['email']])) {
            // Delete token
            $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->execute([$reset['email']]);
            
            header("Location: login.php?reset=1");
            exit;
        } else {
            $message = "<div style='color: red; margin-bottom: 20px;'>Failed to update password.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faith Connect - Reset Password</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-card {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(25px);
            padding: 50px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
            max-width: 500px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-title {
            font-size: 32px;
            font-weight: 800;
            color: white;
            margin-bottom: 10px;
            text-align: center;
        }

        .auth-subtitle {
            text-align: center;
            color: var(--text-dim);
            font-size: 15px;
            margin-bottom: 40px;
        }

        .primary-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .primary-link:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-dim);
        }
    </style>
</head>
<body class="auth-body">
    <div class="mesh-bg"></div>

    <div class="auth-card animate-fade-in">
        <div class="auth-content">
            <div class="logo-container">
                <div class="logo-bubble">
                    <i class="fa-solid fa-cross"></i>
                </div>
                <h1 class="brand-font" style="color: white; margin-top: 15px; font-size: 24px; letter-spacing: 2px;">FAITH CONNECT</h1>
            </div>
            
            <h2 class="auth-title">New Password</h2>
            <p class="auth-subtitle">Secure your account with a strong password</p>
            
            <?php if ($message): ?>
                <div style="margin-bottom: 25px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if ($valid_token): ?>
                <form method="POST">
                    <div class="input-group">
                        <label class="input-label">New Password</label>
                        <div style="position: relative;">
                            <input type="password" name="password" id="newPassword" placeholder="••••••••" required class="modern-input">
                            <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('newPassword', this)"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Confirm Password</label>
                        <div style="position: relative;">
                            <input type="password" name="confirm_password" id="confirmPassword" placeholder="••••••••" required class="modern-input">
                            <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('confirmPassword', this)"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-premium">
                        Update Password <i class="fa-solid fa-shield-halved"></i>
                    </button>
                </form>
            <?php else: ?>
                <div style="text-align: center; padding: 20px 0;">
                    <a href="forgot_password.php" class="btn-premium" style="width: auto; padding: 12px 24px;">
                        Request New Link <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>
            <?php endif; ?>
            
            <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05);">
                <a href="login.php" class="primary-link" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 15px;">
                    Return to Login <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
