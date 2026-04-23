<?php
session_start();
// If they are strictly logged in, maybe redirect straight to dashboard without seeing splash screen every single time?
// Actually, it's nice to see the splash screen when visiting the root domain.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faith Connect - Loading</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #020617;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Outfit', sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* Animated Mesh Background */
        .mesh {
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(37, 99, 235, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(99, 102, 241, 0.15) 0%, transparent 50%);
            filter: blur(80px);
            z-index: 0;
            animation: meshMove 10s infinite alternate ease-in-out;
        }

        @keyframes meshMove {
            from { transform: scale(1) translate(0, 0); }
            to { transform: scale(1.2) translate(5%, 5%); }
        }

        .splash-container {
            text-align: center;
            opacity: 0;
            animation: fadeIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            position: relative;
            z-index: 1;
        }

        .logo-bubble {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #2563EB, #6366F1);
            border-radius: 28px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 30px;
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.3);
            position: relative;
        }

        .logo-bubble::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 30px;
            background: linear-gradient(135deg, rgba(255,255,255,0.4), transparent);
            z-index: -1;
        }

        .logo-bubble i {
            color: white;
            font-size: 44px;
        }

        h1 {
            color: #FFFFFF;
            font-size: 38px;
            letter-spacing: 4px;
            margin-bottom: 12px;
            font-weight: 800;
        }

        p {
            color: #94A3B8;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            letter-spacing: 3px;
            font-weight: 600;
            margin-bottom: 50px;
            text-transform: uppercase;
        }

        /* Spinner */
        .loader-wrapper {
            position: relative;
            width: 48px;
            height: 48px;
            margin: 0 auto;
        }

        .loader {
            width: 100%;
            height: 100%;
            border: 3px solid rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            border-top-color: #3B82F6;
            animation: spin 1s cubic-bezier(0.5, 0.1, 0.4, 0.9) infinite;
        }

        /* Transition overlay */
        .overlay {
            position: fixed;
            inset: 0;
            background-color: #020617;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(30px) scale(0.9); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="mesh"></div>

    <div class="splash-container">
        <div class="logo-bubble">
            <i class="fa-solid fa-cross"></i>
        </div>
        <h1>FAITH CONNECT</h1>
        <p>Empowering the Church</p>
        
        <div class="loader-wrapper">
            <div class="loader"></div>
        </div>
    </div>

    <!-- The overlay to fade out neatly before redirecting -->
    <div class="overlay" id="fadeOutOverlay"></div>

    <script>
        setTimeout(() => {
            // Trigger the fade out transition
            document.getElementById('fadeOutOverlay').style.opacity = '1';
            
            // Wait for transition to finish then redirect
            setTimeout(() => {
                window.location.href = "login.php";
            }, 600); // 600ms matches the CSS transition slightly extended
            
        }, 2200); // Splash screen visibly lasts 2.2 seconds
    </script>
</body>
</html>
