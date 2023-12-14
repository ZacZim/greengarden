<?php

    $selectedBook = $_GET['selectedBook'];
    require_once("dao.php");
$dao = new DAO();
$dao->connexion();
$results = $dao->getDescriptionBook($selectedBook);


  
    
foreach ($results as $row) {
    $data[] = array(
        "title" => $row['title'],
        "isbn" => $row['isbn'],
        "authors" => $row['authors'],
        "pageCount" => $row['pageCount'],
        "publishedDate" => $row['publishedDate'],
        "thumbnailUrl" => $row['thumbnailUrl'],
        "shortDescription" => $row['shortDescription'],
        "longDescription" => $row['longDescription'],
        "categories" => $row['categories'],
        "IsAvailable" => $row['IsAvailable'],
        "id_book" => $row['id_book'],
        "name" => $row['name'],
        "first_name" => $row['first_name']
    );
 }

echo json_encode($data);
exit;

   