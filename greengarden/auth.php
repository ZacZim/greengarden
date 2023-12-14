<?php
// Include necessary files and configurations
require_once 'config/db.php';
require_once 'dao/UserDAO.php';

// Initialize the DAO with the database configuration
$userDAO = new UserDAO($databaseConfig);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        // Registration
        $username = $_POST['username'];
        $password = $_POST['password'];
        $registrationResult = $userDAO->registerUser($username, $password);

        if ($registrationResult) {
            echo "Registration successful!";
            header("Location: index.php");
            exit();
        } else {
            echo "Echec lors de la création. Merci de remplir un nom d\'utilisateur et un mot de passe.";
        }
    } elseif (isset($_POST['login'])) {
        // Login
        $username = $_POST['username'];
        $password = $_POST['password'];
        $loginResult = $userDAO->loginUser($username, $password);

        if ($loginResult) {
            echo "Login successful!";
        } else {
            echo "Echec lors de la connection. Merci de remplir un nom d\'utilisateur et un mot de passe.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />

    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body class="d-flex flex-column justify-content-center align-items-center vh-100">
    <h2>Création de compte et connexion</h2>
    <form method="post" action="" class="mt-5 mb-3">
        <label for="username" class="mb-1 w-50 mx-auto d-block">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required class="mb-1 w-100 mx-auto d-block" placeholder="Entrez votre nom...">
        <label for="password" class="mb-1 w-50 mx-auto d-block">Mot de passe:</label>
        <input type="password" id="password" name="password" required class="mb-1 w-100 mx-auto d-block" placeholder="Entrez votre mot de passe...">
        <input type="submit" name="register" value="S'enregistrer" class="btn btn-lg btn-danger mt-5">
        <input type="submit" name="login" value="Se connecter" class="btn btn-lg btn-primary mt-5">
    </form>
</body>
</html>
