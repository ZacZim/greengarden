<?php
// Include necessary files and configurations
require_once 'config/db.php';
require_once 'dao/UserDAO.php'; // Assuming you have a UserDAO class for user-related operations

// Initialize the DAO with the database configuration
$userDAO = new UserDAO($databaseConfig['host'], $databaseConfig['user'], $databaseConfig['password'], $databaseConfig['database'], $databaseConfig['charset']);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform user login
    $loginResult = $userDAO->loginUser($username, $password);

    if ($loginResult) {
        echo "Login successful!";
    } else {
        echo "Login failed. Please check your username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>
    <h2>User Login</h2>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
