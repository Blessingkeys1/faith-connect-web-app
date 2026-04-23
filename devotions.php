<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$stmt = $pdo->query("SELECT * FROM devotions ORDER BY date DESC LIMIT 1");
$devotion = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Devotions</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
    <style>
        .devotion-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px 100px;
        }

        .devotion-card {
            background: white;
            border-radius: var(--radius-xl);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: var(--shadow-premium);
            transition: var(--transition);
        }

        .devotion-hero {
            position: relative;
            height: 400px;
            overflow: hidden;
        }

        .devotion-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .devotion-card:hover .devotion-hero img {
            transform: scale(1.05);
        }

        .devotion-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.4));
        }

        .devotion-content {
            padding: 60px;
            position: relative;
        }

        .devotion-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .devotion-title {
            font-size: 42px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .devotion-meta {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .scripture-box {
            padding: 40px;
            background: #F8FAFC;
            border-radius: var(--radius-lg);
            border-left: 6px solid var(--primary);
            margin-bottom: 45px;
            position: relative;
        }

        .scripture-box i {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 40px;
            color: var(--primary);
            opacity: 0.1;
        }

        .scripture-text {
            font-size: 20px;
            line-height: 1.6;
            color: var(--text-main);
            font-weight: 600;
            font-style: italic;
        }

        .devotion-body-text {
            font-size: 17px;
            line-height: 1.9;
            color: var(--text-dim);
            margin-bottom: 50px;
        }

        .devotion-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 40px;
            border-top: 1px solid #F1F5F9;
        }

        .btn-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            border: 1px solid #E2E8F0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-main);
            transition: var(--transition);
        }

        .btn-circle:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <nav class="dashboard-nav glass">
        <div class="nav-brand">
            <a href="dashboard.php" class="mini-logo"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 class="brand-font" style="letter-spacing: 1px;">DAILY DEVOTION</h2>
        </div>
        <div class="badge badge-primary animate-fade-in" style="font-size: 10px;">REFLECTIONS</div>
    </nav>

    <div class="devotion-container animate-fade-in">
        <?php if($devotion): ?>
            <div class="devotion-card">
                <div class="devotion-hero">
                    <img src="https://images.unsplash.com/photo-1504052434569-70ad5836ab65?auto=format&fit=crop&q=80&w=1200" alt="Devotion Header">
                </div>
                
                <div class="devotion-content">
                    <div class="devotion-header">
                        <div class="badge badge-primary" style="margin-bottom: 20px; font-size: 11px;">TODAY'S WORD</div>
                        <h1 class="devotion-title"><?php echo htmlspecialchars($devotion['title']); ?></h1>
                        <div class="devotion-meta">
                            <span><i class="fa-regular fa-calendar" style="margin-right: 8px;"></i> <?php echo date('F d, Y', strtotime($devotion['date'])); ?></span>
                            <span>•</span>
                            <span><i class="fa-solid fa-user-tie" style="margin-right: 8px;"></i> <?php echo htmlspecialchars($devotion['author'] ?? 'SANCTUARY PASTOR'); ?></span>
                        </div>
                    </div>

                    <div class="scripture-box">
                        <i class="fa-solid fa-quote-right"></i>
                        <p class="scripture-text">
                            "<?php echo htmlspecialchars($devotion['scripture'] ?? 'The Lord is my shepherd; I shall not want.'); ?>"
                        </p>
                    </div>

                    <div class="devotion-body-text">
                        <?php echo nl2br(htmlspecialchars($devotion['content'])); ?>
                    </div>

                    <div class="devotion-footer">
                        <div style="display: flex; gap: 12px;">
                            <a href="#" class="btn-circle" title="Share"><i class="fa-solid fa-share-nodes"></i></a>
                            <a href="#" class="btn-circle" title="Add to Library"><i class="fa-regular fa-bookmark"></i></a>
                        </div>
                        <a href="dashboard.php" class="btn-premium" style="width: auto; padding: 15px 30px;">
                            Finish Reading <i class="fa-solid fa-check" style="margin-left: 8px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="glass" style="padding: 120px 40px; text-align: center; border-radius: var(--radius-xl); background: rgba(255,255,255,0.5);">
                <div style="width: 100px; height: 100px; background: #F1F5F9; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 30px;">
                    <i class="fa-solid fa-book-open" style="font-size: 42px; opacity: 0.2;"></i>
                </div>
                <h2 style="color: var(--text-main); font-size: 28px; font-weight: 800; margin-bottom: 12px;">No Devotion Today</h2>
                <p style="color: var(--text-dim); font-size: 16px;">We're currently preparing a fresh word for you. Please check back later.</p>
                <a href="dashboard.php" class="btn-premium" style="width: auto; margin-top: 30px; display: inline-flex;">Go Back Home</a>
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 50px;">
            <p style="font-size: 15px; color: var(--text-dim); font-weight: 600;">Want to strengthen your walk? <a href="#" class="primary-link" style="color: var(--primary); margin-left: 5px;">Browse Devotion Archive</a></p>
        </div>
    </div>
</body>
</html>
</body>
</html>
