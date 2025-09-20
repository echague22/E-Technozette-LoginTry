<?php
/**
 * Debug Login Script
 * This will help us test the login process step by step
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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test credentials
    $testCredentials = [
        'username' => 'Kate',
        'password' => '67890',
        'role' => 'Managing Editor',
        'birthdate' => '02-02-02'
    ];
    
    echo json_encode([
        'debug' => 'Login Debug Test',
        'step1' => 'Database connection successful',
        'step2' => 'Testing user lookup...'
    ]);
    
    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
    $stmt->execute([$testCredentials['username'], $testCredentials['role']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo json_encode([
            'debug' => 'User found in database',
            'user_id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'birthdate' => $user['birthdate'],
            'password_hash' => substr($user['password'], 0, 20) . '...',
            'step3' => 'Testing password verification...'
        ]);
        
        // Test password verification
        $passwordMatch = password_verify($testCredentials['password'], $user['password']);
        $birthdateMatch = ($user['birthdate'] === $testCredentials['birthdate']);
        
        echo json_encode([
            'debug' => 'Password and birthdate verification',
            'password_match' => $passwordMatch,
            'birthdate_match' => $birthdateMatch,
            'step4' => 'All checks completed'
        ]);
        
    } else {
        echo json_encode([
            'debug' => 'User not found',
            'searched_username' => $testCredentials['username'],
            'searched_role' => $testCredentials['role']
        ]);
    }
    
} catch(PDOException $e) {
    echo json_encode([
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
