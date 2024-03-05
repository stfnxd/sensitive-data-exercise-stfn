<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Hash adgangskode
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // encrypt key for  DATA
    $emailEncryptionKey = generateEncryptionKey();
    $phoneEncryptionKey = generateEncryptionKey();

    // encryption for DATA
    $encryptedEmail = encryptData($email, $emailEncryptionKey);
    $encryptedPhone = encryptData($phone, $phoneEncryptionKey);

    //SQL-forespørgslen med parameterbinding
    $sql = "INSERT INTO users (username, password, encrypted_email, encrypted_phone, email_encryption_key, phone_encryption_key) VALUES (?, ?, ?, ?, ?, ?)";

    // SQL Udsagn
    if ($stmt = $conn->prepare($sql)) {
        // Binde parametrene og angive deres typer
        $stmt->bind_param("ssssss", $username, $hashedPassword, $encryptedEmail, $encryptedPhone, $emailEncryptionKey, $phoneEncryptionKey);
        
        // Udfør QUERY
        if ($stmt->execute()) {
            echo "User created successfully.";
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }
}

$conn->close();

