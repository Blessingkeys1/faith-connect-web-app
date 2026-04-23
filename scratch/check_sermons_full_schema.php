<?php
require_once 'config.php';
try {
    $stmt = $pdo->query("DESCRIBE sermons");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "COLUMNS IN sermons:\n";
    print_r($columns);
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
