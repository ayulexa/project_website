<?php
require 'db.php';

$message = "";

// Proses registrasi
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password untuk keamanan
    $date_of_birth = $_POST['date_of_birth'];

    $sql = "INSERT INTO users (Email, Password, Date_of_birth) VALUES ('$email', '$password', '$date_of_birth')";
    if ($conn->query($sql) === TRUE) {
        $message = "Registrasi berhasil! Silakan login.";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Proses login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            $message = "Login berhasil! Selamat datang, " . $row['Email'];
        } else {
            $message = "Password salah!";
        }
    } else {
        $message = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 90%;
            max-width: 400px;
            background-color: #121212;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        h1 {
            text-align: center;
            color: #ffcc00;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin: 10px 0;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
        }
        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #ffcc00;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #e6b800;
        }
        .toggle {
            text-align: center;
            margin-top: 10px;
        }
        .toggle a {
            color: #ffcc00;
            text-decoration: none;
        }
        .message {
            text-align: center;
            color: #e6b800;
            margin-bottom: 15px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Movie Tickets</h1>
        <div class="message"><?php echo $message; ?></div>
        
        <!-- Form Login -->
        <form id="login-form" method="POST" action="" class="">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Sign In</button>
            <div class="toggle">
                <p>Don't have an account? <a href="#" onclick="toggleForms('register')">Sign Up</a></p>
            </div>
        </form>
        
        <!-- Form Register -->
        <form id="register-form" method="POST" action="" class="hidden">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="date" name="date_of_birth" required>
            <button type="submit" name="register">Sign Up</button>
            <div class="toggle">
                <p>Already have an account? <a href="#" onclick="toggleForms('login')">Sign In</a></p>
            </div>
        </form>
    </div>

    <script>
        function toggleForms(formType) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            
            if (formType === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
            } else if (formType === 'register') {
                registerForm.classList.remove('hidden');
                loginForm.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
