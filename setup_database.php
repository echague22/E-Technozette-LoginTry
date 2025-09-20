<?php
/**
 * E-Technozette Database Setup Script
 * Run this script to automatically set up the database
 * Access: http://localhost/backend/setup_database.php
 */

// Database configuration
$host = 'localhost';
$dbname = 'etechnozette';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server (without database)
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>E-Technozette Database Setup</h2>";
    echo "<p>Setting up database...</p>";
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "<p>✅ Database '$dbname' created successfully</p>";
    
    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Read and execute the SQL file
    $sql = file_get_contents('database_setup.sql');
    
    // Split SQL into individual statements
    $statements = explode(';', $sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    
    echo "<p>✅ Database structure imported successfully</p>";
    echo "<p>✅ Sample data inserted successfully</p>";
    
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
    
    echo "<h3>🎉 Setup Complete!</h3>";
    echo "<p><strong>Next Steps:</strong></p>";
    echo "<ol>";
    echo "<li>Start your React development server: <code>npm run dev</code></li>";
    echo "<li>Access the application at: <a href='http://localhost:5173'>http://localhost:5173</a></li>";
    echo "<li>Test login with any of the sample users above</li>";
    echo "</ol>";
    
    echo "<p><strong>Login Credentials:</strong></p>";
    echo "<ul>";
    echo "<li><strong>Kate</strong> - Password: 67890 - Role: Managing Editor</li>";
    echo "<li><strong>editor</strong> - Password: 12345 - Role: Editor-In-Chief</li>";
    echo "<li><strong>news_editor</strong> - Password: 12345 - Role: News Editor</li>";
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<p>Database setup failed: " . $e->getMessage() . "</p>";
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
</style>
