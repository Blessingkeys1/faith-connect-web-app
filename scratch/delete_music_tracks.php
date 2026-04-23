<?php
require_once '../config.php';

echo "<h2>Music Cleanup Utility</h2>";
echo "<p>Starting cleanup process...</p>";

try {
    // 1. Delete records from database
    $stmt = $pdo->prepare("DELETE FROM music");
    $stmt->execute();
    $count = $stmt->rowCount();
    echo "<p style='color: green;'>[SUCCESS] Deleted $count records from 'music' table.</p>";

    // 2. Delete files from directory
    $dir = '../images/music/';
    $files = glob($dir . '*');
    $fileCount = 0;
    
    foreach ($files as $file) {
        if (is_file($file)) {
            if (unlink($file)) {
                echo "<p>[INFO] Deleted file: " . basename($file) . "</p>";
                $fileCount++;
            } else {
                echo "<p style='color: red;'>[ERROR] Failed to delete file: " . basename($file) . "</p>";
            }
        }
    }
    
    echo "<p style='color: green;'>[SUCCESS] Deleted $fileCount image files.</p>";
    echo "<hr>";
    echo "<p>Cleanup completed successfully. <a href='../music.php'>Go to Music Page</a></p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>[ERROR] FATAL ERROR: " . $e->getMessage() . "</p>";
}
?>
