<?php
session_start();
require_once 'config.php';

// Authenticate Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

$message = '';
$messageType = '';

// Handle Sermon Upload 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_sermon') {
    $title = $_POST['title'] ?? '';
    $pastor = $_POST['pastor'] ?? '';
    $url = $_POST['url'] ?? '';
    $category = $_POST['category'] ?? 'Faith';
    $duration = $_POST['duration'] ?? '1h';
    $date = date('Y-m-d'); // default to today
    $image_url = null;

    // Handle Image Upload
    if (isset($_FILES['sermon_image']) && $_FILES['sermon_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['sermon_image']['tmp_name'];
        $fileName = $_FILES['sermon_image']['name'];
        $fileSize = $_FILES['sermon_image']['size'];
        $fileType = $_FILES['sermon_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'webp');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './images/sermons/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $image_url = 'images/sermons/' . $newFileName;
            }
        }
    }
    
    if (!empty($title) && !empty($url)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO sermons (title, pastor, url, category, duration, date, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $pastor, $url, $category, $duration, $date, $image_url]);
            $message = "Sermon uploaded successfully!";
            $messageType = "success";
        } catch(PDOException $e) {
            $message = "Database Error: " . $e->getMessage();
            $messageType = "error";
        }
    } else {
        $message = "Title and URL are required.";
        $messageType = "error";
    }
}

// Handle Music Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_music') {
    $title = $_POST['title'] ?? '';
    $artist = $_POST['artist'] ?? '';
    $url = $_POST['url'] ?? '';
    $category = $_POST['category'] ?? 'Worship';
    $duration = $_POST['duration'] ?? '4:00';
    $cover_image_url = null;

    // Handle Image Upload
    if (isset($_FILES['music_image']) && $_FILES['music_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['music_image']['tmp_name'];
        $fileName = $_FILES['music_image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'webp');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './images/music/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $cover_image_url = 'images/music/' . $newFileName;
            }
        }
    }
    
    if (!empty($title) && !empty($artist) && !empty($url)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO music (title, artist, url, category, duration, cover_image_url) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $artist, $url, $category, $duration, $cover_image_url]);
            $message = "Music uploaded successfully!";
            $messageType = "success";
        } catch(PDOException $e) {
            $message = "Database Error: " . $e->getMessage();
            $messageType = "error";
        }
    } else {
        $message = "Title, Artist, and URL are required.";
        $messageType = "error";
    }
}

// Handle Clear All Music
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear_music') {
    try {
        // Clear DB
        $stmt = $pdo->prepare("DELETE FROM music");
        $stmt->execute();
        $count = $stmt->rowCount();
        
        // Clear Files
        $dir = './images/music/';
        $files = glob($dir . '*');
        foreach ($files as $file) {
            if (is_file($file)) unlink($file);
        }
        
        $message = "Successfully cleared $count music tracks and all uploaded covers.";
        $messageType = "success";
    } catch(PDOException $e) {
        $message = "Database Error: " . $e->getMessage();
        $messageType = "error";
    }
}


// Handle Announcement (News) Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_announcement') {
    $author = $_POST['author'] ?? 'Admin';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $date = date('Y-m-d');

    if (!empty($content)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO announcements (author, title, content, date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$author, $title, $content, $date]);
            $message = "Announcement published successfully!";
            $messageType = "success";
        } catch(PDOException $e) {
            $message = "Database Error: " . $e->getMessage();
            $messageType = "error";
        }
    } else {
        $message = "Announcement content is required.";
        $messageType = "error";
    }
}

// Handle Devotion Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_devotion') {
    $title = $_POST['title'] ?? '';
    $scripture = $_POST['scripture'] ?? '';
    $content = $_POST['content'] ?? '';
    $date = date('Y-m-d');
    $image_url = null;

    // Handle Image Upload
    if (isset($_FILES['devotion_image']) && $_FILES['devotion_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['devotion_image']['tmp_name'];
        $fileName = $_FILES['devotion_image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'webp');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './images/devotions/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $image_url = 'images/devotions/' . $newFileName;
            }
        }
    }
    
    if (!empty($title) && !empty($scripture) && !empty($content)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO devotions (title, date, scripture, content, image_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $date, $scripture, $content, $image_url]);
            $message = "Daily devotion updated successfully!";
            $messageType = "success";
        } catch(PDOException $e) {
            $message = "Database Error: " . $e->getMessage();
            $messageType = "error";
        }
    } else {
        $message = "Title, Scripture, and Content are required.";
        $messageType = "error";
    }
}

