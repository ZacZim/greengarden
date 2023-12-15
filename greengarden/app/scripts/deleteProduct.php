<?php 

$selectedProduct = $_GET['selectedProduct'];

require_once("../dao/ProductDao.php");
$dao = new ProductDAO ();
$dao->connexion();
$results = $dao->deleteProduct($selectedProduct);

?>