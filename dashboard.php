<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['username'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faith Connect - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: var(--bg-light);
            min-height: 100vh;
        }

        .dashboard-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 60px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 8px 16px;
            background: white;
            border-radius: var(--radius-full);
            border: 1px solid #E2E8F0;
            transition: var(--transition);
            cursor: pointer;
        }

        .user-profile:hover {
            box-shadow: var(--shadow-sm);
            border-color: var(--primary);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
        }

        .logout-btn {
            color: #EF4444;
            font-size: 18px;
            transition: var(--transition);
        }

        .logout-btn:hover {
            transform: translateX(3px);
            filter: brightness(1.2);
        }

        .hero-section {
            padding: 80px 20px 60px;
            text-align: center;
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.05), transparent),
                        radial-gradient(circle at bottom left, rgba(99, 102, 241, 0.05), transparent);
        }

        .hero-section h1 {
            font-size: 48px;
            letter-spacing: -1px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <nav class="dashboard-nav glass">
        <div class="nav-brand">
            <div class="mini-logo">
                <i class="fa-solid fa-cross"></i>
            </div>
            <h2 class="brand-font" style="letter-spacing: 1px;">FAITH CONNECT</h2>
        </div>
        <div style="display: flex; align-items: center; gap: 25px;">
            <div class="user-profile">
                <div class="user-avatar"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                <span style="font-size: 14px; font-weight: 700; color: var(--text-main);">Hi, <?php echo htmlspecialchars($username); ?></span>
            </div>
            <a href="logout.php" class="logout-btn" title="Logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </div>
    </nav>

    <div class="hero-section animate-fade-in">
        <div class="content-container" style="padding: 0;">
            <div class="badge badge-primary" style="margin-bottom: 20px; font-size: 11px;">MEMBER DASHBOARD</div>
            <h1>Welcome to your <span class="text-gradient">Spiritual Hub</span></h1>
            <p class="subtitle" style="font-size: 18px; max-width: 600px; margin: 0 auto;">Everything you need to grow in faith and stay connected with your church family.</p>
        </div>
    </div>

    <div class="content-container">
        
        <div class="dashboard-grid">
            <a href="sermons.php" class="premium-card animate-fade-in" style="animation-delay: 0.1s;">
                <div class="card-icon"><i class="fa-solid fa-play"></i></div>
                <h3>Sermons</h3>
                <p>Watch and listen to the latest teachings from our pastors.</p>
            </a>
            
            <a href="news.php" class="premium-card animate-fade-in" style="animation-delay: 0.2s;">
                <div class="card-icon"><i class="fa-solid fa-bell"></i></div>
                <h3>Announcements</h3>
                <p>Stay updated with church events and news.</p>
            </a>
            
            <a href="giving.php" class="premium-card animate-fade-in" style="animation-delay: 0.3s;">
                <div class="card-icon"><i class="fa-solid fa-heart"></i></div>
                <h3>Giving</h3>
                <p>Support the ministry through tithes and offerings.</p>
            </a>
            
            <a href="prayers.php" class="premium-card animate-fade-in" style="animation-delay: 0.4s;">
                <div class="card-icon"><i class="fa-solid fa-hands-praying"></i></div>
                <h3>Prayers</h3>
                <p>Submit your prayer requests to our intercession team.</p>
            </a>
            
            <a href="devotions.php" class="premium-card animate-fade-in" style="animation-delay: 0.5s;">
                <div class="card-icon"><i class="fa-solid fa-book-open"></i></div>
                <h3>Daily Devotion</h3>
                <p>Start your day with spiritual nourishment.</p>
            </a>
            
            <a href="music.php" class="premium-card animate-fade-in" style="animation-delay: 0.6s;">
                <div class="card-icon"><i class="fa-solid fa-music"></i></div>
                <h3>Gospel Music</h3>
                <p>Listen to uplifting worship and praise songs.</p>
            </a>
        </div>

        <div style="text-align: center; margin-top: 60px; opacity: 0.5;">
            <a href="admin_login.php" style="color: var(--text-dim); font-size: 13px; font-weight: 500; text-decoration: none;">
                <i class="fa-solid fa-lock" style="margin-right: 5px;"></i> Access Admin Portal
            </a>
        </div>
    </div>
</body>
</html>
