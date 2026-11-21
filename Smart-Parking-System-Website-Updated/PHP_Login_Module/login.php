
<?php

session_start();

require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT user_id, name, password
         FROM users
         WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify(
            $password,
            $user["password"]
        )) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid email or password";
        }

    } else {
        $error = "Invalid email or password";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>

<body>

<h2>Smart Parking System - User Login</h2>

<form method="POST">

    <label>Email:</label>
    <input type="email" name="email" required>

    <br><br>

    <label>Password:</label>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">Login</button>

</form>

<p style="color:red;">
    <?php echo htmlspecialchars($error); ?>
</p>

<a href="register.php">Create New Account</a>

</body>
</html>
