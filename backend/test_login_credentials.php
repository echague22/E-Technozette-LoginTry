<?php
/**
 * Test Login Credentials Script
 * This will test the login with the correct credentials
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Database configuration
$host = 'localhost';
$dbname = 'etechnozette';
$username = 'root';
$password = '';

echo "<h2>E-Technozette Login Credentials Test</h2>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test credentials
    $testCredentials = [
        [
            'username' => 'Kate',
            'password' => '67890',
            'role' => 'Managing Editor',
            'birthdate' => '02-02-02'
        ],
        [
            'username' => 'editor',
            'password' => '12345',
            'role' => 'Editor-In-Chief',
            'birthdate' => '01-01-95'
        ]
    ];
    
    echo "<h3>Testing Login Credentials:</h3>";
    
    foreach ($testCredentials as $cred) {
        echo "<h4>Testing: {$cred['username']} ({$cred['role']})</h4>";
        
        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
        $stmt->execute([$cred['username'], $cred['role']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo "<p>✅ User found in database</p>";
            
            // Test password verification
            $passwordMatch = password_verify($cred['password'], $user['password']);
            $birthdateMatch = ($user['birthdate'] === $cred['birthdate']);
            
            echo "<p>Password match: " . ($passwordMatch ? "✅ YES" : "❌ NO") . "</p>";
            echo "<p>Birthdate match: " . ($birthdateMatch ? "✅ YES" : "❌ NO") . "</p>";
            
            if ($passwordMatch && $birthdateMatch) {
                echo "<p style='color: green; font-weight: bold;'>✅ LOGIN SHOULD WORK</p>";
            } else {
                echo "<p style='color: red; font-weight: bold;'>❌ LOGIN WILL FAIL</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ User not found</p>";
        }
        echo "<hr>";
    }
    
    echo "<h3>📋 Correct Login Credentials:</h3>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Username</th><th>Password</th><th>Role</th><th>Birthdate</th></tr>";
    echo "<tr><td>Kate</td><td>67890</td><td>Managing Editor</td><td>02-02-02</td></tr>";
    echo "<tr><td>editor</td><td>12345</td><td>Editor-In-Chief</td><td>01-01-95</td></tr>";
    echo "<tr><td>news_editor</td><td>12345</td><td>News Editor</td><td>03-03-03</td></tr>";
    echo "</table>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
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
h2, h3, h4 {
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
</style>
