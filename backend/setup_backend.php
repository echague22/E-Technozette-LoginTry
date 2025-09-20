<?php
/**
 * E-Technozette Backend Setup Script
 * This script helps set up the backend properly for XAMPP
 */

echo "<h2>E-Technozette Backend Setup</h2>";
echo "<p>Setting up backend for XAMPP...</p>";

// Check if we're in the right location
$currentDir = __DIR__;
echo "<p><strong>Current Directory:</strong> $currentDir</p>";

// Check if database_setup.sql exists
$sqlFile = __DIR__ . '/database_setup.sql';
if (file_exists($sqlFile)) {
    echo "<p>✅ database_setup.sql found</p>";
} else {
    echo "<p>❌ database_setup.sql not found</p>";
}

// Check if login.php exists
$loginFile = __DIR__ . '/login.php';
if (file_exists($loginFile)) {
    echo "<p>✅ login.php found</p>";
} else {
    echo "<p>❌ login.php not found</p>";
}

// Test database connection
$host = 'localhost';
$dbname = 'etechnozette';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>✅ Database connection successful</p>";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "<p>✅ Users table exists</p>";
        
        // Count users
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "<p>✅ Found $count users in database</p>";
        
        // Show sample users
        $stmt = $pdo->query("SELECT username, role, first_name, last_name FROM users LIMIT 5");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Sample Users:</h3>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Username</th><th>Role</th><th>Name</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['username']}</td>";
            echo "<td>{$user['role']}</td>";
            echo "<td>{$user['first_name']} {$user['last_name']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } else {
        echo "<p>❌ Users table does not exist</p>";
        echo "<p><strong>Action needed:</strong> Run the database setup first</p>";
    }
    
} catch (PDOException $e) {
    echo "<p>❌ Database connection failed: " . $e->getMessage() . "</p>";
    echo "<p><strong>Action needed:</strong> Make sure XAMPP MySQL is running and database 'etechnozette' exists</p>";
}

// Test login endpoint
echo "<h3>Testing Login Endpoint</h3>";
$loginUrl = "http://localhost" . dirname($_SERVER['REQUEST_URI']) . "/login.php";
echo "<p><strong>Login URL:</strong> <a href='$loginUrl' target='_blank'>$loginUrl</a></p>";

// Show setup instructions
echo "<h3>🎯 Setup Instructions</h3>";
echo "<ol>";
echo "<li><strong>Copy Backend Files:</strong> Copy the 'backend' folder to your XAMPP htdocs directory</li>";
echo "<li><strong>Start XAMPP:</strong> Make sure Apache and MySQL are running</li>";
echo "<li><strong>Setup Database:</strong> Run <a href='setup_database.php'>setup_database.php</a> to create the database</li>";
echo "<li><strong>Test Login:</strong> Try logging in with the sample users</li>";
echo "</ol>";

echo "<h3>📋 Sample Login Credentials</h3>";
echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr><th>Username</th><th>Password</th><th>Role</th><th>Birthdate</th></tr>";
echo "<tr><td>Kate</td><td>67890</td><td>Managing Editor</td><td>02-02-02</td></tr>";
echo "<tr><td>editor</td><td>12345</td><td>Editor-In-Chief</td><td>01-01-95</td></tr>";
echo "<tr><td>news_editor</td><td>12345</td><td>News Editor</td><td>03-03-03</td></tr>";
echo "<tr><td>feature_writer</td><td>12345</td><td>Feature Writer</td><td>04-04-04</td></tr>";
echo "</table>";

echo "<h3>🔧 Troubleshooting</h3>";
echo "<ul>";
echo "<li><strong>Backend not accessible:</strong> Make sure the backend folder is in htdocs and Apache is running</li>";
echo "<li><strong>Database errors:</strong> Check if MySQL is running and database exists</li>";
echo "<li><strong>Login fails:</strong> Verify username, password, role, and birthdate match exactly</li>";
echo "<li><strong>CORS errors:</strong> The backend includes CORS headers, make sure you're using the correct URL</li>";
echo "</ul>";

echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Start your React app: <code>npm run dev</code></li>";
echo "<li>Access the app at: <a href='http://localhost:5173'>http://localhost:5173</a></li>";
echo "<li>Test login with the sample credentials above</li>";
echo "</ol>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 1000px;
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
    margin: 10px 0;
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
