<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faith Connect - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-card {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(25px);
            padding: 50px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 40px;
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

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 30px 0;
            color: var(--text-dim);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider span {
            padding: 0 15px;
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
            
            <h2 class="auth-title">Welcome Back</h2>
            <p class="auth-subtitle">Continue your spiritual journey</p>
            
            <?php if(isset($_GET['registered'])): ?>
                <div class="badge badge-primary" style="display: block; text-align: center; margin-bottom: 24px; padding: 12px; background: rgba(37, 99, 235, 0.2); color: #93C5FD; border: 1px solid rgba(37, 99, 235, 0.3);">Registration successful! Please login.</div>
            <?php endif; ?>

            <?php if(isset($_GET['donated'])): ?>
                <div class="badge badge-primary" style="display: block; text-align: center; margin-bottom: 24px; padding: 12px; background: rgba(34, 197, 94, 0.2); color: #86EFAC; border: 1px solid rgba(34, 197, 94, 0.3);">Thank you for your generous gift!</div>
            <?php endif; ?>

            <?php if(isset($_GET['reset'])): ?>
                <div class="badge badge-primary" style="display: block; text-align: center; margin-bottom: 24px; padding: 12px; background: rgba(37, 99, 235, 0.2); color: #93C5FD; border: 1px solid rgba(37, 99, 235, 0.3);">Password updated successfully!</div>
            <?php endif; ?>

            <?php if(isset($_GET['error'])): ?>
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #FCA5A5; padding: 14px; border-radius: 14px; margin-bottom: 24px; text-align: center; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <form action="auth.php" method="POST">
                <input type="hidden" name="action" value="login">
                
                <div class="input-group">
                    <label class="input-label">Email Address</label>
                    <input type="email" name="email" placeholder="name@example.com" required class="modern-input">
                </div>
                
                <div class="input-group">
                    <label class="input-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="loginPassword" placeholder="••••••••" required class="modern-input">
                        <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('loginPassword', this)"></i>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 35px; align-items: center;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text-dim); font-size: 13px;">
                        <input type="checkbox" style="accent-color: var(--primary);"> Remember me
                    </label>
                    <a href="forgot_password.php" class="primary-link" style="font-size: 13px;">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn-premium">
                    Login to Access <i class="fa-solid fa-arrow-right"></i>
                </button>
                
                <div class="divider">
                    <span>OR CONTINUE WITH</span>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <button type="button" class="btn-premium" style="background: rgba(255,255,255,0.05); color: white; border: 1px solid rgba(255,255,255,0.1); box-shadow: none; font-size: 14px; padding: 12px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" width="20">
                    </button>
                    <button type="button" class="btn-premium" style="background: rgba(255,255,255,0.05); color: white; border: 1px solid rgba(255,255,255,0.1); box-shadow: none; font-size: 14px; padding: 12px;">
                        <i class="fa-brands fa-apple" style="font-size: 20px;"></i>
                    </button>
                </div>

                <div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05);">
                    <p style="font-size: 14px; color: var(--text-dim); margin-bottom: 12px;">New to the platform?</p>
                    <a href="register.php" class="primary-link" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 15px;">
                        Create an account <i class="fa-solid fa-user-plus"></i>
                    </a>
                </div>

                <div style="text-align: center; margin-top: 25px;">
                    <a href="giving.php" class="primary-link" style="display: flex; align-items: center; justify-content: center; gap: 10px; opacity: 0.8; font-size: 14px;">
                        <i class="fa-solid fa-heart" style="color: var(--accent);"></i> Give anonymously
                    </a>
                </div>
            </form>
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
