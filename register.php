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
    <title>Faith Connect - Register</title>
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
                <h1 class="brand-font" style="color: white; margin-top: 15px; font-size: 24px; letter-spacing: 2px;">
                    FAITH CONNECT</h1>
            </div>

            <h2 class="auth-title">Join Us</h2>
            <p class="auth-subtitle">Start your spiritual journey today</p>

            <?php if (isset($_GET['error'])): ?>
                <div
                    style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #FCA5A5; padding: 14px; border-radius: 14px; margin-bottom: 24px; text-align: center; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <form action="auth.php" method="POST">
                <input type="hidden" name="action" value="register">

                <div class="input-group">
                    <label class="input-label">FullName</label>
                    <input type="text" name="username" placeholder="Blessing Keys" required class="modern-input">
                </div>

                <div class="input-group">
                    <label class="input-label">Email Address</label>
                    <input type="email" name="email" placeholder="name@example.com" required class="modern-input">
                </div>

                <div class="input-group">
                    <label class="input-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="regPassword" placeholder="••••••••" required
                            class="modern-input">
                        <i class="fa-solid fa-eye password-toggle" onclick="togglePassword('regPassword', this)"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Confirm Password</label>
                    <div style="position: relative;">
                        <input type="password" name="confirm_password" id="confirmPassword" placeholder="••••••••"
                            required class="modern-input">
                        <i class="fa-solid fa-eye password-toggle"
                            onclick="togglePassword('confirmPassword', this)"></i>
                    </div>
                </div>

                <div style="margin-bottom: 35px;">
                    <label
                        style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; color: var(--text-dim); font-size: 13px; line-height: 1.5;">
                        <input type="checkbox" required style="margin-top: 4px; accent-color: var(--primary);">
                        I agree to the <a href="#" class="primary-link">Terms of Service</a> and <a href="#"
                            class="primary-link">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="btn-premium">
                    Create Account <i class="fa-solid fa-user-plus"></i>
                </button>

                <div
                    style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05);">
                    <p style="font-size: 14px; color: var(--text-dim); margin-bottom: 12px;">Already have an account?
                    </p>
                    <a href="login.php" class="primary-link"
                        style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 15px;">
                        Login instead <i class="fa-solid fa-arrow-right"></i>
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