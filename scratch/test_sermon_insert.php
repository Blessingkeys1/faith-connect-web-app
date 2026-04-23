<?php
require_once 'config.php';
$title = "Test Sermon";
$pastor = "Test Pastor";
$url = "https://youtube.com/test";
$category = "Faith";
$duration = "1h";
$date = date('Y-m-d');
$image_url = null;

try {
    $stmt = $pdo->prepare("INSERT INTO sermons (title, pastor, url, category, duration, date, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $pastor, $url, $category, $duration, $date, $image_url]);
    echo "SUCCESS: Sermon inserted!\n";
} catch(PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
?>
