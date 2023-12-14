<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenGarden</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />

    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
    <header>
        <div class="d-flex flex-row container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- <img src="monogram-2670684_1280.png" alt="logo Médiathèque" class="custom-img"> -->
                    <h1 class="fw-light mt-3 text-white">
                        Bienvenue sur GreenGarden
                    </h1>
                </div>
            </div>
        </div>
        <div>
            <a href="auth.php">Connectez ou inscrivez-vous !</a>
        </div>
    </header>
    
    <?php
    // require_once("dao.php");

    // $dao = new DAO();

    // //on se connecte
    // $dao->connexion();

    // //on récupère tous les livres et on les affiche
    // $books = $dao->getBooks();

    require_once("dao/CategoryDao.php");

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=greengarden", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        die();
    }

    $dao = new CategoryDAO($pdo);
    $dao->connexion();
    $categories = $dao->getAllCategories();
    ?>



    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 d-flex flex-row flex-md-column align-items-center     ">
                <!-- Sélection des filtres -->

                <!-- A REMPLACER PAR UN BOUTON EVENTUELLEMENT -->
                
                <div class="form-check mt-5">
                    <input class="form-check-input" type="radio" name="couleur" id="categories" value="Categories">
                    <label class="form-check-label custom-radio-label active" for="categories">Toutes les catégories</label>
                </div>

                <div class="form-check mt-5">
                    <input class="form-check-input" type="radio" name="couleur" id="products" value="Products">
                    <label class="form-check-label custom-radio-label" for="products">Produits</label>
                </div>
            </div>

            <!-- Affichage des catégories -->
            <!-- <div class="row mt-3">
                <?php foreach ($categories as $category) : ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="image-placeholder.jpg" class="card-img-top" alt="Image de la catégorie">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $category['Libelle']; ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div> -->

            <!-- Affichage des catégories -->
            <div class="row mt-3">
                <?php foreach ($categories as $category) : ?>
                    <div class="col-md-4">
                        <section id="category_<?php echo $category['Id_Categorie']; ?>" class="category-section">
                            
                            <!-- Ajout de l'ancre unique à chaque catégorie -->
                            <!-- <a href="#category_<?php echo $category['Id_Categorie']; ?>" class="card-link"> -->
                                <a href="#" class="card-link category-link" data-category-id="<?php echo $category['Id_Categorie']; ?>">
                                <div class="card mb-3">
                                    <img src="images/image-placeholder.jpg" class="card-img-top" alt="Image de la catégorie">
                                    <div class="card-body">
                                    <!-- Nom de la catégorie -->
                                        <h5 class="card-title"><?php echo $category['Libelle']; ?></h5>
                                    </div>
                                </div>
                                </a>
                            
                        </section>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Affichage des catégories -->
            <div class="products-container">
            </div>

            <!-- Affichage des produits associés à chaque catégorie 
             <?php foreach ($categories as $category) : ?>
                <section id="category_<?php echo $category['Id_Categorie']; ?>" class="category-section">
                    <?php
                    // Effectuez une requête SQL pour récupérer les produits associés à la catégorie
                    $categoryId = $category['Id_Categorie'];
                    $products = $dao->getProductsByCategory($categoryId);

                    // Affichez les produits
                    foreach ($products as $product) :
                    ?>
                        <div class="product-card">
                            <h4><?php echo $product['Nom_court']; ?></h4>
                            <p><?php echo $product['Nom_Long']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endforeach; ?> -->

        <div class="d-flex flex-column container text-center">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="fw-light mt-4 text-white">
                        Projet d'une application pour la gestion d’une bibliothèque
                    </h1>
                    <p class="lead text-white-50">
                        Vous êtes un développeur junior embauché par une collectivité territoriale. Vous devez créer une
                        application qui permette aux bibliothécaires de la ville de gérer le catalogue de livres ainsi que les
                        prêts et les rendus.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <footer id="sticky-footer" class="flex-shrink-0 py-4 bg-dark text-white-50">
        <div id="participants" class="d-flex flex-row  justify-content-around">
            <div class="text-center">
                <h4>Zacharie Zimmer</h4>
                <a target="#" href="https://github.com/ZacZim">Voir Github</a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <script src="js/main.js"></script>

</body>

</html>