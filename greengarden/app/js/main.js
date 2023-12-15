$(document).ready(function () {

    // Rendre les cartes cliquables + afficher les produits de la carte cliquée
    const categoryLinks = document.querySelectorAll('.category-link');
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

    $('#addCategory').on('click', function () {
        let selectedtitle = $('#libelle_categorie').val();
        let dataToSend = {
            Libelle: selectedtitle
        };
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
        let reference = $('#inputModif').val();
        let modificationType = $('#modificationType').val();
        let modificationValue = $('#modification').val();
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
        let selectedCategory = $('#inputDeleteCategory').val();
        let dataToSend = { selectedCategory: selectedCategory };
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
        let reference = $('#inputUpdateProduct').val();
        let updateTypeProduct = $('#updateTypeProduct').val();
        let updateValueProduct = $('#updateValueProduct').val();
        $.ajax({
            url: './scripts/updateProduct.php',
            type: 'GET',
            data: {
                referenceProduct: reference,
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
        let selectedProduct = $('#inputDeleteProduct').val();
        let dataToSend = { selectedProduct: selectedProduct };
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

    // Tableau principal
    var table = $('#table').DataTable({ 
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
        },
        "pageLength": 25,
        // Masquer les colonnes initialement
        "columnDefs": [
            { "targets": [3, 4, 5, 6, 7, 8], "visible": false } 
        ],
        
    });

    // Cache l'erreur lors de la génération du tableau A MODIFIER
    $.fn.dataTable.ext.errMode = 'none';

    // Tableaux générés avec la sélection catégorie ou produit
    $('input[name="selectedTableDate"]').on('change', function () {
        var selectedValue = $(this).val();
    
        table.clear().draw();
        
        // Fetch and display data based on selected value (Categories or Products)
        if (selectedValue === 'Categories') {
            $.ajax({
                url: './scripts/drawCategories.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {

                    // Convert the data to array of arrays
                    var dataArray = data.map(function(item) {
                        return Object.values(item);
                    });
                    console.log(dataArray);

                    // Add data to the DataTable
                    table.clear().rows.add(dataArray).draw();

                    // Masquer les colonnes après avoir ajouté les données
                    table.columns([3, 4, 5, 6, 7, 8]).visible(false);
                },
                error: function (error) {
                    console.error('Error fetching category data:', status, error);
                }
            });
        } else if (selectedValue === 'Products') {
            $.ajax({
                url: './scripts/drawProducts.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    
                    // Convert the data to array of arrays
                    var dataArray = data.map(function(item) {
                        return Object.values(item);
                    });
                    console.log(dataArray);

                    // Add data to the DataTable
                    table.clear().rows.add(dataArray).draw();

                    // Afficher les colonnes après avoir ajouté les données
                    table.columns([3, 4, 5, 6, 7, 8]).visible(true);
                },
                error: function (error) {
                    console.error('Error fetching product data:', error);
                }
            });
        }
    });


// AFFICHAGES
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
    // Cacher les produits et réafficher les catégories sur un clique du bouton
    $('button[value="Categories"]').on('click', function () {
        displayAllCategories();
        hideAllProducts();
    });
    // Affichage des formulaires admin
    $("#caseAddProduct").hide();
    $('#caseUpdateProduct').hide();
    $('#caseDeleteProduct').hide();
    $("input[name='selectedTableDate']").change(function () {
        if ($(this).val() === "Products") {
            // Show product-related forms and hide category-related forms
            $("#caseAddProduct").show();
            $('#caseUpdateProduct').show();
            $('#caseDeleteProduct').show();
            $("#caseAddCategory").hide();
            $('#caseUpdateCategory').hide();
            $('#caseDeleteCategory').hide();
        } else if ($(this).val() === "Categories") {
            // Show category-related forms and hide product-related forms
            $("#caseAddCategory").show();
            $('#caseUpdateCategory').show();
            $('#caseDeleteCategory').show();
            $("#caseAddProduct").hide();
            $('#caseUpdateProduct').hide();
            $('#caseDeleteProduct').hide();
        }
    });


// APPARENCES BOUTONS
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
});