<?php
// Start output buffering
ob_start();
require "DataBase.php";

$db = new DataBase();
$con = $db->dbConnect(); // Use the dbConnect method to create the connection

// Check connection
if (!$con) {
    // Log the error instead of outputting it directly
    error_log("Connection failed: " . mysqli_connect_error());
    die("An error occurred. Please try again later."); // Generic error message
}

// Assuming you're passing the userID via GET request
$Id = $_GET['Id'] ?? ''; // Using null coalescing operator to handle missing GET parameter gracefully

if (!empty($Id)) {
    // Prepare statement
    $stmt = $con->prepare("SELECT name, email FROM user WHERE userID=?");
    if ($stmt) {
        $stmt->bind_param("s", $Id); // Bind the variable to the prepared statement as a string ("s")

        // Execute the prepared statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($data);

        // Close statement and connection
        $stmt->close();
    } else {
        error_log("Prepare failed: " . $con->error);
        die("An error occurred. Please try again later."); // Generic error message
    }
} else {
    die("Invalid request. User ID is required.");
}

$con->close();

// Flush the buffer and send output to the browser
ob_end_flush();
?>