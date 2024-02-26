<?php
// Assume users are stored in a JSON file for simplicity (users.json)
$usersFile = 'users.json';

// Check if the file exists, if not create one
if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Use password hashing in real applications

    // Load existing users
    $users = json_decode(file_get_contents($usersFile), true);

    // Check if user exists
    if (isset($users[$username])) {
        echo "User already exists.";
    } else {
        // Add user
        $users[$username] = $password; // Hash password before saving
        file_put_contents($usersFile, json_encode($users));
        echo "User created successfully.";
    }
}
?>
