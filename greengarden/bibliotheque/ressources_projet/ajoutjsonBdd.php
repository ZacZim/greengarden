<?php
/*
		function de lecture du fichier csv
		en paramètre le nom du fichier à lire (chemin)
	*/
function readCsv($filename)
{
    $datas = array();
    //on ouvre le fichier en lecture
    if (($handle = fopen($filename, "r")) !== FALSE) {

        //on lit le fichier ligne par ligne
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {


            //on ajoute la ligne à un tableau php




        }
        fclose($handle);
    }
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque";
$conn = new mysqli($servername, $username, $password, $dbname);

$json = json_decode(file_get_contents("books.json"));

foreach ($json as $book) {
    break;
    $title = mysqli_real_escape_string($conn, $book->title);
    $isbn = mysqli_real_escape_string($conn, $book->isbn);
    $pageCount = mysqli_real_escape_string($conn, $book->pageCount);
   if ($book->publishedDate!=null)
    $publishedDate = date('Y-m-d H:i:s', strtotime($book->publishedDate->dt_txt));
    $thumbnailUrl = mysqli_real_escape_string($conn, $book->thumbnailUrl);
    $longDescription = mysqli_real_escape_string($conn, $book->longDescription);
    $authors = implode(", ", array_map(function($author) use ($conn) {
        return mysqli_real_escape_string($conn, $author);
    }, $book->authors));
    $categories = implode(", ", array_map(function($category) use ($conn) {
        return mysqli_real_escape_string($conn, $category);
    }, $book->categories));
$un=1;
    // Requête d'insertion
    $sql = "INSERT INTO t_books (title, isbn, pageCount, publishedDate, thumbnailUrl, shortDescription, longDescription, authors, categories,isAvailable) 
            VALUES ('$title', '$isbn', '$pageCount', '$publishedDate', '$thumbnailUrl', '$shortDescription', '$longDescription', '$authors', '$categories','$un')";

    if ($conn->query($sql) === TRUE) {
        echo "Enregistrement ajouté avec succès<br>";
    } else {
        echo "Erreur lors de l'ajout de l'enregistrement : " . $conn->error;
    }

 
}

// Fermer la connexion
$conn->close();
