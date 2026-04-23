<?php
require 'config.php';
$stmt = $pdo->query("SELECT * FROM announcements ORDER BY date DESC");
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($news as $item) {
    echo "ID: " . $item['id'] . " | Title: " . $item['title'] . " | Content: " . substr($item['content'], 0, 30) . "...\n";
}
?>
