<?php 
$reference = $_GET['reference'];
$modificationType = $_GET['modificationType'];
$modificationValue = $_GET['modification'];

require_once("../dao/CategoryDao.php");
$dao = new CategoryDAO ();
$dao->connexion();
$results = $dao->updateCategory($reference, $modificationType, $modificationValue);

?>