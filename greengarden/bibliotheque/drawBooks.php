<?php 

require_once("dao.php");
    $dao = new DAO();

    //on se connecte
    $dao->connexion();

    //on récupère tous les livres et on les affiche
    $books = $dao->getBooks();
    $data = array();
    foreach ($books as $row) {
if ( $row['IsAvailable']) {
    $isAvailable="Empruntable";
}
else{
    $isAvailable="Emprunté";
}
       
        $data[] = array(
            "id_book" => $row['id_book'],
            "title" => $row['title'],
            "authors" => $row['authors'],
            "shortDescription" => $row['shortDescription'],
            "categories" => $row['categories'],
            "IsAvailable" => $isAvailable
        );
    }

    header('Content-Type: application/json');
echo json_encode($data);
exit;