<?php
/**
 * E-Technozette Database Reset Script
 * This script will clean up and reset the database properly
 */

// Database configuration
$host = 'localhost';
$dbname = 'etechnozette';
$username = 'root';
$password = '';

echo "<h2>E-Technozette Database Reset</h2>";
echo "<p>Resetting database to fix duplicate entry issues...</p>";

try {
    // Connect to MySQL server (without database)
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop and recreate database
    $pdo->exec("DROP DATABASE IF EXISTS $dbname");
    echo "<p>✅ Dropped existing database</p>";
    
    $pdo->exec("CREATE DATABASE $dbname");
    echo "<p>✅ Created fresh database '$dbname'</p>";
    
    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Read and execute the SQL file
    $sql = file_get_contents('database_setup.sql');
    
    // Split SQL into individual statements
    $statements = explode(';', $sql);
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            try {
                $pdo->exec($statement);
                $successCount++;
            } catch (PDOException $e) {
                $errorCount++;
                echo "<p>⚠️ Warning: " . $e->getMessage() . "</p>";
            }
        }
    }
    
    echo "<p>✅ Executed $successCount SQL statements successfully</p>";
    if ($errorCount > 0) {
        echo "<p>⚠️ $errorCount statements had warnings (this is usually normal)</p>";
    }
    
    // Verify tables were created
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<h3>Created Tables:</h3><ul>";
    foreach ($tables as $table) {
        echo "<li>✅ $table</li>";
    }
    echo "</ul>";
    
    // Show sample users
    $users = $pdo->query("SELECT username, role, first_name, last_name FROM users")->fetchAll(PDO::FETCH_ASSOC);
    echo "<h3>Sample Users Created:</h3><table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Username</th><th>Role</th><th>Name</th><th>Password</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['username']}</td>";
        echo "<td>{$user['role']}</td>";
        echo "<td>{$user['first_name']} {$user['last_name']}</td>";
        echo "<td>12345 (or 67890 for Kate)</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h3>🎉 Database Reset Complete!</h3>";
    echo "<p><strong>Next Steps:</strong></p>";
    echo "<ol>";
    echo "<li>Go back to your React app</li>";
    echo "<li>Try logging in with the credentials above</li>";
    echo "<li>The login should now work!</li>";
    echo "</ol>";
    
    echo "<h3>📋 Test Login Credentials:</h3>";
    echo "<ul>";
    echo "<li><strong>Kate</strong> - Password: 67890 - Role: Managing Editor - Birthdate: 02-02-02</li>";
    echo "<li><strong>editor</strong> - Password: 12345 - Role: Editor-In-Chief - Birthdate: 01-01-95</li>";
    echo "<li><strong>news_editor</strong> - Password: 12345 - Role: News Editor - Birthdate: 03-03-03</li>";
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<p>Database reset failed: " . $e->getMessage() . "</p>";
    echo "<p><strong>Troubleshooting:</strong></p>";
    echo "<ul>";
    echo "<li>Make sure XAMPP is running</li>";
    echo "<li>Check if MySQL service is started</li>";
    echo "<li>Verify database credentials</li>";
    echo "</ul>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background: #f5f5f5;
}
h2, h3 {
    color: #8B0000;
}
table {
    width: 100%;
    background: white;
}
th, td {
    padding: 8px 12px;
    text-align: left;
}
th {
    background: #8B0000;
    color: white;
}
code {
    background: #e0e0e0;
    padding: 2px 6px;
    border-radius: 3px;
}
ol, ul {
    line-height: 1.6;
}
</style>
