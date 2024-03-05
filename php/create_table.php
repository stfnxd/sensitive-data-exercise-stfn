<?php
include 'db_connection.php';

// Ændre karakterkodning for databasen (vi vil gerne sikre at vi kører unicode)
$charsetSql = "ALTER DATABASE sensitiveDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
$conn->query($charsetSql);

// Opret tabel
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    encrypted_email VARCHAR(255) NOT NULL,
    encrypted_phone VARCHAR(255) NOT NULL,
    email_encryption_key BLOB NOT NULL,
    phone_encryption_key BLOB NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
