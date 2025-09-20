<?php
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
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Function to validate user role permissions
function getUserPermissions($role) {
    $permissions = [
        'Editor-In-Chief' => ['all'],
        'Managing Editor' => ['articles', 'users', 'reports', 'settings'],
        'Associate Editor - Internal' => ['articles', 'reports'],
        'Associate Editor - External' => ['articles', 'reports'],
        'Proofreader (Editorial Board)' => ['articles'],
        'News Editor' => ['articles', 'reports'],
        'Editorial Editor' => ['articles', 'reports'],
        'Feature Editor' => ['articles', 'reports'],
        'Literary Editor' => ['articles', 'reports'],
        'Sports Editor' => ['articles', 'reports'],
        'Head Layout Artist' => ['articles', 'reports'],
        'Head Cartoonist' => ['articles', 'reports'],
        'Head Photojournalist' => ['articles', 'reports'],
        'News Writer' => ['articles'],
        'Editorial Writer' => ['articles'],
        'Feature Writer' => ['articles'],
        'Literary Writer' => ['articles'],
        'Sports Writer' => ['articles'],
        'Layout Artist' => ['articles'],
        'Cartoonist' => ['articles'],
        'Photojournalist' => ['articles']
    ];
    
    return $permissions[$role] ?? ['articles'];
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON data']);
        exit;
    }
    
    $role = $input['role'] ?? '';
    $username = $input['username'] ?? '';
    $birthdate = $input['birthdate'] ?? '';
    $password = $input['password'] ?? '';
    
    // Validate input
    if (empty($username) || empty($password) || empty($role) || empty($birthdate)) {
        http_response_code(400);
        echo json_encode(['error' => 'All fields are required']);
        exit;
    }
    
    try {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
        $stmt->execute([$username, $role]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Check birthdate format and match
            if ($user['birthdate'] === $birthdate) {
                // Generate session token
                $token = bin2hex(random_bytes(32));
                
                // Store token in database
                $stmt = $pdo->prepare("UPDATE users SET session_token = ?, last_login = NOW() WHERE id = ?");
                $stmt->execute([$token, $user['id']]);
                
                // Get user permissions based on role
                $permissions = getUserPermissions($user['role']);
                
                // Return success response
                echo json_encode([
                    'success' => true,
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                        'email' => $user['email'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'permissions' => $permissions
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid birthdate']);
            }
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle session validation request
    $token = $_GET['token'] ?? '';
    
    if (empty($token)) {
        http_response_code(400);
        echo json_encode(['error' => 'Token required']);
        exit;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE session_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $permissions = getUserPermissions($user['role']);
            echo json_encode([
                'valid' => true,
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'permissions' => $permissions
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['valid' => false, 'error' => 'Invalid token']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
