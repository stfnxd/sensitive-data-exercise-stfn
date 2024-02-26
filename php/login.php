<?php
$usersFile = 'users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Load users
    $users = json_decode(file_get_contents($usersFile), true);

    // Verify user and password
    if (isset($users[$username]) && $users[$username] === $password) { // Use password_verify for hashed passwords
        echo "Login successful!";
    } else {
        echo "Login failed: Incorrect username or password.";
    }
}
?>
