<?php
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    
    // Hardcoded secure prototype password
    if ($password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = 'Invalid administrative password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Faith Connect</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-card {
            background: rgba(15, 23, 42, 0.4);
            border: 2px solid var(--primary);
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

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border: 1px solid rgba(37, 99, 235, 0.3);
            border-radius: var(--radius-full);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="auth-body">
    <div class="mesh-bg"></div>

    <div class="auth-card animate-fade-in">
        <div class="auth-content">
            <div class="logo-container">
                <div class="admin-badge">
                    <i class="fa-solid fa-shield-halved"></i> Secure Access
                </div>
                <h1 class="brand-font" style="color: white; margin-top: 15px; font-size: 24px; letter-spacing: 2px;">ADMIN PORTAL</h1>
            </div>
            
            <h2 class="auth-title">Welcome Back</h2>
            <p class="auth-subtitle">Faith Connect Control Center</p>
            
            <?php if($error): ?>
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #FCA5A5; padding: 14px; border-radius: 14px; margin-bottom: 24px; text-align: center; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-group">
                    <label class="input-label">Administrative Master Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" placeholder="••••••••" required class="modern-input">
                        <i class="fa-solid fa-key" style="position: absolute; right: 18px; top: 50%; transform: translateY(-50%); color: var(--text-dim); opacity: 0.5;"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn-premium" style="box-shadow: 0 10px 20px var(--primary-glow);">
                    Authenticate Now <i class="fa-solid fa-unlock"></i>
                </button>
                
                <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05);">
                    <a href="login.php" class="primary-link" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 15px;">
                        <i class="fa-solid fa-arrow-left"></i> Return to Member Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
