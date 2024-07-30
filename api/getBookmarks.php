<?php
require "DataBaseConfig.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['Id'])) {
        $userId = $_GET['Id'];

        // Database connection
        $dbConfig = new DataBaseConfig();
        $conn = new mysqli($dbConfig->servername, $dbConfig->username, $dbConfig->password, $dbConfig->databasename);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute query
        $stmt = $conn->prepare("SELECT title, url FROM bookmarks WHERE id = ?");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $bookmarkData = array();
        while ($row = $result->fetch_assoc()) {
            $bookmarkData[] = $row;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Return bookmark data as JSON
        echo json_encode($bookmarkData);
    } else {
        echo json_encode(array("error" => "Missing user ID"));
    }
}
?>