<?php
/**
 * Fix Passwords Script
 * This will update the passwords with correct hashes
 */

// Database configuration
$host = 'localhost';
$dbname = 'etechnozette';
$username = 'root';
$password = '';

echo "<h2>E-Technozette Password Fix</h2>";
echo "<p>Updating passwords with correct hashes...</p>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Generate correct password hashes
    $katePassword = password_hash('67890', PASSWORD_DEFAULT);
    $otherPassword = password_hash('12345', PASSWORD_DEFAULT);
    
    echo "<p>Generated password hashes:</p>";
    echo "<p>Kate (67890): " . substr($katePassword, 0, 30) . "...</p>";
    echo "<p>Others (12345): " . substr($otherPassword, 0, 30) . "...</p>";
    
    // Update Kate's password
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = 'Kate'");
    $stmt->execute([$katePassword]);
    echo "<p>✅ Updated Kate's password</p>";
    
    // Update other users' passwords
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username != 'Kate'");
    $stmt->execute([$otherPassword]);
    echo "<p>✅ Updated other users' passwords</p>";
    
    // Test the passwords
    echo "<h3>Testing Password Verification:</h3>";
    
    // Test Kate's password
    $stmt = $pdo->prepare("SELECT password FROM users WHERE username = 'Kate'");
    $stmt->execute();
    $kateHash = $stmt->fetchColumn();
    $kateTest = password_verify('67890', $kateHash);
    echo "<p>Kate password test: " . ($kateTest ? "✅ SUCCESS" : "❌ FAILED") . "</p>";
    
    // Test other users' passwords
    $stmt = $pdo->prepare("SELECT password FROM users WHERE username = 'editor'");
    $stmt->execute();
    $editorHash = $stmt->fetchColumn();
    $editorTest = password_verify('12345', $editorHash);
    echo "<p>Editor password test: " . ($editorTest ? "✅ SUCCESS" : "❌ FAILED") . "</p>";
    
    echo "<h3>🎉 Password Fix Complete!</h3>";
    echo "<p><strong>Now try logging in again with:</strong></p>";
    echo "<ul>";
    echo "<li><strong>Kate</strong> - Password: 67890 - Role: Managing Editor - Birthdate: 02-02-02</li>";
    echo "<li><strong>editor</strong> - Password: 12345 - Role: Editor-In-Chief - Birthdate: 01-01-95</li>";
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<p>Password fix failed: " . $e->getMessage() . "</p>";
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
p {
    margin: 10px 0;
}
ul {
    line-height: 1.6;
}
</style>
