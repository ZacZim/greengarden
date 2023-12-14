<?php 


$selectedBook = $_GET['selectedBook'];
    require_once("dao.php");
$dao = new DAO();
$dao->connexion();
$results = $dao->getDeleteBook($selectedBook);



?>