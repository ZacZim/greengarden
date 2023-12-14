<?php 
$reference = $_GET['reference'];
$modificationType = $_GET['modificationType'];
$modificationValue = $_GET['modification'];

require_once("../dao/CategoryDao.php");
try {
    $pdo = new PDO("mysql:host=localhost;dbname=greengarden", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}
$dao = new CategoryDAO ($pdo);
$dao->connexion();
$results = $dao->updateCategory($reference, $modificationType, $modificationValue);

?>