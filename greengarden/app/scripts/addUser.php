<?php

$selectedName = $_GET['name'];
$selectedFirst_name = $_GET['first_name'];


    require_once("dao.php");
$dao = new DAO();
$dao->connexion();
$results = $dao->getAddUser($selectedName,$selectedFirst_name);

?>
