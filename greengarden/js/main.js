$(document).ready(function () {
    // Gestion des affichages
    // Masquer les catégories
    function hideAllCategories() {
        $('.category-section').addClass('d-none');
    }
    // Afficher les catégories
    function displayAllCategories() {
        $('.category-section').removeClass('d-none')
    }
    // Masquer les produits
    function hideAllProducts() {
        $('.products-container').addClass('d-none');
    }
    // Afficher les produits
    function displayAllProducts() {
        $('.products-container').removeClass('d-none')
    }

    const categoryLinks = document.querySelectorAll('.category-link');
    // Ajouter un gestionnaire d'événements de clic à chaque lien de catégorie
    categoryLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            // Empêcher le comportement par défaut du lien
            event.preventDefault();

            // Récupérer l'identifiant de la catégorie à partir des données
            const categoryId = this.getAttribute('data-category-id');

            // Afficher les produits associés à la catégorie sélectionnée
            displayProductsByCategory(categoryId);
        });
    });

    function displayProductsByCategory(categoryId, categorySection) {
        // Requête Ajax pour récupérer les produits associés à la catégorie
        $.ajax({
            url: './scripts/getProducts.php', 
            method: 'GET',
            data: { categoryId: categoryId },
            success: function (response) {
                // Hide all categories
                hideAllCategories();
                displayAllProducts();

                $('.products-container').html(response);
            },
            error: function (error) {
                console.error('Erreur lors de la récupération des produits:', error);
            }
        });
    }

    // Fonction pour afficher la section de catégorie sélectionnée et les produits associés
    function displayCategory(categoryId) {
        // Affichez la section de catégorie correspondant à l'identifiant
        const categorySection = $(`#category_${categoryId}`);
        categorySection.removeClass('d-none');
        // Récupérez et affichez les produits associés à la catégorie
        categorySection.find('.products-container').html(productsHTML);
    }

    // Gestionnaire d'événements pour le changement de radio (Toutes les catégories ou Produits)
    $('input[name="couleur"]').change(function () {
        const value = $(this).val();
        if (value === 'Categories') {
            // Afficher toutes les catégories
            displayAllCategories();
            hideAllProducts();
        } 
        // else if (value === 'Products') {
        //     // Afficher tous les produits (ou une liste de produits par défaut)
        //     displayAllProducts();
        // }
    });

    $('#addCategory').on('click', function () {
        // Récupère les valeurs des différents champs du formulaire pour ajouter une catégorie
        let selectedtitle = $('#libelle_categorie').val();

        // Prépare les données à envoyer via la requête AJAX
        let dataToSend = {
            Libelle: selectedtitle
        };
        // Effectue une requête AJAX pour ajouter une catégorie
        $.ajax({  
            url: './scripts/addCategory.php',
            type: 'GET',
            data: dataToSend,
            success: function (data) {
                console.log("Catégorie ajoutée.");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#updateCategory').on('click', function () {
        // Récupère les valeurs des champs du formulaire pour la modification
        let reference = $('#inputModif').val();
        let modificationType = $('#modificationType').val();
        let modificationValue = $('#modification').val();
        // Effectue une requête AJAX pour modifier une catégorie
        $.ajax({
            url: './scripts/updateCategory.php',
            type: 'GET',
            data: {
                reference: reference,
                modificationType: modificationType,
                modification: modificationValue
            },
            success: function (data) {
                console.log("Catégorie modifiée.");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#deleteCategory').on('click', function () {
        // Récupère la valeur de l'élément d'entrée 'inputSupr'
        let selectedCategory = $('#inputDeleteCategory').val();
        let dataToSend = { selectedCategory: selectedCategory };// Prépare les données à envoyer via la requête AJAX
        // Effectue une requête AJAX pour supprimer une catégorie
        $.ajax({
            url: './scripts/deleteCategory.php',
            type: 'GET',
            data: dataToSend,
            success: function (data) {
                console.log("Catégorie supprimée.");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#addProduct').on('click', function () {
        // Récupère les valeurs des différents champs du formulaire pour ajouter un livre
        let selectedShortName = $('#shortName').val();
        let selectedLongName = $('#longName').val();
        let selectedPrice = $('#price').val();
        let selectedRateVAT = $('#rateVAT').val();
        let selectedSupplierRef = $('#supplierRef').val();
        let selectedSupplierID = $('#supplierID').val();
        let selectedCategoryID = $('#categoryID').val();
        let selectedPicture = $('#pictureLink').val();
        // Prépare les données à envoyer via la requête AJAX
        let dataToSend = {
            shortName: selectedShortName,
            longName: selectedLongName,
            price: selectedPrice,
            rateVAT: selectedRateVAT,
            supplierRef: selectedSupplierRef,
            supplierID: selectedSupplierID,
            categoryID: selectedCategoryID,
            pictureLink: selectedPicture
        };

        $.ajax({  
            url: './scripts/addProduct.php',
            type: 'GET',
            data: dataToSend,
            success: function (data) {
                console.log("Produit ajouté.");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#updateProduct').on('click', function () {
        // Récupère les valeurs des champs du formulaire pour la modification
        let reference = $('#inputUpdateProduct').val();
        let updateTypeProduct = $('#updateTypeProduct').val();
        let updateValueProduct = $('#updateValueProduct').val();



        console.log(reference);
        console.log(updateTypeProduct);
        console.log(updateValueProduct);
        // Effectue une requête AJAX pour modifier une catégorie
        $.ajax({
            url: './scripts/updateProduct.php',
            type: 'GET',
            data: {
                reference: reference,
                updateTypeProduct: updateTypeProduct,
                updateValueProduct: updateValueProduct
            },
            success: function (data) {
                console.log("Produit modifié.");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#deleteProduct').on('click', function () {
        // Récupère la valeur de l'élément d'entrée 'inputSupr'
        let selectedProduct = $('#inputDeleteProduct').val();
        let dataToSend = { selectedProduct: selectedProduct };// Prépare les données à envoyer via la requête AJAX
        // Effectue une requête AJAX pour supprimer une catégorie
        $.ajax({
            url: './scripts/deleteProduct.php',
            type: 'GET',
            data: dataToSend,
            success: function (data) {
                console.log("Produit supprimé.");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
























    // Style pour masquer le bouton radio
    $('.form-check-input').css({
        'position': 'absolute',
        'clip': 'rect(1px, 1px, 1px, 1px)'
    });

    // Personnalisation des boutons radio
    $('.custom-radio-label').css({
        'background-color': '#5f487a', // Couleur de fond par défaut
        'color': '#fff', // Couleur du texte par défaut
        'border': '1px solid #5f487a', // Bordure par défaut
        'padding': '0.5em', // Ajout de padding
        'border-radius': '10px', // Arrondit le bord des boutons
        'cursor': 'pointer' // Ajout d'un curseur pointer pour indiquer que le texte est cliquable
    });

    // Mettez en surbrillance le bouton "Livres" s'il est actif
    $('.custom-radio-label.active').css({
        'background-color': 'firebrick', // Nouvelle couleur de fond lors de la sélection
        'border-color': '#5f487a' // Nouvelle couleur de bordure lors de la sélection
    });

    // Écoutez les clics sur les boutons radio
    $('.form-check-input').on('change', function () {
        // Réinitialisez le style pour tous les boutons radio
        $('.custom-radio-label').css({
            'background-color': '#5f487a',
            'color': '#fff',
            'border': '1px solid #5f487a'
        });

        // Mettez en surbrillance le bouton sélectionné
        if ($(this).is(':checked')) {
            $(this).next('.custom-radio-label').css({
                'background-color': 'firebrick', // Nouvelle couleur de fond lors de la sélection
                'border-color': '#5f487a' // Nouvelle couleur de bordure lors de la sélection
            });
        }
    });

    var table = $('#table_livre').DataTable({ //Tableau principale
        "footerCallback": function (row, data, start, end, display) { //Footer du tableau principale , qui affiche le total de ligne
            var api = this.api();
            var nbr = api.rows({ search: 'applied' }).count()
            if (document.querySelector('#books').checked) {
                api.column(0).footer().innerHTML = "Total de livres :" + nbr;
            }
            else if (document.querySelector('#users').checked) {
                api.column(0).footer().innerHTML = "Total d'utilisateurs' :" + nbr;
            } else {
                api.column(0).footer().innerHTML = "Total d'emprunts' :" + nbr;
            }
        },


        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
        },


    });

    var tableEU = $('#table_Emprunts_User').DataTable({ //Tableau modale
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api();
            var nbr = api.rows({ search: 'applied' }).count()
            api.column(0).footer().innerHTML = "Total d'emprunts' :" + nbr;
        },
    });

    $('#books').on('click', function () { //On affiche tous les livres lors du clique sur le bouton radio
        $("#caseModif").show();
        $.ajax({//Requete AJAX
            url: 'drawBooks.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                i = 0;
                //On ajuste le nombre de colonne
                table.column(3).visible(true);
                table.column(4).visible(true);
                table.column(5).visible(true);
                table.clear().draw();//on vide le tableau
                document.getElementById('0').innerHTML = "Numéro"; //On ajuste le thead pour avoir les bons noms de colonnes
                document.getElementById('1').innerHTML = "Titre";
                document.getElementById('2').innerHTML = "Auteurs";
                document.getElementById('3').innerHTML = "Résumé";
                document.getElementById('4').innerHTML = "Catégories";
                document.getElementById('5').innerHTML = "Statut";
                $.each(data, function (index, books) {//On remplit le tableau avec la réponse du json
                    table.row.add([books.id_book,
                    books.title,
                    books.authors,
                    books.shortDescription,
                    books.categories,
                    books.IsAvailable
                    ]).draw();

                });
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Gérer les erreurs ici
            }
        });
    });




    // $('#categories').on('click', function () { 
    //     $("#caseModif").show();
    //     $.ajax({//Requete AJAX
    //         url: 'drawBooks.php',
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function (data) {
    //             i = 0;
    //             //On ajuste le nombre de colonne
    //             table.column(3).visible(true);
    //             table.column(4).visible(true);
    //             table.column(5).visible(true);
    //             table.clear().draw();//on vide le tableau
    //             document.getElementById('0').innerHTML = "Numéro"; //On ajuste le thead pour avoir les bons noms de colonnes
    //             document.getElementById('1').innerHTML = "Titre";
    //             document.getElementById('2').innerHTML = "Auteurs";
    //             document.getElementById('3').innerHTML = "Résumé";
    //             document.getElementById('4').innerHTML = "Catégories";
    //             document.getElementById('5').innerHTML = "Statut";
    //             $.each(data, function (index, books) {//On remplit le tableau avec la réponse du json
    //                 table.row.add([books.id_book,
    //                 books.title,
    //                 books.authors,
    //                 books.shortDescription,
    //                 books.categories,
    //                 books.IsAvailable
    //                 ]).draw();

    //             });
    //         },
    //         error: function (xhr, status, error) {
    //             console.error(error);
    //             // Gérer les erreurs ici
    //         }
    //     });
    // });



    


    $('#users').on('click', function () {//On affiche tous les users lors du clique sur le bouton radio
        $.ajax({
            url: 'drawUsers.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                i = ""; //Valeur vide , qu'on utilise pour remplir les colonnes surperflues
                table.column(3).visible(false);//On ajuste le nombre de colonne
                table.column(4).visible(false);
                table.column(5).visible(false);
                table.clear().draw();//on vide le tableau
                document.getElementById('0').innerHTML = "ID"; //On ajuste le thead pour avoir les bons noms de colonnes
                document.getElementById('1').innerHTML = "Nom";
                document.getElementById('2').innerHTML = "Prénom";
                $.each(data, function (index, users) {//On remplit le tableau avec la réponse du json
                    table.row.add([users.id_user,
                    users.name,
                    users.first_name, i, i, i,
                    ]).draw();

                });
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Gérer les erreurs ici
            }
        });
    });

    $('#borrows').on('click', function () {//On affiche tous les livres lors du clique sur le bouton radio
        $.ajax({
            url: 'drawBorrows.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                table.column(3).visible(true);//On ajuste le nombre de colonne
                table.column(4).visible(true);
                table.column(5).visible(true);
                table.clear().draw();//on vide le tableau
                document.getElementById('0').innerHTML = "Numéro d'emprunt"; //On ajuste le thead pour avoir les bons noms de colonnes
                document.getElementById('1').innerHTML = "Numéro de livre";
                document.getElementById('2').innerHTML = "Numéro de User";
                document.getElementById('3').innerHTML = "Date d'emprunt";
                document.getElementById('4').innerHTML = "Date de retour";
                document.getElementById('5').innerHTML = "Jours restants";

                $.each(data, function (index, books) {//On remplit le tableau avec la réponse du json
                    table.row.add([books.id_borrow,
                    books.book_id,
                    books.user_id,
                    books.borrowDate,
                    books.returnDate,
                    books.days_Remaining
                    ]).draw();
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Gérer les erreurs ici
            }
        });
    });

    $('#table_livre').on('click', 'td', function () {
        // Récupérer les données de la ligne cliquée
        var rowData = table.row(this).data(); // Récupérer les données de la ligne
        var selectedBook = rowData[0];
        var dataToSend = { selectedBook: selectedBook }; // Préparer les données à envoyer
        $('#myModal').modal('show');// Afficher la modale
        if (document.querySelector('#books').checked) {// Vérifier si le bouton radio 'books' est coché
            $.ajax({ // Appel AJAX pour récupérer les informations sur le livre
                url: 'descriptionBook.php',
                type: 'GET',
                dataType: 'json',
                data: dataToSend,
                success: function (data) {
                    // Traiter les données et afficher les détails du livre dans la fenêtre modale
                    if (Array.isArray(data) && data.length > 0) {
                        const firstBook = data[0]; // Accès au premier (et unique) objet dans le tableau
                        let modalContent = '';
                        modalContent += `Titre: ${firstBook.title || "Donnée indisponible"} <br>`;
                        modalContent += `ISBN: ${firstBook.isbn || "Donnée indisponible"} <br>`;
                        modalContent += `Page Count: ${firstBook.pageCount || "Donnée indisponible"} <br>`;
                        modalContent += `Date de publication: ${firstBook.publishedDate || "Donnée indisponible"} <br>`;
                        modalContent += `<img src="${firstBook.thumbnailUrl || "URL indisponible"}"> <br>`;
                        modalContent += `Description courte: ${firstBook.shortDescription || "Donnée indisponible"} <br>`;
                        modalContent += `Description Longue: ${firstBook.longDescription || "Donnée indisponible"} <br>`;
                        modalContent += `Auteurs: ${firstBook.authors || "Donnée indisponible"} <br>`;
                        modalContent += `Catégories: ${firstBook.categories || "Donnée indisponible"} <br>`;
                        if (firstBook.IsAvailable) {
                            isAvailable = "Empruntable";
                        }
                        else {
                            isAvailable = "Emprunté";
                        }
                        modalContent += `Disponibilité: ${isAvailable || "Donnée indisponible"} <br>`;
                        modalContent += `ID du livre: ${firstBook.id_book || "Donnée indisponible"} <br>`;
                        if (isAvailable == "Emprunté") {
                            modalContent += `Prénom de l'emprunteur: ${firstBook.name || "Donnée indisponible"} <br>`;
                            modalContent += `Nom de l'emprunteur: ${firstBook.first_name || "Donnée indisponible"} <br>`;
                        }
                        // Définir le titre et le corps de la fenêtre modale avec les détails du livre
                        document.getElementById('modalTitle').innerText = firstBook.title;
                        document.getElementById('modalBody').innerHTML = modalContent;
                    } else {
                        console.error("Aucune donnée disponible.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    // Gérer les erreurs ici
                }
            });
        }
        else if (document.querySelector('#users').checked) {// Vérifier si le bouton radio 'users' est coché
            $('#tableEU').show();
            // Préparer la structure HTML pour le tableau
            let modalContent = `<div> <!-- Ceci est un conteneur pour le tableau -->
            <table id="tableEU" class="table table-striped display" style="width:100%">
                <thead>
                    <tr>
                        <th>Numéro de livre</th>
                        <th>Numéro de User</th>
                        <th>Date d'emprunt</th>
                        <th>Date de Retour</th>
                        <th>Numéro d'emprunt</th>
                        <th>Jours restants</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Les lignes de données seront remplies ici via JavaScript -->
                </tbody>
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
        </div>`;
            document.getElementById('modalBody').innerHTML = modalContent;  // Insérer la structure HTML préparée dans le corps de la fenêtre modale
            // Récupérer et définir le titre de la fenêtre modale en utilisant les données de la ligne cliquée
            document.getElementById('modalTitle').innerText = rowData[1];
            document.getElementById('modalTitle').innerText += " ";
            document.getElementById('modalTitle').innerText += rowData[2];
            $.ajax({// Effectuer une requête AJAX pour obtenir des données et les afficher dans le tableau
                url: 'empruntsEmploye.php',
                type: 'GET',
                dataType: 'json',
                data: dataToSend,
                success: function (data) {
                    $.each(data, function (index, rowData) { // Parcourir les données et ajouter chaque ligne au tableau
                        $('#tableEU tbody').append(`
                            <tr>
                                <td>${rowData.book_id}</td>
                                <td>${rowData.user_id}</td>
                                <td>${rowData.borrowDate}</td>
                                <td>${rowData.returnDate}</td>
                                <td>${rowData.id_borrow}</td>
                                <td>${rowData.days_Remaining}</td>
                            </tr>
                        `);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    console.log("hallo");
                }
            });
        }
        else {//Sinon (dans le cas où ni le bouton 'books' ni le bouton 'users' ne sont cochés=>borrow)
            // Récupérer les données de la ligne cliquée
            rowData = table.row(this).data();
            selectedBook = rowData[1];
            dataToSend = { selectedBook: selectedBook };
            $.ajax({    // Effectuer une requête AJAX pour obtenir les détails du livre
                url: 'descriptionBook.php',
                type: 'GET',
                dataType: 'json',
                data: dataToSend,
                success: function (data) {
                    if (Array.isArray(data) && data.length > 0) {
                        const firstBook = data[0]; // Accès au premier (et unique) objet dans le tableau
                        // Construire le contenu de la fenêtre modale avec les détails du livre et du user
                        let modalContent = '';
                        modalContent += `Titre: ${firstBook.title || "Donnée indisponible"} <br>`;
                        modalContent += `ISBN: ${firstBook.isbn || "Donnée indisponible"} <br>`;
                        modalContent += `Page Count: ${firstBook.pageCount || "Donnée indisponible"} <br>`;
                        modalContent += `Date de publication: ${firstBook.publishedDate || "Donnée indisponible"} <br>`;
                        modalContent += `<img src="${firstBook.thumbnailUrl || "URL indisponible"}"> <br>`;
                        modalContent += `Description courte: ${firstBook.shortDescription || "Donnée indisponible"} <br>`;
                        modalContent += `Description Longue: ${firstBook.longDescription || "Donnée indisponible"} <br>`;
                        modalContent += `Auteurs: ${firstBook.authors || "Donnée indisponible"} <br>`;
                        modalContent += `Catégories: ${firstBook.categories || "Donnée indisponible"} <br>`;
                        // Vérifier la disponibilité du livre et affecter la valeur correspondante à isAvailable
                        if (firstBook.IsAvailable) {
                            isAvailable = "Empruntable";
                        }
                        else {
                            isAvailable = "Emprunté";
                        }
                        modalContent += `Disponibilité: ${isAvailable || "Donnée indisponible"} <br>`;
                        modalContent += `ID du livre: ${firstBook.id_book || "Donnée indisponible"} <br>`;
                        modalContent += `Prénom de l'emprunteur: ${firstBook.name || "Donnée indisponible"} <br>`;
                        modalContent += `Nom de l'emprunteur: ${firstBook.first_name || "Donnée indisponible"} <br>`;
                        // Mettre à jour le contenu de la fenêtre modale avec les détails du livre
                        document.getElementById('modalTitle').innerText = firstBook.title;

                        document.getElementById('modalBody').innerHTML = modalContent;
                    } else {
                        console.error("Aucune donnée disponible.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    let modalContent = '';
                    // Effacer le contenu de la fenêtre modale et afficher un message indiquant l'absence de données
                    document.getElementById('modalBody').innerHTML = modalContent;
                    document.getElementById('modalTitle').innerText = "Le livre lié à cet emprunt et/ou l'utilisateur ne sont plus répertoriés ";
                }
            });
        }
    });

    $('#borrow').on('click', function () {
        let id_user = $('#inputUserBorrow').val(); // Récupère les valeurs des champs input contenant les identifiants de l'utilisateur et du livre
        let id_book = $('#inputBookBorrow').val();
        // Prépare les données à envoyer via la requête AJAX
        let dataToSend = { id_book: id_book, id_user: id_user };
        $.ajax({// Effectue une requête AJAX pour emprunter un livre
            url: 'borrowBook.php',
            type: 'GET',
            data: dataToSend,
            success: function (data) {
                $.ajax({// Requête AJAX pour récupérer les données de prêts à afficher dans une DataTable
                    url: 'drawBorrows.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        table.clear().draw();
                        $.each(data, function (index, books) { // Nettoie et redessine la DataTable avec les nouvelles données récupérées
                            table.row.add([books.id_borrow,
                            books.book_id,
                            books.user_id,
                            books.borrowDate,
                            books.returnDate,
                            books.days_Remaining
                            ]).draw();
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#return').on('click', function () {
        // Récupère la valeur du champ input contenant l'identifiant de l'emprunt
        let id_borrow = $('#inputBorrow').val();

        let dataToSend = { id_borrow: id_borrow };  // Prépare les données à envoyer via la requête AJAX

        $.ajax({  // Effectue une requête AJAX pour retourner un livre
            url: 'returnBook.php',
            type: 'GET',
            data: dataToSend,
            success: function (data) {



                $.ajax({// Requête AJAX pour mettre à jour la DataTable après le retour du livre
                    url: 'drawBorrows.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        table.clear().draw();
                        $.each(data, function (index, books) { // Nettoie et redessine la DataTable avec les nouvelles données de prêts
                            table.row.add([books.id_borrow,
                            books.book_id,
                            books.user_id,
                            books.borrowDate,
                            books.returnDate,
                            books.days_Remaining
                            ]).draw();
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });



    $('#addUser').on('click', function () {
        // Récupère les valeurs des champs du formulaire pour ajouter un utilisateur
        var selectedName = $('#name').val();
        var selectedFirst_name = $('#first_name').val();
        var dataToSend = { // Prépare les données à envoyer via la requête AJAX
            name: selectedName,
            first_name: selectedFirst_name,
        };
        $.ajax({// Effectue une requête AJAX pour ajouter un utilisateur
            url: 'addUser.php',
            type: 'GET',
            data: dataToSend,
            success: function (data) {

                $.ajax({ // Effectue une autre requête AJAX pour récupérer les données d'utilisateurs mises à jour
                    url: 'drawUsers.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        i = "";
                        table.clear().draw();
                        $.each(data, function (index, users) { // Nettoie et redessine la table de livres ('table')
                            table.row.add([users.id_user,
                            users.name,
                            users.first_name, i, i, i,
                            ]).draw();
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        // Gérer les erreurs ici
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Gérer les erreurs ici
            }

        });

    });

    


    // GESTION DES AFFICHAGES
    $("#caseAddUser").hide();
    $('#caseBorrow').hide();
    $('#caseReturn').hide();

    $("input[name='couleur']").change(function () {
        if ($(this).val() === "Livres") {
            $('#caseAddBook').show();
            $('#caseModifAndSuppr').show();
        } else {
            $('#caseAddBook').hide();
            $('#caseModifAndSuppr').hide();
        }
    });

    $("input[name='couleur']").change(function () {
        if ($(this).val() === "Utilisateurs") {
            $("#caseAddUser").show();
        } else {
            $("#caseAddUser").hide();
        }
    });

    $("input[name='couleur']").change(function () {
        if ($(this).val() === "Emprunts") {
            $('#caseBorrow').show();
            $('#caseReturn').show();
        } else {
            $('#caseBorrow').hide();
            $('#caseReturn').hide();
        }
    });

});