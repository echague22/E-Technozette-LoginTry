<?php
/**
 * E-Technozette Login Test Script
 * This script tests the login functionality with sample credentials
 */

echo "<h2>E-Technozette Login Test</h2>";

// Test credentials
$testUsers = [
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
    ],
    [
        'username' => 'news_editor',
        'password' => '12345',
        'role' => 'News Editor',
        'birthdate' => '03-03-03'
    ]
];

echo "<h3>Testing Login Endpoint</h3>";

foreach ($testUsers as $user) {
    echo "<h4>Testing: {$user['username']} ({$user['role']})</h4>";
    
    // Prepare the request
    $data = json_encode($user);
    
    // Test the login endpoint
    $url = 'http://localhost' . dirname($_SERVER['REQUEST_URI']) . '/login.php';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($response) {
        $result = json_decode($response, true);
        
        if ($result && isset($result['success']) && $result['success']) {
            echo "<p>✅ <strong>SUCCESS:</strong> Login successful</p>";
            echo "<p>Token: " . substr($result['token'], 0, 20) . "...</p>";
            echo "<p>User: {$result['user']['first_name']} {$result['user']['last_name']}</p>";
            echo "<p>Role: {$result['user']['role']}</p>";
            echo "<p>Permissions: " . implode(', ', $result['user']['permissions']) . "</p>";
        } else {
            echo "<p>❌ <strong>FAILED:</strong> " . ($result['error'] ?? 'Unknown error') . "</p>";
        }
    } else {
        echo "<p>❌ <strong>ERROR:</strong> No response from server</p>";
    }
    
    echo "<hr>";
}

// Test invalid credentials
echo "<h3>Testing Invalid Credentials</h3>";
$invalidUser = [
    'username' => 'invalid_user',
    'password' => 'wrong_password',
    'role' => 'Editor-In-Chief',
    'birthdate' => '01-01-95'
];

$data = json_encode($invalidUser);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data)
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    $result = json_decode($response, true);
    if ($result && isset($result['error'])) {
        echo "<p>✅ <strong>CORRECT:</strong> Invalid credentials rejected - {$result['error']}</p>";
    } else {
        echo "<p>❌ <strong>ERROR:</strong> Should have rejected invalid credentials</p>";
    }
} else {
    echo "<p>❌ <strong>ERROR:</strong> No response from server</p>";
}

echo "<h3>🎯 Test Summary</h3>";
echo "<p>If you see ✅ SUCCESS messages above, your login system is working correctly!</p>";
echo "<p>You can now test the login in your React application.</p>";

echo "<h3>📋 Next Steps</h3>";
echo "<ol>";
echo "<li>Start your React app: <code>npm run dev</code></li>";
echo "<li>Go to: <a href='http://localhost:5173'>http://localhost:5173</a></li>";
echo "<li>Try logging in with the test credentials above</li>";
echo "<li>Verify that the dashboard shows role-specific features</li>";
echo "</ol>";
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
p {
    margin: 10px 0;
}
hr {
    margin: 20px 0;
    border: 1px solid #ddd;
}
code {
    background: #e0e0e0;
    padding: 2px 6px;
    border-radius: 3px;
}
ol {
    line-height: 1.6;
}
</style>
