<?php 
$reference = $_GET['referenceProduct'];
$updateTypeProduct = $_GET['updateTypeProduct'];
$updateValueProduct = $_GET['updateValueProduct'];

require_once("../dao/ProductDao.php");
try {
    $pdo = new PDO("mysql:host=localhost;dbname=greengarden", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}
$dao = new ProductDAO ($pdo);
$dao->connexion();
$results = $dao->updateProduct($reference, $updateTypeProduct, $updateValueProduct);

?>