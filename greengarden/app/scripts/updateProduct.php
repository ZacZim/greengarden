<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$reference = $_GET['referenceProduct'];
$updateTypeProduct = $_GET['updateTypeProduct'];
$updateValueProduct = $_GET['updateValueProduct'];

require_once("../dao/ProductDao.php");

$reference = filter_var($reference, FILTER_SANITIZE_STRING);
$updateTypeProduct = filter_var($updateTypeProduct, FILTER_SANITIZE_STRING);
$updateValueProduct = filter_var($updateValueProduct, FILTER_SANITIZE_STRING);

$dao = new ProductDAO ();
$dao->connexion();
$results = $dao->updateProduct($reference, $updateTypeProduct, $updateValueProduct);

?>