// Fetch Analytics
$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$sermonCount = $pdo->query("SELECT COUNT(*) FROM sermons")->fetchColumn();
$prayerCount = $pdo->query("SELECT COUNT(*) FROM prayer_requests")->fetchColumn();

// Fetch Data for Tables
$prayersStmt = $pdo->query("SELECT * FROM prayer_requests ORDER BY created_at DESC LIMIT 10");
$prayers = $prayersStmt->fetchAll();

$usersStmt = $pdo->query("SELECT id, username, email, DATE(created_at) as join_date FROM users ORDER BY created_at DESC LIMIT 15");
$members = $usersStmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
        }

        body {
            background: #F8FAFC;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: #0F172A;
            color: white;
            padding: 40px 24px;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 50px;
            padding: 0 12px;
        }

        .sidebar-brand i {
            font-size: 24px;
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            border-radius: 12px;
            color: #94A3B8;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .nav-item.active {
            color: var(--primary);
            background: rgba(37, 99, 235, 0.1);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 40px 60px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .admin-title h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .admin-title p {
            color: var(--text-dim);
            font-weight: 600;
        }

        /* Analytics Cards */
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 50px;
        }

        .analytic-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #F1F5F9;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
        }

        .analytic-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-premium);
        }

        .icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
        }

        .val-text {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-main);
            display: block;
        }

        .label-text {
            font-size: 14px;
            color: var(--text-dim);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Management Sections */
        .mgmt-section {
            background: white;
            border-radius: 24px;
            border: 1px solid #F1F5F9;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .section-header h2 {
            font-size: 24px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .grid-forms {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        /* Forms */
        .form-group label {
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 10px;
            font-size: 14px;
        }

        .modern-input {
            background: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
            color: var(--text-main) !important;
        }

        .modern-input:focus {
            background: white !important;
            border-color: var(--primary) !important;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #F1F5F9;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            background: #F8FAFC;
            padding: 16px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            color: #64748B;
            letter-spacing: 1px;
            border-bottom: 1px solid #F1F5F9;
        }

        .admin-table td {
            padding: 20px;
            border-bottom: 1px solid #F1F5F9;
            font-size: 14px;
            font-weight: 600;
            color: #1E293B;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .badge-pill {
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .success-bg { background: rgba(34, 197, 94, 0.1); color: #15803D; }
        .info-bg { background: rgba(59, 130, 246, 0.1); color: #1D4ED8; }
        .danger-bg { background: rgba(239, 68, 68, 0.1); color: #B91C1C; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-hand-holding-heart"></i>
            <h2 class="brand-font" style="letter-spacing: 1px; font-size: 20px;">FAITH CONNECT</h2>
        </div>
        
        <div class="nav-links">
            <a href="#overview" class="nav-item active"><i class="fa-solid fa-chart-pie"></i> Overview</a>
            <a href="#sermons" class="nav-item"><i class="fa-solid fa-microphone-lines"></i> Sermons</a>
            <a href="#music" class="nav-item"><i class="fa-solid fa-music"></i> Music Library</a>
            <a href="#devotions" class="nav-item"><i class="fa-solid fa-book-bible"></i> Daily Devotion</a>
            <a href="#members" class="nav-item"><i class="fa-solid fa-users"></i> Members</a>
            <a href="#prayers" class="nav-item"><i class="fa-solid fa-hands-praying"></i> Prayer Hall</a>
        </div>

        <div style="padding: 24px; border-top: 1px solid rgba(255,255,255,0.05);">
            <a href="logout.php" class="nav-item" style="color: #F87171;"><i class="fa-solid fa-power-off"></i> Secure Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header class="admin-header">
            <div class="admin-title">
                <h1>Control Center</h1>
                <p>Welcome back, Administrator</p>
            </div>
            <div class="header-actions">
                <a href="dashboard.php" class="btn-premium" style="width: auto; padding: 12px 24px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-eye"></i> View Site
                </a>
            </div>
        </header>

        <?php if(!empty($message)): ?>
            <div class="animate-fade-in" style="padding: 20px; border-radius: 16px; margin-bottom: 30px; font-weight: 700; display: flex; align-items: center; gap: 12px; 
                background: <?php echo $messageType === 'success' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)'; ?>; 
                color: <?php echo $messageType === 'success' ? '#15803D' : '#B91C1C'; ?>;
                border: 1px solid <?php echo $messageType === 'success' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(239, 68, 68, 0.2)'; ?>;">
                <i class="fa-solid <?php echo $messageType === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Analytics Overview -->
        <section class="analytics-grid" id="overview">
            <div class="analytic-card">
                <div class="icon-circle" style="background: rgba(37, 99, 235, 0.1); color: var(--primary);">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="val-text"><?php echo number_format($userCount); ?></span>
                    <span class="label-text">Total Members</span>
                </div>
            </div>
            <div class="analytic-card">
                <div class="icon-circle" style="background: rgba(139, 92, 246, 0.1); color: #8B5CF6;">
                    <i class="fa-solid fa-hands-praying"></i>
                </div>
                <div>
                    <span class="val-text"><?php echo number_format($prayerCount); ?></span>
                    <span class="label-text">Requests Received</span>
                </div>
            </div>
            <div class="analytic-card">
                <div class="icon-circle" style="background: rgba(236, 72, 153, 0.1); color: var(--accent);">
                    <i class="fa-solid fa-microphone"></i>
                </div>
                <div>
                    <span class="val-text"><?php echo number_format($sermonCount); ?></span>
                    <span class="label-text">Sermons Live</span>
                </div>
            </div>
        </section>

        <!-- Content Management -->
        <div class="grid-forms">
            <!-- Sermon Management -->
            <section class="mgmt-section" id="sermons">
                <div class="section-header">
                    <h2><i class="fa-solid fa-cloud-arrow-up" style="color: var(--primary);"></i> Publish Sermon</h2>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_sermon">
                    <div class="form-group">
                        <label>Sermon Title</label>
                        <input type="text" name="title" class="modern-input" required placeholder="e.g. Dimensions of Grace">
                    </div>
                    <div class="form-group">
                        <label>Pastor/Speaker</label>
                        <input type="text" name="pastor" class="modern-input" value="Pastor James Kawalya" required>
                    </div>
                    <div class="form-group">
                        <label>YouTube/Video Link</label>
                        <input type="url" name="url" class="modern-input" required placeholder="https://youtube.com/watch?v=...">
                    </div>
                    <div class="form-group">
                        <label>Cover Art (Optional)</label>
                        <input type="file" name="sermon_image" class="modern-input" accept="image/*" style="padding: 12px;">
                    </div>
                    <div class="form-group">
                        <label>Spiritual Category</label>
                        <select name="category" class="modern-input" style="cursor: pointer;">
                            <option value="Faith">Word of Faith</option>
                            <option value="Healing">Healing & Deliverance</option>
                            <option value="Grace">Grace & Mercy</option>
                            <option value="Other">General Ministry</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-premium" style="margin-top: 10px;">Broadcast Live</button>
                </form>
            </section>

            <!-- Music Management -->
            <section class="mgmt-section" id="music">
                <div class="section-header">
                    <h2><i class="fa-solid fa-music" style="color: #EC4899;"></i> Add Worship Music</h2>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_music">
                    <div class="form-group">
                        <label>Song Name</label>
                        <input type="text" name="title" class="modern-input" required placeholder="e.g. Way Maker">
                    </div>
                    <div class="form-group">
                        <label>Artist</label>
                        <input type="text" name="artist" class="modern-input" required placeholder="e.g. Sinach">
                    </div>
                    <div class="form-group">
                        <label>Media URL</label>
                        <input type="url" name="url" class="modern-input" required placeholder="https://youtube.com/...">
                    </div>
                    <div class="form-group">
                        <label>Thumbnail / Cover</label>
                        <input type="file" name="music_image" class="modern-input" accept="image/*" style="padding: 12px;">
                    </div>
                    <div class="form-group">
                        <label>Genre</label>
                        <select name="category" class="modern-input" style="cursor: pointer;">
                            <option value="Worship">Spirit-led Worship</option>
                            <option value="Praise">High Praise</option>
                            <option value="Hymns">Golden Hymns</option>
                            <option value="Other">Contemporary Gospel</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-premium" style="margin-top: 10px; background: linear-gradient(135deg, #EC4899, #DB2777);">Release Track</button>
                </form>

                <div style="margin-top: 40px; padding-top: 30px; border-top: 1px dashed #E2E8F0;">
                    <h4 style="font-size: 14px; font-weight: 800; color: #B91C1C; margin-bottom: 10px;"><i class="fa-solid fa-triangle-exclamation"></i> Danger Zone</h4>
                    <form method="POST" onsubmit="return confirm('WARNING: This will permanently delete ALL music tracks and cover images. Are you absolutely sure?');">
                        <input type="hidden" name="action" value="clear_music">
                        <button type="submit" class="btn-premium" style="background: rgba(239, 68, 68, 0.1); color: #B91C1C; border: 1px solid rgba(239, 68, 68, 0.2); width: auto; padding: 10px 20px;">
                            Remove All Music
                        </button>
                    </form>
                </div>
            </section>
        </div>

        <!-- Daily Devotion Management -->
        <section class="mgmt-section" id="devotions">
            <div class="section-header">
                <h2><i class="fa-solid fa-book-bible" style="color: #8B5CF6;"></i> Update Daily Devotion</h2>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="upload_devotion">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div>
                        <div class="form-group">
                            <label>Reflective Title</label>
                            <input type="text" name="title" class="modern-input" required placeholder="e.g. Strength for the Weary">
                        </div>
                        <div class="form-group">
                            <label>Scripture Reference</label>
                            <input type="text" name="scripture" class="modern-input" required placeholder="e.g. Isaiah 40:31">
                        </div>
                        <div class="form-group">
                            <label>Feature Image</label>
                            <input type="file" name="devotion_image" class="modern-input" accept="image/*" style="padding: 12px;">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>Spiritual Content</label>
                            <textarea name="content" class="modern-input" required placeholder="Share the daily word..." style="height: 250px;"></textarea>
                        </div>
                        <button type="submit" class="btn-premium" style="background: linear-gradient(135deg, #8B5CF6, #7C3AED);">Publish Today's Word</button>
                    </div>
                </div>
            </form>
        </section>

        <!-- Member Records -->
        <section class="mgmt-section" id="members">
            <div class="section-header">
                <h2><i class="fa-solid fa-address-book" style="color: grey;"></i> Member Directory</h2>
                <div class="badge-pill info-bg"><?php echo count($members); ?> Active Users</div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Member Identification</th>
                            <th>Contact Information</th>
                            <th>Registration Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($members as $member): ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: #F1F5F9; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 12px; color: var(--text-dim);">
                                        <?php echo strtoupper(substr($member['username'], 0, 1)); ?>
                                    </div>
                                    <span style="font-weight: 700;"><?php echo htmlspecialchars($member['username']); ?></span>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($member['email']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($member['join_date'])); ?></td>
                            <td><button class="btn-premium" style="padding: 8px 16px; font-size: 11px;">Manage <i class="fa-solid fa-chevron-right"></i></button></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Prayer Hall Submissions -->
        <section class="mgmt-section" id="prayers">
            <div class="section-header">
                <h2><i class="fa-solid fa-inbox" style="color: var(--primary);"></i> Intercession Inbox</h2>
                <div class="badge-pill danger-bg"><?php echo count($prayers); ?> Pending Requests</div>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Supplicant</th>
                            <th>Focus Area</th>
                            <th>Prayer Petition</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($prayers as $prayer): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: var(--text-main);">
                                    <?php echo htmlspecialchars($prayer['name'] ?: 'Faithful Brother/Sister'); ?>
                                    <?php if($prayer['is_anonymous']): ?> 
                                        <i class="fa-solid fa-user-secret" style="color: var(--text-dim); margin-left: 5px; opacity: 0.5;"></i> 
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><span class="badge-pill info-bg" style="font-size: 10px;"><?php echo htmlspecialchars($prayer['category']); ?></span></td>
                            <td style="max-width: 400px; line-height: 1.6; color: var(--text-dim); font-size: 13px;">
                                <?php echo nl2br(htmlspecialchars($prayer['request'])); ?>
                            </td>
                            <td style="font-size: 12px; color: var(--text-dim);"><?php echo date('M j, g:ia', strtotime($prayer['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($prayers)): ?>
                            <tr><td colspan="4" style="text-align: center; padding: 40px; color: var(--text-dim);">The prayer hall is currently quiet. All requests have been attended to.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script>
        // Simple sidebar active state script
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Smooth scroll for anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
</html>
