<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$stmt = $pdo->query("SELECT * FROM announcements ORDER BY date DESC");
$news = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Announcements</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
    <style>
        .news-grid {
            display: flex;
            flex-direction: column;
            gap: 24px;
            max-width: 800px;
            margin: 0 auto;
        }

        .news-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 32px;
            border: 1px solid rgba(0,0,0,0.05);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: rgba(37, 99, 235, 0.1);
        }

        .news-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
        }

        .news-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .news-category {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 6px 14px;
            background: #F1F5F9;
            color: var(--text-dim);
            border-radius: var(--radius-full);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .news-date {
            font-size: 12px;
            color: var(--text-dim);
            font-weight: 600;
        }

        .news-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .news-content {
            font-size: 15px;
            line-height: 1.7;
            color: var(--text-dim);
            margin-bottom: 20px;
            white-space: pre-wrap;
        }

        .news-footer {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid #F1F5F9;
        }

        .news-location {
            font-size: 13px;
            color: var(--primary);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .event-dot {
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 4px var(--primary-glow);
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <nav class="dashboard-nav glass">
        <div class="nav-brand">
            <a href="dashboard.php" class="mini-logo"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 class="brand-font" style="letter-spacing: 1px;">CHURCH NEWS</h2>
        </div>
        <div class="badge badge-primary animate-fade-in" style="font-size: 10px;">LATEST UPDATES</div>
    </nav>

    <div class="content-container animate-fade-in" style="padding-top: 60px;">
        <div class="page-header" style="text-align: center; margin-bottom: 60px;">
            <div class="badge badge-primary" style="margin-bottom: 15px; font-size: 11px;">STAY CONNECTED</div>
            <h1 style="font-size: 48px; font-weight: 800;">What's <span class="text-gradient">Happening</span></h1>
            <p class="subtitle" style="font-size: 18px; max-width: 600px; margin: 0 auto;">Keep up with our latest announcements, events, and testimonies from the Faith Connect family.</p>
        </div>

        <div class="news-grid">
            <?php foreach($news as $index => $item): ?>
            <div class="news-card animate-fade-in" style="animation-delay: <?php echo ($index * 0.1) ?>s;">
                <div class="news-header">
                    <span class="news-category"><?php echo htmlspecialchars($item['category'] ?? 'General'); ?></span>
                    <span class="news-date"><i class="fa-regular fa-clock" style="margin-right: 5px;"></i> <?php echo date('M d, Y', strtotime($item['date'])); ?></span>
                </div>
                <h3 class="news-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                <div class="news-content"><?php echo htmlspecialchars($item['content']); ?></div>
                
                <?php if(!empty($item['location'])): ?>
                <div class="news-footer">
                    <div class="news-location">
                        <span class="event-dot"></span>
                        <i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($item['location']); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($news)): ?>
                <div class="glass" style="padding: 100px; text-align: center; border-radius: var(--radius-xl); color: var(--text-dim); background: rgba(255,255,255,0.5);">
                    <div style="width: 80px; height: 80px; background: #F1F5F9; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 25px;">
                        <i class="fa-solid fa-bullhorn" style="font-size: 32px; opacity: 0.3;"></i>
                    </div>
                    <h3 style="color: var(--text-main); margin-bottom: 10px;">No announcements yet</h3>
                    <p>We'll post updates here soon. Stay tuned!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</body>
</html>
