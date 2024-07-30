<?php
require "DataBaseConfig.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Log POST data
    file_put_contents('php://stderr', print_r($_POST, true));

    // Check if id is set in POST request
    if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['url'])) {
        $userId = $_POST['id'];
        $title = $_POST['title'];
        $url = $_POST['url'];

        // Database connection
        $dbConfig = new DataBaseConfig();
        $conn = new mysqli($dbConfig->servername, $dbConfig->username, $dbConfig->password, $dbConfig->databasename);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO bookmarks (id, title, url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $userId, $title, $url);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Data Inserted Successfully";
        } else {
            echo "Data Insertion Failed: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Debugging: Log missing POST parameters
        echo "Missing POST parameters: ";
        if (!isset($_POST['id'])) {
            echo "id ";
        }
        if (!isset($_POST['title'])) {
            echo "title ";
        }
        if (!isset($_POST['url'])) {
            echo "url ";
        }
    }
}
?>
