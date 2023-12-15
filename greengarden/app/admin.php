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

<?php
require_once("dao/CategoryDao.php");
require_once("dao/ProductDao.php");

$daoC = new CategoryDAO();
$daoC->connexion();

$daoP = new ProductDAO();
$daoP->connexion();

$categories = $daoC->getAllCategories();
$products = $daoP->getAllProducts();
?>

<body>
    <header>
        <div class="row justify-content-center text-center">
            <h1 class="fw-light mt-3 text-white">
                Page admin de GreenGarden
            </h1>
        </div>
    </header>



    <div class="container-fluid">
        <div class="d-flex flex-row align-items-center justify-content-center ">
            <!-- Sélection des filtres -->
            <div class="form-check mt-5">
                <input class="form-check-input" type="radio" name="selectedTableDate" id="categories" value="Categories">
                <label class="form-check-label custom-radio-label active" for="categories">Toutes les catégories</label>
            </div>

            <div class="form-check mt-5">
                <input class="form-check-input" type="radio" name="selectedTableDate" id="products" value="Products">
                <label class="form-check-label custom-radio-label" for="products">Tous les produits</label>
            </div>
        </div>

        <div id="table-container" class="mt-5">
            <table id="table" class="table table-striped display custom-table" style="width:100%">
                <thead id="thead">

                    <th id="0">Numéro de catégorie</th>
                    <th id="1">Nom</th>
                    <th id="2">Numéro de catégorie parent</th>
                    <th id="3">Prix</th>
                    <th id="4">Taux TVA</th>
                    <th id="5">Numéro fournisseur</th>
                    <th id="6">Référence fournisseur</th>
                    <th id="7">Nom long</th>
                    <th id="8">Photo</th> 

                </thead>

                <tbody id="tbody">
                    <?php foreach ($categories as $row) : ?>
                        <tr>

                            <td><?php echo $row['Id_Categorie']; ?></td>
                            <td><?php echo $row['Libelle']; ?></td>
                            <td><?php echo ($row['Id_Categorie_Parent'] !== null) ? $row['Id_Categorie_Parent'] : 'N/A'; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- d-flex flex-column align-items-center justify-content-center GRANDE BOITE CENTREE -->
        <!-- my-auto CENTRER PETITE BOITE -->

        <div class="row" id="formulaires">
            <div id="caseAddProduct" class="col-xl-4 my-5">
                <h2 class="mt-5 mb-3">Ajouter un produit</h2>
                <input type="text" id="shortName" name="shortName" class="mb-1 w-50 mx-auto d-block" placeholder="Nom court du produit">
                <input type="text" id="longName" name="longName" class="mb-1 w-50 mx-auto d-block" placeholder="Nom long du produit">
                <input type="text" id="price" name="price" class="mb-1 w-50 mx-auto d-block" placeholder="Prix du produit">
                <input type="text" id="rateVAT" name="rateVAT" class="mb-1 w-50 mx-auto d-block" placeholder="Taux TVA du produit">
                <input type="text" id="supplierRef" name="supplierRef" class="mb-1 w-50 mx-auto d-block" placeholder="Référence fournisseur du produit">
                <input type="text" id="supplierID" name="supplierID" class="mb-1 w-50 mx-auto d-block" placeholder="ID_Fournisseur du produit">
                <input type="text" id="categoryID" name="categoryID" class="mb-1 w-50 mx-auto d-block" placeholder="ID_Catégorie du produit">
                <input type="text" id="pictureLink" name="pictureLink" class="mb-1 w-50 mx-auto d-block" placeholder="Image du produit">
                <input type="submit" id="addProduct" class="btn btn-lg btn-primary mt-3 mb-5" value="Ajouter un produit">
            </div>

            <div id="caseUpdateProduct" class="col-xl-4 my-5">
                <h2 class="mt-5 mb-3">Modifier un produit</h2>
                <input type="text" name="referenceProduct" id="inputUpdateProduct" class="mb-1 w-50 mx-auto d-block" placeholder="Numéro du produit"><br>
                <select name="updateTypeProduct" id="updateTypeProduct" class="mb-1 w-50 mx-auto d-block">
                    <option selected disabled>Que voulez-vous modifier ?</option>
                    <option value="Nom_court">Nom court</option>
                    <option value="Nom_Long">Nom long</option>
                    <option value="Prix_Achat">Prix</option>
                    <option value="Taux_TVA">Taux TVA</option>
                    <option value="Ref_fournisseur">Référence fournisseur</option>
                    <option value="Id_Fournisseur">ID Fournisseur</option>
                    <option value="Id_Category">ID Catégorie</option>
                    <option value="Photo">Lien vers image</option>
                </select>
                <input type="text" id="updateValueProduct" name="updateValueProduct" class="mb-1 w-50 mx-auto d-block" placeholder="Modification"><br>
                <button id="updateProduct" class="btn btn-lg btn-danger mt-3 mb-5">Modifier un produit</button><br>
            </div>

            <div id="caseDeleteProduct" class="col-xl-4 my-5">
                <h2 class="mt-5 mb-3">Supprimer un produit</h2>
                <input type="text" name="supprimer" id="inputDeleteProduct" class="mb-1 w-50 mx-auto d-block" placeholder="Numéro de produit">
                <button id="deleteProduct" class="btn btn-lg btn-danger mt-3 mb-5" for="deleteProduct">Supprimer un produit</button>
            </div>

            <div id="caseAddCategory" class="col-xl-4 my-5">
                <h2 class="mt-5 mb-3">Ajouter une catégorie</h2>
                <input type="text" id="libelle_categorie" name="libelle_categorie" class="mb-1 w-50 mx-auto d-block" placeholder="Numéro de catégorie">
                <input type="submit" id="addCategory" class="btn btn-lg btn-primary mt-3 mb-5" value="Ajouter une catégorie">
            </div>

            <div id="caseUpdateCategory" class="col-xl-4 my-5">
                <h2 class="mt-5 mb-3">Modifier une catégorie</h2>
                <input type="text" name="reference" id="inputModif" class="mb-1 w-50 mx-auto d-block" placeholder="Numéro de catégorie"><br>
                <select name="modificationType" id="modificationType" class="mb-1 w-50 mx-auto d-block">
                    <option selected disabled>Que voulez-vous modifier ?</option>
                    <option value="libelle" selected>Titre</option>
                    <option value="id_categorie_parent">ID Catégorie Parent</option>
                </select>
                <input type="text" id="modification" name="modification" class="mb-1 w-50 mx-auto d-block" placeholder="Modification"><br>
                <button id="updateCategory" class="btn btn-lg btn-danger mt-3 mb-5" for="updateCategory">Modifier une catégorie</button><br>
            </div>

            <div id="caseDeleteCategory" class="col-xl-4 my-5">
                <h2 class="mt-5 mb-3">Supprimer une catégorie</h2>
                <input type="text" name="supprimer" id="inputDeleteCategory" class="mb-1 w-50 mx-auto d-block" placeholder="Numéro de catégorie">
                <button id="deleteCategory" class="btn btn-lg btn-danger mt-3 mb-5" for="deleteCategory">Supprimer une catégorie</button>
            </div>

        </div>
    </div>

    <footer id="sticky-footer" class="flex-shrink-0 py-4 bg-dark text-white-50">
        <div id="participants" class="d-flex flex-row justify-content-around">
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