<?php
require 'config.php';
$stmt = $pdo->query("SELECT * FROM sermons ORDER BY created_at DESC");
$sermons = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "TOTAL SERMONS: " . count($sermons) . "\n";
foreach($sermons as $sermon) {
    echo "ID: " . $sermon['id'] . " | Title: " . $sermon['title'] . " | Date: " . $sermon['date'] . "\n";
}
?>
