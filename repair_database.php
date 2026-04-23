<?php
require_once 'config.php';

/**
 * Faith Connect - Database Repair Utility
 * This script synchronizes the local database schema with the required structure.
 */

header('Content-Type: text/plain');

try {
    echo "Starting database repair...\n";
    echo "----------------------------\n";

    // 1. Add 'reason' column to 'donations' if missing
    $stmt = $pdo->query("DESCRIBE donations");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (!in_array('reason', $columns)) {
        echo "[+] Adding 'reason' column to 'donations' table...\n";
        $pdo->exec("ALTER TABLE donations ADD COLUMN reason TEXT AFTER payment_method");
        echo "[SUCCESS] Column 'reason' added.\n";
    } else {
        echo "[INFO] Column 'reason' already exists in 'donations' table.\n";
    }

    // 2. Create 'password_resets' table if missing
    $stmt = $pdo->query("SHOW TABLES LIKE 'password_resets'");
    if ($stmt->rowCount() === 0) {
        echo "[+] Creating 'password_resets' table...\n";
        $sql = "CREATE TABLE IF NOT EXISTS password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(100) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX (email),
            INDEX (token)
        )";
        $pdo->exec($sql);
        echo "[SUCCESS] Table 'password_resets' created.\n";
    } else {
        echo "[INFO] Table 'password_resets' already exists.\n";
    }

    echo "----------------------------\n";
    echo "Database repair completed successfully!\n";

} catch (Exception $e) {
    echo "[ERROR] FATAL ERROR during repair: " . $e->getMessage() . "\n";
    exit(1);
}
?>
