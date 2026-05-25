<?php
// Simple database connection test
echo "<h1>Database Connection Test</h1>";

try {
    // Try to connect directly to MySQL
    $pdo = new PDO('mysql:host=database;port=3308;dbname=webdev', 'root', '');
    echo "<p style='color:green'>✅ Direct MySQL connection: SUCCESS</p>";
    
    // Check if tables exist
    $tables = $pdo->query("SHOW TABLES")->fetchAll();
    echo "<p>Tables in database: " . count($tables) . "</p>";
    
    // Check gems
    $gems = $pdo->query("SELECT COUNT(*) FROM gem")->fetchColumn();
    echo "<p>Gems: " . $gems . "</p>";
    
    // Check jewelries
    $jewelries = $pdo->query("SELECT COUNT(*) FROM jewelries")->fetchColumn();
    echo "<p>Jewelries: " . $jewelries . "</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Direct MySQL connection FAILED: " . $e->getMessage() . "</p>";
}

echo "<hr>";

// Now try through Symfony's Doctrine
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    $kernel = new \App\Kernel('dev', true);
    $kernel->boot();
    $container = $kernel->getContainer();
    
    $em = $container->get('doctrine')->getManager();
    $connection = $em->getConnection();
    
    echo "<p style='color:green'>✅ Symfony Doctrine connection: SUCCESS</p>";
    
    // Try a simple query
    $result = $connection->executeQuery("SELECT 1")->fetchOne();
    echo "<p>Query test: " . ($result ? "✅ Working" : "❌ Failed") . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Symfony Doctrine connection FAILED: " . $e->getMessage() . "</p>";
}
?>