
<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>

<body>

    <h2>Welcome to Smart Parking System</h2>

    <p>
        Welcome,
        <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
    </p>

    <p>You have successfully logged in.</p>

    <a href="logout.php">Logout</a>

</body>
</html>
