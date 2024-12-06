<?php
session_start();

require_once 'dbConnection.php'; 
require_once 'User.php'; 


if (isset($_SESSION['username'])) { 
    
    $database = new ECommerce();
    $db = $database->Connect();

    try {
        
        $db->beginTransaction();

        
        $queries = [
            "DELETE FROM men", 
            "DELETE FROM women", 
            "DELETE FROM kids", 
            "DELETE FROM homeliving" 
        ];

        
        foreach ($queries as $query) {
            $stmt = $db->prepare($query);
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute query: " . $query);
            }
        }

        
        $db->commit();

        
        session_unset(); 
        session_destroy(); 
        header("Location: Login.php"); 
        exit();
    } catch (Exception $e) {
        
        $db->rollBack();
        echo "Error: " . $e->getMessage(); 
    }
} else {
    
    header("Location: Login.php");
    exit();
}
?>