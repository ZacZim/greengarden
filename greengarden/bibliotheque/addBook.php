<?php

$selectedTitle = htmlspecialchars($_GET['title']);
$selectedIsbn = htmlspecialchars($_GET['isbn']);
$selectedAuthors = htmlspecialchars($_GET['authors']);
$selectedCategories = htmlspecialchars($_GET['categories']);
$selectedPageCount = htmlspecialchars($_GET['pageCount']);
$selectedPublishedDate = date('Y-m-d H:i:s', strtotime($_GET["publishedDate"]));
$selectedShortDescription = htmlspecialchars($_GET['shortDescription']);
$selectedLongDescription = htmlspecialchars($_GET['longDescription']);
$selectedIsAvailable = htmlspecialchars($_GET['IsAvailable']);
$selectedthumbnailUrl = htmlspecialchars($_GET['thumbnailUrl']);

    require_once("dao.php");
$dao = new DAO();
$dao->connexion();
$results = $dao->getAddBook($selectedTitle,$selectedIsbn,$selectedthumbnailUrl,$selectedAuthors,$selectedCategories,$selectedPageCount,$selectedPublishedDate,$selectedShortDescription,$selectedLongDescription,$selectedIsAvailable);

?>
