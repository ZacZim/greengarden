<?php

$selectedShortName = htmlspecialchars($_GET['shortName']);
$selectedLongName = htmlspecialchars($_GET['longName']);
$selectedPrice = htmlspecialchars($_GET['price']);
$selectedRateVAT = htmlspecialchars($_GET['rateVAT']);
$selectedSupplierRef = htmlspecialchars($_GET['supplierRef']);
$selectedSupplierID = htmlspecialchars($_GET["supplierID"]);
$selectedCategoryID = htmlspecialchars($_GET['categoryID']);
$selectedPicture = htmlspecialchars($_GET['pictureLink']);

require_once("../dao/ProductDAO.php");
$dao = new ProductDAO ();
$dao->connexion();
$results = $dao->addProduct($selectedShortName, $selectedLongName, $selectedPrice, $selectedRateVAT, $selectedSupplierRef, $selectedSupplierID, $selectedCategoryID, $selectedPicture);

?>
