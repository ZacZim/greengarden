<?php

class DAO
{
	/* Paramètres de connexion à la base de données.
	 Idéalement, des getters et setters devraient être écrits pour modifier ces valeurs
	 en cas de changement de serveur.
	*/

	private $host = "127.0.0.1";
	private $user = "root";
	private $password = "";
	private $database = "bibliotheque";
	private $charset = "utf8";

	// Instance courante de la connexion à la base de données.
	private $bdd;

	// Stockage de l'erreur éventuelle renvoyée par le serveur MySQL.
	private $error;


	// Constructeur vide par défaut. (compatibilité, conformité, modifications futures)
	public function __construct()
	{
	}

	/* Méthode pour établir une connexion à la base de données. */
	public function connexion()
	{

		try {
			// Crée une connexion à MySQL en utilisant les paramètres définis.
			$this->bdd = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database . ';charset=' . $this->charset, $this->user, $this->password);
		} catch (Exception $e) {
			// // En cas d'erreur, enregistre le message d'erreur et on arrête tout
			$this->error = 'Erreur : ' . $e->getMessage();
		}
	}

	/* Méthode pour exécuter une requête SQL et renvoyer les résultats sous forme de tableau. */
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

	/* Fonction pour modifier la BDD et le tableau de livres */
	public function getModifyBook($reference, $modificationType, $modificationValue)
	{
		// Préparez la requête SQL
		$sql = "UPDATE t_books SET $modificationType = :modificationValue WHERE id_book = :reference";

		// Utilisez une déclaration préparée pour éviter les attaques par injection SQL
		$stmt = $this->bdd->prepare($sql);

		// Liaison des paramètres
		$stmt->bindParam(':reference', $reference, PDO::PARAM_INT);
		$stmt->bindParam(':modificationValue', $modificationValue, PDO::PARAM_STR);

		// Exécution de la requête
		if ($stmt->execute()) {
			return $stmt->fetchAll();
		} else {
			$this->error = $stmt->errorInfo();
			return false;
		}
	}


	/* Fonction pour supprimer le livre sélectionné dans la BDD et dans le tableau */
	public function getDeleteBook($selectedBook)
	{
		$sql = "DELETE FROM `t_books` WHERE `t_books`.`id_book` LIKE :selectedBook";
		$stmt = $this->bdd->prepare($sql);
		// Utilisation de PARAM_INT si l'ID du livre est un entier
		$stmt->bindParam(':selectedBook', $selectedBook, PDO::PARAM_INT);

		if ($stmt->execute()) {
			// Succès de la suppression
			return true; 
		} else {
			$this->error = $stmt->errorInfo();
			// Échec de la suppression
			return false; 
		}
	}


	/* Fonction pour ajouter un livre dans la BDD et dans le tableau */
	public function getAddBook($selectedTitle, $selectedIsbn, $selectedthumbnailUrl, $selectedAuthors, $selectedCategories, $selectedPageCount, $selectedPublishedDate, $selectedShortDescription, $selectedLongDescription, $selectedIsAvailable)
	{
		// Ajout d'un livre
		$sql = "INSERT INTO t_books (title, isbn,thumbnailUrl, pageCount, publishedDate, shortDescription, longDescription, authors, categories, IsAvailable) VALUES 	('$selectedTitle', '$selectedIsbn','$selectedthumbnailUrl',	 '$selectedPageCount', '$selectedPublishedDate', '$selectedShortDescription',	  '$selectedLongDescription', '$selectedAuthors', '$selectedCategories','$selectedIsAvailable')";
		return $this->getResults($sql);
	}


	/* Fonction pour ajouter un utilisateur dans la BDD et dans le tableau */
	public function getAddUser($selectedName, $selectedFirst_Name)
	{
		$sql = "INSERT INTO 	t_users (name, first_name) VALUES 	('$selectedName', '$selectedFirst_Name')";
		return $this->getResults($sql);
	}


	/* Fonction pour récupérer les info des livres - et des utilisateurs si empruntés - dans la BDD et les afficher dans une modale */
	public function getDescriptionBook($selectedBook)
	{
		if (isset($selectedBook)) {
			$sql = "SELECT 
				`title`, 
				`isbn`, 
				`pageCount`, 
				`publishedDate`, 
				`thumbnailUrl`, 
				`shortDescription`, 
				`longDescription`, 
				`authors`, 
				`categories`, 
				`IsAvailable`, 
				`id_book`,
				`name`,
				`first_name`
		FROM 
			`t_books`
		LEFT JOIN t_borrow
		ON (t_books.id_book=t_borrow.book_id)
		LEFT JOIN t_users
		ON (t_borrow.user_id=t_users.id_user)
		
		WHERE id_book LIKE :selectedBook";

			// Préparation de la requête SQL en utilisant une déclaration préparée pour éviter les attaques par injection SQL
			$stmt = $this->bdd->prepare($sql);

			// Liaison du paramètre :selectedBook de la requête à la valeur de $selectedBook
			// La liaison est sécurisée avec bindParam pour s'assurer que la valeur est traitée comme une chaîne (PDO::PARAM_STR)
			$stmt->bindParam(':selectedBook', $selectedBook, PDO::PARAM_STR);
		}

		if ($stmt->execute()) {
			// Si l'exécution réussit, retourne tous les résultats de la requête sous forme de tableau
			return $stmt->fetchAll();
		} else {
			// En cas d'échec de l'exécution, enregistre les informations d'erreur dans la propriété $error
			$this->error = $stmt->errorInfo();
			// Retourne false pour indiquer qu'il y a eu une erreur lors de l'exécution de la requête
			return false;
		}
	}


	/* Fonction pour récupérer les infos des livres */
	public function getBooks()
	{
		//Selectionne tous les livres
		$sql = "SELECT 
				`title`, 
				`isbn`, 
				`pageCount`, 
				`publishedDate`, 
				`thumbnailUrl`, 
				`shortDescription`, 
				`longDescription`, 
				`authors`, 
				`categories`, 
				`IsAvailable`, 
				`id_book` 
		FROM 
			`t_books`";

		return $this->getResults($sql);
	}


	/* Fonction pour récupérer les infos des utilisateurs */
	public function getUsers()
	{
		//Selectionne tous les users
		$sql = "SELECT
            *
        FROM
            t_users";

		return $this->getResults($sql);
	}


	/* Fonction pour récupérer les infos de l'emprunt et calculer le nombre de jours dispo restants */
	public const dureeEmprunt = 21;
	public function borrowBook($id_book, $id_user)
	{
		//Crée un emprunt ( liaison d'un book a un user), passe le book d'empruntable a emprunté , prend la date du jour pour la date d'emprunt , et y ajoute 21 pour la date de retour
		$availabilitySql = "SELECT
			isAvailable
		FROM
			t_books
		WHERE 
			id_book = '$id_book'";

		// Exécute la requête SQL et récupère les résultats
		$availabilityResult = $this->getResults($availabilitySql);
		// Affiche la disponibilité du livre à des fins de débogage
		var_dump($availabilityResult[0]['isAvailable']);

		// Vérifie si le livre est déjà emprunté
		if ($availabilityResult[0]['isAvailable'] == 0) {
			echo "Ce livre est déjà emprunté.";

			return false;
		} else {
			// Requête SQL pour insérer un nouvel emprunt
			$insertSql = "INSERT INTO
			t_borrow (borrowDate, returnDate, book_id, user_id)
		VALUES
			(NOW(), DATE_ADD(NOW(), INTERVAL " . self::dureeEmprunt . " DAY), '$id_book', '$id_user')";

			$this->getResults($insertSql);

			// Requête SQL pour mettre à jour la disponibilité du livre (marquer comme emprunté)
			$updateSql = "UPDATE
			t_books
		SET
			isAvailable = 0
		WHERE
			id_book = '$id_book'";

			echo "Emprunt validé.";

			// Retourne les résultats de la requête de mise à jour
			return $this->getResults($updateSql);
		}
	}


	/* Fonction pour enregistrer la date de retour dans la catégorie emprunt */
	public function returnBook($id_borrow)
	{
		//Passe un livre d'emprunté a empruntable , et modifie la date de retour a celle du jour
		$returnSql = "UPDATE
			t_borrow
		SET
			returnDate =  NOW()
		WHERE
			id_borrow = '$id_borrow'";

		$this->getResults($returnSql);

		$updateSql = "UPDATE
			t_books
	  	SET
			isAvailable = 1
	  	WHERE
			id_book = 
				(SELECT 
					book_id 
				FROM 
					t_borrow 
				WHERE 
					id_borrow = '$id_borrow')";

		return $this->getResults($updateSql);
	}


	/* Fonction qui récupère l'historique d'emprunt d'un utilisateur pour l'afficher dans une modale */
	public function getListeEmprunt($selectedBook)
	{
		//Selection des emprunts d'un utilisateur donné
		$sql = "SELECT 
				*
		FROM 
			`t_borrow`
			WHERE user_id LIKE :selectedBook";

		// Préparation de la requête SQL en utilisant une déclaration préparée pour éviter les attaques par injection SQL
		$stmt = $this->bdd->prepare($sql);


		// Liaison du paramètre :selectedBook de la requête à la valeur de $selectedBook
		// La liaison est sécurisée avec bindParam pour s'assurer que la valeur est traitée comme une chaîne (PDO::PARAM_STR)
		$stmt->bindParam(':selectedBook', $selectedBook, PDO::PARAM_STR);


		if ($stmt->execute()) {
			// Si l'exécution réussit, retourne tous les résultats de la requête sous forme de tableau
			return $stmt->fetchAll();
		} else {
			// En cas d'échec de l'exécution, enregistre les informations d'erreur dans la propriété $error
			$this->error = $stmt->errorInfo();
			// Retourne false pour indiquer qu'il y a eu une erreur lors de l'exécution de la requête
			return false;
		}
	}


	/* Fonction qui récupère toutes les infos des livres empruntés */
	public function getBorrows()
	{
		$sql = "SELECT 
				*
		FROM 
			`t_borrow`";

		return $this->getResults($sql);
	}



	/* Méthode pour fermer la connexion à la base de données */
	public function disconnect()
	{
		$this->bdd = null;
	}

	/* Méthode pour récupérer la dernière erreur fournie par le serveur mysql */
	public function getLastError()
	{
		return $this->error;
	}
}
