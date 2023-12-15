<?php

class CategoryDAO 
{
    private $dbHost = '127.0.0.1';
    private $dbName = 'greengarden';
    private $dbUser = 'root';
    private $dbPassword = '';
    private $db;
    private $error;

	public function __construct()
	{
	}

	public function connexion()
	{

		try {
			// Crée une connexion à MySQL en utilisant les paramètres définis.
			$this->db = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword);
		} catch (Exception $e) {
			// // En cas d'erreur, enregistre le message d'erreur et on arrête tout
			$this->error = 'Erreur : ' . $e->getMessage();
		}
	}

    // Méthode pour récupérer toutes les catégories
    public function getAllCategories() {
        $query = "SELECT
        *
            FROM
        t_d_categorie";
        $result = $this->db->query($query);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProducts() {
        $query = "SELECT
        *
            FROM
        t_d_produit";
        $result = $this->db->query($query);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer toutes les produits d'une catégorie sélectionnée
    public function getProductsByCategory($categoryId) {
        $query = "SELECT * FROM t_d_produit WHERE Id_Categorie = :categoryId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Méthode pour ajouter une nouvelle catégorie
    public function addCategory($categoryName) {
        $query = "INSERT INTO t_d_categorie (Libelle) VALUES (:Libelle)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':Libelle', $categoryName);

        return $stmt->execute();
    }

    // Méthode pour mettre à jour une catégorie
    public function updateCategory($reference, $modificationType, $modificationValue) {
        $query = "UPDATE t_d_categorie SET $modificationType = :modificationValue WHERE Id_Categorie = :reference";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':modificationValue', $modificationValue);

        return $stmt->execute();
    }

    // Méthode pour supprimer une catégorie
    public function deleteCategory($selectedCategory) {
        $query = "DELETE FROM t_d_categorie WHERE Id_Categorie = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $selectedCategory);

        return $stmt->execute();
    }

    public function disconnect()
	{
		$this->db = null;
	}

	/* Méthode pour récupérer la dernière erreur fournie par le serveur mysql */
	public function getLastError()
	{
		return $this->error;
	}
}

?>