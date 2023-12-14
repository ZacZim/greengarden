<?php 

$id_borrow = $_GET['id_borrow'];

require_once("dao.php");
$dao = new DAO();
$dao->connexion();
$results = $dao->returnBook($id_borrow);

?>