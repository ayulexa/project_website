<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password untuk keamanan
    $date_of_birth = $_POST['date_of_birth'];

    // Insert data ke database
    $sql = "INSERT INTO users (Email, Password, Date_of_birth) VALUES ('$email', '$password', '$date_of_birth')";
    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
