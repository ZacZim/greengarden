<?php

    $selectedBook = $_GET['selectedBook'];
 
    require_once("dao.php");
$dao = new DAO();
$dao->connexion();
$results = $dao->getListeEmprunt($selectedBook);


$data=array();
  
    
foreach ($results as $row) {

    $dateEmprunt = new DateTime($row['borrowDate']);
    $dateRetour = new DateTime($row['returnDate']);

    $interval = $dateEmprunt->diff($dateRetour);
    $differenceEnJours = $interval->days;
   $data[] = array(
       "book_id" => $row['book_id'],
       "user_id" => $row['user_id'],
       "borrowDate" => $row['borrowDate'],
       "returnDate" => $row['returnDate'],
       "id_borrow" => $row['id_borrow'],
       "days_Remaining" =>$differenceEnJours
     
   );
}

header('Content-Type: application/json');
echo json_encode($data);
exit;

   