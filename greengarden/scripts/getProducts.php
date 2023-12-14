<?php
// Include your CategoryDAO and other necessary files
require_once("../dao/CategoryDao.php");
try {
    $pdo = new PDO("mysql:host=localhost;dbname=greengarden", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}
$dao = new CategoryDAO($pdo);

// Récupérez l'identifiant de la catégorie à partir des données postées
$categoryId = $_GET['categoryId'];

// Effectuez une requête SQL pour récupérer les produits associés à la catégorie
$products = $dao->getProductsByCategory($categoryId);


// Affichez les produits
if (!$products == NULL) { 
    ?>

    <div class="container mt-3">
        <div class="row justify-content-center">
            <?php foreach ($products as $product) : ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="images/<?php echo $product['Photo']; ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['Nom_court']; ?></h5>
                            <p class="card-text"><?php echo $product['Nom_Long']; ?></p>
                            <p class="card-text">Référence fournisseur: <?php echo $product['Ref_fournisseur']; ?></p>
                            <p class="card-text"><?php echo $product['Prix_Achat']; ?>€</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php 
    }  else {
    ?>

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Aucun produit</h5>
                        <p class="card-text">Aucun produit ne correspond à vos critères de recherche</p>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}

