<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensitiveDB";

// Opret forbindelse
$conn = new mysqli($servername, $username, $password, $dbname);

// Tjek forbindelse
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// genrerer encrypt key
function generateEncryptionKey() {
    return openssl_random_pseudo_bytes(32); // 32 bytes for AES-256
}

// encrypt data
function encryptData($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    return openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv) . '::' . bin2hex($iv);
}

function decryptData($encryptedData, $encryptionKey) {
    // split data og IV
    list($encryptedData, $ivHex) = explode('::', $encryptedData, 2);

    // Konverter IV fra hex til binær
    $iv = hex2bin($ivHex);

    // Decrypt data med AES-kryptering
    $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $encryptionKey, 0, $iv);
    
    return $decryptedData;
}