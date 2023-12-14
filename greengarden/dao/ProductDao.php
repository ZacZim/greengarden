<?php

class ProductDAO 
{
    private $dbHost = '127.0.0.1';
    private $dbName = 'greengarden';
    private $dbUser = 'root';
    private $dbPassword = '';
    private $db;
    private $error;

    // Constructeur prenant l'objet de connexion à la base de données
    public function __construct($db) {
        $this->db = $db;
    }

    public function connexion()
	{
		try {
			// Crée une connexion à MySQL en utilisant les paramètres définis.
            $this->db = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName}", $this->dbUser, $this->dbPassword);
		} catch (Exception $e) {
			// En cas d'erreur, enregistre le message d'erreur
			$this->error = 'Erreur : ' . $e->getMessage();
		}
	}

    // Méthode pour ajouter un nouveau produit
    public function addProduct($selectedShortName, $selectedLongName, $selectedPrice, $selectedRateVAT, $selectedSupplierRef, $selectedSupplierID, $selectedCategoryID, $selectedPicture) {
        $query = "INSERT INTO t_d_produit (Taux_TVA, Nom_Long, Nom_court, Ref_fournisseur, Photo, Prix_Achat, Id_Fournisseur, Id_Categorie)
        VALUES (:Taux_TVA, :Nom_Long, :Nom_court, :Ref_fournisseur, :Photo, :Prix_Achat, :Id_Fournisseur, :Id_Categorie)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':Nom_court', $selectedShortName);
        $stmt->bindParam(':Nom_Long', $selectedLongName);
        $stmt->bindParam(':Prix_Achat', $selectedPrice);
        $stmt->bindParam(':Taux_TVA', $selectedRateVAT);
        $stmt->bindParam(':Ref_fournisseur', $selectedSupplierRef);
        $stmt->bindParam(':Id_Fournisseur', $selectedSupplierID);
        $stmt->bindParam(':Id_Categorie', $selectedCategoryID);
        $stmt->bindParam(':Photo', $selectedPicture);
    
        return $stmt->execute();
    }

    public function updateProduct($reference, $updateTypeProduct, $updateValueProduct) {
        $query = "UPDATE t_d_produit SET $updateTypeProduct = ':modificationValue' WHERE Id_Produit = :reference";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':modificationValue', $updateValueProduct);

        return $stmt->execute();
    }

    public function deleteProduct($selectedProduct) {
        $query = "DELETE FROM t_d_produit WHERE Id_Produit = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $selectedProduct);

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