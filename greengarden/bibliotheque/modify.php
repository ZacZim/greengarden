<?php 
// Récupération des données POST envoyées depuis un formulaire
$reference = $_POST['reference'];
$modificationType = $_POST['modificationType'];
$modificationValue = $_POST['modification'];

// Inclusion du fichier dao.php contenant les fonctionnalités d'accès aux données (DAO)
require_once("dao.php");

// Instanciation d'un objet DAO
$dao = new DAO();

// Connexion à la base de données
$dao->connexion();

// Appel de la méthode 'getModifyBook' de l'objet DAO avec les données de référence, type de modification et valeur de modification
$results = $dao->getModifyBook($reference, $modificationType, $modificationValue);

// Déconnexion de la base de données
$dao->disconnect();
