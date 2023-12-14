<?php 

require_once("dao.php");
    $dao = new DAO();

    //on se connecte
    $dao->connexion();

    //on récupère tous les livres et on les affiche
    $users = $dao->getUsers();
    $data = array();
    foreach ($users as $row) {
        $data[] = array(
            "id_user" => $row['id_user'],
            "name" => $row['name'],
            "first_name" => $row['first_name']
            
        );
    }

    header('Content-Type: application/json');
echo json_encode($data);
exit;