<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Tjek om brugerens id blev sendt med
    if (isset($_GET['userid'])) {
        $userid = $_GET['userid'];

        // Hent brugerdata fra databasen baseret på brugerens id
        $sql = "SELECT * FROM users WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $userid);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                                      
                    // Decrypter de krypterede data før visning
                    $decryptedEmail = decryptData($row['encrypted_email'], $row['email_encryption_key']);
                    $decryptedPhone = decryptData($row['encrypted_phone'], $row['phone_encryption_key']);
                    
                    // Vis brugerdata
                    echo "Username: " . $row['username'] . "<br>";
                    echo "Email: " . $decryptedEmail . "<br>";
                    echo "Phone: " . $decryptedPhone . "<br>";

                } else {
                    echo "User not found.";
                }
            } else {
                echo "Error preparing query: " . $conn->error;
            }
        }
    } else {
        echo "User ID not provided.";
    }



$conn->close();
