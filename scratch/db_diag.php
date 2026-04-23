<?php
require_once 'config.php';
try {
    $stmt = $pdo->query("DESCRIBE donations");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "COLUMNS: " . implode(", ", $columns) . "\n";
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "TABLES: " . implode(", ", $tables) . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
