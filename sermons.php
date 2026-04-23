<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$stmt = $pdo->query("SELECT * FROM sermons ORDER BY date DESC");
$sermons = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Sermons</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
    <style>
        .page-header-alt {
            padding: 60px 0 40px;
        }

        .search-bar-container {
            position: relative;
            flex-grow: 1;
            max-width: 500px;
            margin: 0 40px;
        }

        .search-inner {
            position: relative;
            width: 100%;
        }

        .search-inner i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            font-size: 16px;
        }

        .search-input {
            width: 100%;
            padding: 14px 14px 14px 50px;
            border-radius: var(--radius-full);
            border: 1px solid rgba(0,0,0,0.1);
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            outline: none;
            font-size: 15px;
            transition: var(--transition);
        }

        .search-input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: var(--shadow-md);
        }

        .category-scroll {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding: 10px 0 30px;
            scrollbar-width: none;
        }

        .category-scroll::-webkit-scrollbar { display: none; }

        .cat-chip {
            padding: 10px 24px;
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: var(--radius-full);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
            color: var(--text-dim);
        }

        .cat-chip:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .cat-chip.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 8px 16px var(--primary-glow);
        }

        .sermon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .sermon-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            transition: var(--transition);
            position: relative;
        }

        .sermon-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-premium);
        }

        .sermon-thumb-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .sermon-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .sermon-card:hover .sermon-thumb {
            transform: scale(1.1);
        }

        .play-overlay {
            position: absolute;
            inset: 0;
            background: rgba(37, 99, 235, 0.4);
            backdrop-filter: blur(4px);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: var(--transition);
        }

        .sermon-card:hover .play-overlay {
            opacity: 1;
        }

        .play-btn-circle {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--primary);
            font-size: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            transform: scale(0.8);
            transition: var(--transition);
        }

        .sermon-card:hover .play-btn-circle {
            transform: scale(1);
        }

        .sermon-body {
            padding: 24px;
        }

        .sermon-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .sermon-cat-badge {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary);
            background: rgba(37, 99, 235, 0.1);
            padding: 4px 10px;
            border-radius: 4px;
        }

        .sermon-duration {
            font-size: 12px;
            color: var(--text-dim);
            font-weight: 600;
        }

        .sermon-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 8px;
            line-height: 1.4;
            color: var(--text-main);
        }

        .sermon-pastor {
            font-size: 14px;
            color: var(--text-dim);
            margin-bottom: 15px;
        }

        .sermon-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #F1F5F9;
        }

        .sermon-date {
            font-size: 12px;
            color: var(--text-dim);
        }
    </style>
</head>
<body>
    <nav class="dashboard-nav glass">
        <div class="nav-brand">
            <a href="dashboard.php" class="mini-logo"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 class="brand-font" style="letter-spacing: 1px;">SERMONS</h2>
        </div>
        <div class="search-bar-container animate-fade-in">
            <div class="search-inner">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search for messages, pastors or topics..." class="search-input">
            </div>
        </div>
    </nav>

    <div class="content-container animate-fade-in" style="padding-top: 40px;">
        <div class="page-header-alt">
            <div class="badge badge-primary" style="margin-bottom: 15px; font-size: 11px;">DISCOVER WISDOM</div>
            <h1 style="font-size: 42px; font-weight: 800;">Recent <span class="text-gradient">Teachings</span></h1>
            <p class="subtitle" style="font-size: 18px;">Deepen your faith with these spirit-filled messages from our sanctuary.</p>
        </div>

        <div class="category-scroll">
            <div class="cat-chip active">All Messages</div>
            <div class="cat-chip">Faith & Purpose</div>
            <div class="cat-chip">Healing & Grace</div>
            <div class="cat-chip">Leadership</div>
            <div class="cat-chip">Family Life</div>
            <div class="cat-chip">Prayer</div>
        </div>

        <div class="sermon-grid">
            <?php foreach($sermons as $index => $sermon): ?>
            <?php 
                $img_src = !empty($sermon['image_url']) ? $sermon['image_url'] : (($index % 2 == 0) ? 'images/img 1.jpg' : 'images/img2.jpg'); 
                $delay = ($index * 0.1);
            ?>
            <a href="<?php echo htmlspecialchars($sermon['url'] ?? '#'); ?>" target="_blank" class="sermon-card animate-fade-in" style="animation-delay: <?php echo $delay; ?>s; text-decoration: none;">
                <div class="sermon-thumb-container">
                    <img src="<?php echo htmlspecialchars($img_src); ?>" alt="Sermon Cover" class="sermon-thumb">
                    <div class="play-overlay">
                        <div class="play-btn-circle">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </div>
                </div>
                <div class="sermon-body">
                    <div class="sermon-meta">
                        <span class="sermon-cat-badge"><?php echo htmlspecialchars($sermon['category'] ?? 'Teaching'); ?></span>
                        <span class="sermon-duration"><i class="fa-regular fa-clock" style="margin-right: 5px;"></i> <?php echo htmlspecialchars($sermon['duration']); ?></span>
                    </div>
                    <h3 class="sermon-title"><?php echo htmlspecialchars($sermon['title']); ?></h3>
                    <p class="sermon-pastor">by <?php echo htmlspecialchars($sermon['pastor']); ?></p>
                    
                    <div class="sermon-footer">
                        <span class="sermon-date"><i class="fa-regular fa-calendar" style="margin-right: 5px;"></i> <?php echo date('M d, Y', strtotime($sermon['date'])); ?></span>
                        <span style="color: var(--primary); font-weight: 700; font-size: 13px;">Listen Now <i class="fa-solid fa-chevron-right" style="font-size: 10px; margin-left: 5px;"></i></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
            
            <?php if(empty($sermons)): ?>
                <div class="glass" style="grid-column: 1 / -1; padding: 100px; text-align: center; border-radius: var(--radius-xl); color: var(--text-dim); background: rgba(255,255,255,0.5);">
                    <div style="width: 80px; height: 80px; background: #F1F5F9; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 25px;">
                        <i class="fa-solid fa-cloud-moon" style="font-size: 32px; opacity: 0.3;"></i>
                    </div>
                    <h3 style="color: var(--text-main); margin-bottom: 10px;">No sermons found</h3>
                    <p>We're currently updating our library. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
