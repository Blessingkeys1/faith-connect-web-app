<?php
require 'config.php';
try {
    $count = $pdo->exec("DELETE FROM announcements WHERE id = 1");
    echo "SUCCESS: Deleted $count announcement(s).\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
?>
