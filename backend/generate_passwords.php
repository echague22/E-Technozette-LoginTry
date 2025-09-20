<?php
/**
 * Password Hash Generator for E-Technozette
 * This script generates proper password hashes for the database
 */

echo "<h2>E-Technozette Password Hash Generator</h2>";

// Generate hashes for the passwords
$passwords = [
    '12345' => 'Default password for most users',
    '67890' => 'Kate\'s password'
];

echo "<h3>Generated Password Hashes:</h3>";
echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr><th>Password</th><th>Hash</th><th>Description</th></tr>";

foreach ($passwords as $password => $description) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "<tr>";
    echo "<td>$password</td>";
    echo "<td style='word-break: break-all; max-width: 300px;'>$hash</td>";
    echo "<td>$description</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h3>SQL Update Commands:</h3>";
echo "<pre>";
echo "-- Update Kate's password (67890)\n";
echo "UPDATE users SET password = '" . password_hash('67890', PASSWORD_DEFAULT) . "' WHERE username = 'Kate';\n\n";

echo "-- Update other users' passwords (12345)\n";
echo "UPDATE users SET password = '" . password_hash('12345', PASSWORD_DEFAULT) . "' WHERE username IN ('editor', 'news_editor', 'feature_writer', 'layout_artist', 'sports_writer');\n";
echo "</pre>";

echo "<h3>Test Password Verification:</h3>";
$test_password = '12345';
$test_hash = password_hash($test_password, PASSWORD_DEFAULT);
$verification = password_verify($test_password, $test_hash) ? '✅ SUCCESS' : '❌ FAILED';
echo "<p>Testing password '$test_password': $verification</p>";

$test_password2 = '67890';
$test_hash2 = password_hash($test_password2, PASSWORD_DEFAULT);
$verification2 = password_verify($test_password2, $test_hash2) ? '✅ SUCCESS' : '❌ FAILED';
echo "<p>Testing password '$test_password2': $verification2</p>";
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
}
th, td {
    padding: 8px 12px;
    text-align: left;
}
th {
    background: #8B0000;
    color: white;
}
pre {
    background: #e0e0e0;
    padding: 15px;
    border-radius: 5px;
    overflow-x: auto;
}
</style>
