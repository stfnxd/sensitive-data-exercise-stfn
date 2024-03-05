<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Find password for brugeren fra DB
    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            echo "Login successful!";
        } else {
            echo "Login failed: Incorrect username or password.";
        }
    } else {
        echo "Login failed: User not found.";
    }
}

$conn->close();

