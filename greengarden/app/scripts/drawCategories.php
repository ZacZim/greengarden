<?php
require_once("../dao/CategoryDao.php");

try {
    // Create an instance of the CategoryDAO
    $dao = new CategoryDAO();
    $dao->connexion();

    // Fetch categories from the database
    $categories = $dao->getAllCategories();

    // Return categories as JSON
    echo json_encode($categories);

} catch (PDOException $e) {
    // Log the database connection error
    error_log("Database connection error: " . $e->getMessage());

    // Return an error response as JSON
    echo json_encode(['error' => 'Database connection error']);
} catch (Exception $e) {
    // Log any other exceptions
    error_log("Error in drawCategories.php: " . $e->getMessage());

    // Return an error response as JSON
    echo json_encode(['error' => 'Error in drawCategories.php']);
}
?>