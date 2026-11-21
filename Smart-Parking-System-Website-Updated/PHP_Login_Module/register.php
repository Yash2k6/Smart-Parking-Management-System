<?php

require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $stmt = $conn->prepare(
        "INSERT INTO users (name, email, password)
         VALUES (?, ?, ?)"
    );

    $stmt->bind_param(
        "sss",
        $name,
        $email,
        $hashedPassword
    );

    if ($stmt->execute()) {
        $message = "Registration successful!";
    } else {
        $message = "Registration failed. Email may already exist.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>

<body>

<h2>Smart Parking System - Registration</h2>

<form method="POST">

    <label>Name:</label>
    <input type="text" name="name" required>

    <br><br>

    <label>Email:</label>
    <input type="email" name="email" required>

    <br><br>

    <label>Password:</label>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">Register</button>

</form>

<p>
    <?php echo htmlspecialchars($message); ?>
</p>

<a href="login.php">Go to Login</a>

</body>
</html>