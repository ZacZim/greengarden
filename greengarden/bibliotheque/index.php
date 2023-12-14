<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothéque</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />

    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <header>
        <div class="d-flex flex-row container text-center">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <img src="monogram-2670684_1280.png" alt="logo Médiathèque" class="custom-img">
                    <h1 class="fw-light mt-3 text-white">
                        Gestion de la Médiathèque
                    </h1>
                </div>
            </div>
        </div>
    </header>
    
    <?php
    require_once("dao.php");
    $dao = new DAO();

    //on se connecte
    $dao->connexion();

    //on récupère tous les livres et on les affiche
    $books = $dao->getBooks();
    ?>



    <div class="container-fluid">
        <div class="row">
            <!-- Colonne Bootstrap pour les filtres -->
            <div class="col-md-2 d-flex flex-row flex-md-column align-items-center my-auto justify-content-center">
                <!-- Sélection des filtres -->
                <div class="form-check mt-5">
                    <input class="form-check-input" type="radio" name="couleur" id="books" value="Livres" checked>
                    <label class="form-check-label custom-radio-label active" for="books">Livres</label>
                </div>

                <div class="form-check mt-5">
                    <input class="form-check-input" type="radio" name="couleur" id="users" value="Utilisateurs">
                    <label class="form-check-label custom-radio-label" for="users">Utilisateurs</label>
                </div>

                <div class="form-check mt-5">
                    <input class="form-check-input" type="radio" name="couleur" id="borrows" value="Emprunts">
                    <label class="form-check-label custom-radio-label" for="borrows">Emprunts</label>
                </div>
            </div>

            <!-- Colonne Bootstrap pour le tableau -->
            <div id="table-container" class="col-md-10 mt-5">
                <!-- Tableau pour afficher les données -->
                <table id="table_livre" class="table table-striped display custom-table" style="width:100%">

                    <!-- En-tête du tableau -->
                    <thead id="thead">
                        <th id="0">Numéro</th>
                        <th id="1">Titre</th>
                        <th id="2">Auteurs</th>
                        <th id="3">Résumé</th>
                        <th id="4">Catégories</th>
                        <th id="5">Statut</th>
                    </thead>

                    <!-- Corps du tableau -->
                    <div id="tbody"></div>
                    <tbody id="tbody">
                        <!-- Boucle pour afficher les données dynamiquement -->
                        <?php foreach ($books as $row) : ?>
                            <tr>
                                <td><?php echo $row['id_book']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['authors']; ?></td>
                                <td><?php echo $row['shortDescription']; ?></td>
                                <td> <?php echo $row['categories']; ?> </td>
                                <td><?php echo ($row['IsAvailable'] == 0) ? "Emprunté" : "Empruntable"; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <!-- Pied de tableau (facultatif) -->
                    <tfoot id="tfoot">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="modal fade col-12" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- En-tête du modal -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Corps du modal -->
                    <div class="modal-body" id="modalBody">
                        <!-- Tableau dans le corps du modal -->
                        <table id="tableEU" class="table table-striped display " style="width:100%">
                            <!-- En-tête du tableau -->
                            <thead id="thead">
                                <tr>
                                    <th>book_id</th>
                                    <th>user_id</th>
                                    <th>borrowDate</th>
                                    <th>returnDate</th>
                                    <th>id_borrow</th>
                                    <th>days_Remaining</th>
                                </tr>
                            </thead>
                            <!-- Corps du tableau -->
                            <tbody>
                                <!-- Contenu du tableau vide pour affichage futur -->
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <!-- Pied de tableau -->
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- d-flex flex-column align-items-center justify-content-center GRANDE BOITE CENTREE -->
        <!-- my-auto CENTRER PETITE BOITE -->

        <div class="row" id="formulaires">
            <!-- AJOUTER LIVRE -->
            <div id="caseAddBook" class="col-xl-4 my-5">
                <h2 class="mt-5 mb-3">Ajouter un livre</h2>
                <input type="text" id="title" name="title" class="mb-1 w-50 mx-auto d-block" placeholder="Titre">
                <input type="text" id="isbn" name="isbn" class="mb-1 w-50 mx-auto d-block" placeholder="ISBN">
                <input type="text" id="thumbnailUrl" name="thumbnailUrl" class="mb-1 w-50 mx-auto d-block" placeholder="Image de présentation">
                <input type="text" id="authors" name="authors" class="mb-1 w-50 mx-auto d-block" placeholder="Auteur(s)">
                <input type="text" id="categories" name="categories" class="mb-1 w-50 mx-auto d-block" placeholder="Catégorie(s)">
                <input type="text" id="pageCount" name="pageCount" class="mb-1 w-50 mx-auto d-block" placeholder="Nombre de pages">
                <input type="text" id="publishedDate" name="publishedDate" class="mb-1 w-50 mx-auto d-block" placeholder="Date de publication">
                <input type="text" id="shortDescription" name="shortDescription" class="mb-1 w-50 mx-auto d-block" placeholder="Court résumé">
                <input type="text" id="longDescription" name="longDescription" class="mb-1 w-50 mx-auto d-block" placeholder="Long résumé">
                <input type="text" id="IsAvailable" name="IsAvailable" class="mb-1 w-50 mx-auto d-block" placeholder="Disponibilité">
                <input type="submit" id="addBook" class="btn btn-lg btn-primary mt-3 mb-5" value="Ajouter un nouveau livre">
            </div>

            <div id="caseModifAndSuppr" class="col-xl-4">
                <!-- MODIFIER LIVRE -->
                <div id="caseModif" class="col my-auto mb-5">
                    <h2 class="mt-5 mb-3">Modifier un livre</h2>
                    <input type="text" name="reference" id="inputModif" class="mb-1 w-50 mx-auto d-block" placeholder="Numéro du livre à modifier"><br>
                    <select name="modificationType" id="modificationType" class="mb-1 w-50 mx-auto d-block">
                        <option value="modif" selected disabled>Que voulez-vous modifier ?</option>
                        <option value="title">Titre</option>
                        <option value="authors">Auteur</option>
                        <option value="shortDescription">Résumé</option>
                        <option value="IsAvailable">Statut</option>
                    </select>
                    <input type="text" id="modification" name="modification" class="mb-1 w-50 mx-auto d-block" placeholder="Modification"><br>
                    <button id="modifier" class="btn btn-lg btn-danger mt-3 mb-5" for="modifier">Modifier un livre</button><br>
                </div>

                <!-- SUPPRIMER LIVRE -->
                <div id="caseSuppr" class="col my-auto">
                    <h2 class="mt-5 mb-3">Supprimer un livre</h2>
                    <input type="text" name="supprimer" id="inputSupr" class="mb-1 w-50 mx-auto d-block" placeholder="Numéro du livre">
                    <button id="supprimer" class="btn btn-lg btn-danger mt-3 mb-5" for="supprimer">Supprimer un livre</button>
                </div>
            </div>

            <!-- AJOUTER UTILISATEUR -->
            <div id="caseAddUser" class="col-xl-4">
                <h2 class="mt-5 mb-3">Ajouter un utilisateur</h2>
                <input type="text" id="name" name="name" class="mb-1 w-50 mx-auto d-block" placeholder="Nom">
                <input type="text" id="first_name" name="first_name" class="mb-1 w-50 mx-auto d-block" placeholder="Prénom">
                <button id="addUser" class="btn btn-lg btn-primary mt-3 mb-5" for="supprimer">Ajouter un nouvel utilisateur</button>
            </div>

            <!-- EMPRUNTER LIVRE -->
            <div id="caseBorrow" class="col-xl-4 my-5">
                <h2 class="mt-5 mb-3">Emprunt</h2>
                <input type="text" name="inputUserBorrow" id="inputUserBorrow" class="mb-1 w-50 mx-auto d-block" placeholder="Numéro de l'utilisateur">
                <input type="text" name="inputBookBorrow" id="inputBookBorrow" class="mb-3 w-50 mx-auto d-block" placeholder="Numéro du livre">
                <button id="borrow" class="btn btn-lg btn-primary mt-3 mb-5" for="borrow">Valider l'emprunt</button>
            </div>

            <!-- RENDRE LIVRE -->
            <div id="caseReturn" class="col-xl-4 my-auto">
                <h2 class="mt-5 mb-3">Retour</h2>
                <input type="text" name="inputBorrow" id="inputBorrow" class="mb-3 w-50 mx-auto d-block" placeholder="Numéro de l'emprunt">
                <button id="return" class="btn btn-lg btn-primary mt-3 mb-5" for="return">Valider le retour</button>
            </div>

        </div>


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
                <h4>Alexandre Mouchez</h4>
                <a target="#" href="https://github.com/AlexMouchez">Voir Github</a>
            </div>
            <div class="text-center">
                <h4>Lilly Burtin</h4>
                <a target="#" href="https://github.com/Lillyfoks">Voir Github</a>
            </div>
            <div class="text-center">
                <h4>Nico Jeangeorges</h4>
                <a target="#" href="https://github.com/toki54">Voir Github</a>
            </div>
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
    <script src="gestion.js"></script>

</body>

</html>