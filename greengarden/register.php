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

    // Perform user registration
    $registrationResult = $userDAO->registerUser($username, $password);

    if ($registrationResult) {
        echo "Registration successful!";
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
