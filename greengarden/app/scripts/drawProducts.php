<?php
require_once("../dao/ProductDao.php");

$daoP = new ProductDAO();
$daoP->connexion();

try {
    // Fetch products from the database
    $products = $daoP->getAllProducts();

    // Return products as JSON
    echo json_encode($products);

} catch (Exception $e) {
    error_log("Error fetching product data: " . $e->getMessage());
    echo json_encode(['error' => 'Error fetching product data']);
}
?>