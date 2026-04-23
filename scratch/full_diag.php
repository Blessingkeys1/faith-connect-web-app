<?php
require_once 'config.php';
$tables = ['sermons', 'announcements', 'devotions', 'music', 'prayer_requests', 'users'];
foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("DESCRIBE $table");
        $cols = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "TABLE $table: " . implode(", ", $cols) . "\n";
    } catch (Exception $e) {
        echo "TABLE $table: MISSING OR ERROR (" . $e->getMessage() . ")\n";
    }
}
?>
