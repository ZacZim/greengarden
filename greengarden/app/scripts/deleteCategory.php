<?php 

$selectedCategory = $_GET['selectedCategory'];

require_once("../dao/CategoryDao.php");
$dao = new CategoryDAO ();
$dao->connexion();
$results = $dao->deleteCategory($selectedCategory);

?>