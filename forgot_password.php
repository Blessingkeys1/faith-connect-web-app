<?php
session_start();
require_once 'config.php';

$message = '';
$reset_link = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!empty($email)) {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            // Generate token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Store in database
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
            if ($stmt->execute([$email, $token, $expires])) {
                // Simulate email sending
                $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;
                $message = "<div style='color: green; margin-bottom: 20px;'>A password reset link has been generated. (Simulation)</div>";
            }
        } else {
            $message = "<div style='color: red; margin-bottom: 20px;'>If that email exists in our system, a reset link will be shown.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faith Connect - Forgot Password</title>
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

        .sim-box {
            background: rgba(30, 64, 175, 0.15);
            border: 1px solid rgba(30, 64, 175, 0.3);
            padding: 24px;
            border-radius: 16px;
            margin-bottom: 35px;
            color: white;
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
            
            <h2 class="auth-title">Password Reset</h2>
            <p class="auth-subtitle">We'll help you get back into your account</p>
            
            <?php if ($message): ?>
                <div style="margin-bottom: 25px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if ($reset_link): ?>
                <div class="sim-box animate-fade-in">
                    <p style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--primary); margin-bottom: 12px; letter-spacing: 1px;">
                        <i class="fa-solid fa-envelope" style="margin-right: 8px;"></i> Simulated Recovery Email
                    </p>
                    <p style="font-size: 14px; opacity: 0.8; margin-bottom: 15px; line-height: 1.5;">Click the secure link below to proceed with resetting your password.</p>
                    <a href="<?php echo $reset_link; ?>" class="primary-link" style="font-size: 13px; font-weight: 700; word-break: break-all; color: white; background: rgba(255,255,255,0.1); padding: 12px; border-radius: 8px; display: block;"><?php echo $reset_link; ?></a>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-group">
                    <label class="input-label">Recovery Email</label>
                    <input type="email" name="email" placeholder="name@example.com" required class="modern-input" <?php echo $reset_link ? 'disabled' : ''; ?>>
                </div>
                
                <button type="submit" class="btn-premium" <?php echo $reset_link ? 'disabled' : ''; ?>>
                    Request Reset Link <i class="fa-solid fa-paper-plane"></i>
                </button>
                
                <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05);">
                    <a href="login.php" class="primary-link" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 15px;">
                        <i class="fa-solid fa-arrow-left"></i> Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
