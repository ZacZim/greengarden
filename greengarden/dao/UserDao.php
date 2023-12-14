<?php

require_once './config/db.php';

class UserDAO
{
    private $bdd;
    private $error;

    public function __construct($databaseConfig)
    {
        try {
            $this->bdd = new PDO(
                "mysql:host={$databaseConfig['host']};dbname={$databaseConfig['database']};charset={$databaseConfig['charset']}",
                $databaseConfig['user'],
                $databaseConfig['password']
            );
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->error = 'Erreur : ' . $e->getMessage();
        }
    }

    public function getResults($query)
	{
		$results = array();

		// Exécute la requête SQL.
		$stmt = $this->bdd->query($query);

		if (!$stmt) {
			// En cas d'échec, enregistre les informations d'erreur.
			$this->error = $this->bdd->errorInfo();
			return false;
		} else {
			// Renvoie les résultats sous forme de tableau.
			return $stmt->fetchAll();
		}
	}

    public function registerUser($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $this->bdd->prepare("INSERT INTO `t_d_user` (Login, Password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

            $success = $stmt->execute();

            if ($success) {
                return true;
            } else {
                $this->error = 'Echec lors de la création de compte.';
                return false;
            }

        } catch (PDOException $e) {
            $this->error = 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

    public function loginUser($username, $password)
    {
        try {
            $stmt = $this->bdd->prepare("SELECT Login, Password FROM t_d_user WHERE Login = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
    
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user && password_verify($password, $user['Password'])) {
                return true; // Login ok
            } else {
                $this->error = 'Echec. Vérifiez votre nom d\'utilisateur et mot de passe.';
                return false; // Login échec
            }
        } catch (PDOException $e) {
            $this->error = 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
