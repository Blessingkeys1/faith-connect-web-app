<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM music ORDER BY created_at DESC");
$songs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worship Music - Faith Connect</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .music-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .music-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid rgba(0,0,0,0.05);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
        }

        .music-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-premium);
        }

        .music-thumb-container {
            position: relative;
            width: 100%;
            aspect-ratio: 1;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .music-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .music-card:hover .music-thumb {
            transform: scale(1.05);
        }

        .music-play-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: var(--transition);
            cursor: pointer;
        }

        .music-card:hover .music-play-overlay {
            opacity: 1;
        }

        .play-icon-pulse {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--primary);
            font-size: 18px;
            box-shadow: 0 0 0 10px rgba(255,255,255,0.2);
            animation: pulse-small 2s infinite;
        }

        @keyframes pulse-small {
            0% { box-shadow: 0 0 0 0 rgba(255,255,255,0.4); }
            70% { box-shadow: 0 0 0 15px rgba(255,255,255,0); }
            100% { box-shadow: 0 0 0 0 rgba(255,255,255,0); }
        }

        .music-info {
            flex-grow: 1;
        }

        .music-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 5px;
            color: var(--text-main);
        }

        .music-artist {
            font-size: 14px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .music-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 12px;
            color: var(--text-dim);
        }

        .music-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-action {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 12px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dim);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-action:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 8px 16px var(--primary-glow);
        }
    </style>
</head>
<body>
    <nav class="dashboard-nav glass">
        <div class="nav-brand">
            <a href="dashboard.php" class="mini-logo"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 class="brand-font" style="letter-spacing: 1px;">WORSHIP MUSIC</h2>
        </div>
        <div class="search-bar-container animate-fade-in">
            <div class="search-inner">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search for tracks or artists..." class="search-input">
            </div>
        </div>
    </nav>

    <div class="content-container animate-fade-in" style="padding-top: 40px;">
        <div class="page-header-alt">
            <div class="badge badge-primary" style="margin-bottom: 15px; font-size: 11px; background: rgba(236, 72, 153, 0.1); color: var(--accent); border: 1px solid rgba(236, 72, 153, 0.2);">MELODIES OF HEAVEN</div>
            <h1 style="font-size: 42px; font-weight: 800;">Uplifting <span class="text-gradient">Sounds</span></h1>
            <p class="subtitle" style="font-size: 18px;">"Enter His gates with thanksgiving and His courts with praise." — Psalm 100:4</p>
        </div>

        <div class="category-scroll">
            <div class="cat-chip active">All Tracks</div>
            <div class="cat-chip">Spirit-led Worship</div>
            <div class="cat-chip">High Praise</div>
            <div class="cat-chip">Classical Hymns</div>
            <div class="cat-chip">Instrumentals</div>
        </div>

        <div class="music-grid">
            <?php foreach($songs as $index => $song): ?>
            <?php 
                $img_src = !empty($song['cover_image_url']) ? $song['cover_image_url'] : 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=400'; 
                $delay = ($index * 0.1);
            ?>
            <div class="music-card animate-fade-in" style="animation-delay: <?php echo $delay; ?>s;">
                <div class="music-thumb-container">
                    <img src="<?php echo htmlspecialchars($img_src); ?>" alt="Music Cover" class="music-thumb">
                    <a href="<?php echo htmlspecialchars($song['url'] ?? '#'); ?>" target="_blank" class="music-play-overlay">
                        <div class="play-icon-pulse">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </a>
                </div>
                <div class="music-info">
                    <h3 class="music-title"><?php echo htmlspecialchars($song['title']); ?></h3>
                    <p class="music-artist"><?php echo htmlspecialchars($song['artist']); ?></p>
                    <div class="music-meta">
                        <span><i class="fa-solid fa-music" style="margin-right: 5px;"></i> <?php echo htmlspecialchars($song['category'] ?? 'Gospel'); ?></span>
                        <span><i class="fa-regular fa-clock" style="margin-right: 5px;"></i> <?php echo htmlspecialchars($song['duration'] ?? '4:30'); ?></span>
                    </div>
                </div>
                <div class="music-actions">
                    <button class="btn-action"><i class="fa-solid fa-plus"></i> Playlist</button>
                    <a href="<?php echo htmlspecialchars($song['url'] ?? '#'); ?>" target="_blank" class="btn-action" style="background: var(--primary); color: white; border-color: var(--primary);"><i class="fa-solid fa-play"></i> Listen</a>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($songs)): ?>
                <div class="glass" style="grid-column: 1 / -1; padding: 100px; text-align: center; border-radius: var(--radius-xl); color: var(--text-dim); background: rgba(255,255,255,0.5);">
                    <div style="width: 80px; height: 80px; background: #F1F5F9; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 25px;">
                        <i class="fa-solid fa-headphones" style="font-size: 32px; opacity: 0.3;"></i>
                    </div>
                    <h3 style="color: var(--text-main); margin-bottom: 10px;">No music tracks found</h3>
                    <p>We're currently uploading new worship tracks. Stay tuned!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>