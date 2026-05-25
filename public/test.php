<?php
try {
    $pdo = new PDO('mysql:host=172.19.0.3;port=3306;dbname=webdev', 'root', '');
    echo "✅ DATABASE CONNECTED!";
    
    $gems = $pdo->query("SELECT COUNT(*) FROM gem")->fetchColumn();
    echo "<br>Gems in database: " . $gems;
    
    $jewelry = $pdo->query("SELECT COUNT(*) FROM jewelry")->fetchColumn();
    echo "<br>Jewelry in database: " . $jewelry;
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage();
}
?>