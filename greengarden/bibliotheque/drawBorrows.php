<?php require_once("dao.php");
    $dao = new DAO();

    //on se connecte
    $dao->connexion();

    //on récupère tous les livres et on les affiche
    $books = $dao->getBorrows();
    $data = array();
    foreach ($books as $row) {
        $dateRetour = new DateTime($row['returnDate']);
        $today = new DateTime();
        $interval = $dateRetour->diff($today);
        $differenceEnJours = $interval->days;

        // Si la date de retour est dépassée, $differenceEnJours sera négatif
        if ($dateRetour < $today) {
            $differenceEnJours *= -1;
        }

        $data[] = array(
            "book_id" => $row['book_id'],
            "user_id" => $row['user_id'],
            "borrowDate" => $row['borrowDate'],
            "returnDate" => $row['returnDate'],
            "id_borrow" => $row['id_borrow'],
            "days_Remaining" =>$differenceEnJours,
          
        );
    }

header('Content-Type: application/json');
echo json_encode($data);
exit;