<?php 

$id_book = $_GET['id_book'];
$id_user = $_GET['id_user'];

require_once("dao.php");
$dao = new DAO();
$dao->connexion();
$results = $dao->borrowBook($id_book, $id_user);

?>