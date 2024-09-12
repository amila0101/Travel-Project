<?php

$host = 'localhost';
$db = 'travel';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
    
        if (password_verify($password, $user['password'])) {
            header('Location: my.html');
            exit();
        } else {
            echo 'Invalid email or password.';
        }
    } else {
        echo 'Invalid email or password.';
    }

    $stmt->close();
}

$conn->close();
?>
