<?php

$categoryName = htmlspecialchars($_GET['Libelle']);

require_once("../dao/CategoryDao.php");
$dao = new CategoryDAO ();
$dao->connexion();
$results = $dao->addCategory($categoryName);

?>
