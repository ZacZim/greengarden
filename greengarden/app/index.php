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
        <div class="row justify-content-center text-center">
            <!-- <img src="monogram-2670684_1280.png" alt="logo Médiathèque" class="custom-img"> -->
            <h1 class="fw-light mt-3 text-white">
                Bienvenue sur GreenGarden
            </h1>
        </div>
        <div class="text-center ">
            <a href="auth.php">Connectez ou inscrivez-vous !</a>
        </div>
    </header>
    
    <?php

    require_once("dao/CategoryDao.php");
    $dao = new CategoryDAO();
    $dao->connexion();
    $categories = $dao->getAllCategories();

    ?>



    <div class="container-fluid">
        <div class="row">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn-primary btn-outline-primary mt-5 custom-radio-label" id="categories" name="allCategories" value="Categories">Voir toutes les catégories</button>
            </div>

            <!-- Affichage des catégories -->
            <div class="row mt-3">
                <?php foreach ($categories as $category) : ?>
                    <div class="col-md-4">
                        <section id="category_<?php echo $category['Id_Categorie']; ?>" class="category-section">
                            
                            <!-- Ajout de l'ancre unique à chaque catégorie -->
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

            <!-- Affichage des produits -->
            <div class="products-container">
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