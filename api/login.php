<?php
require "DataBase.php";
$db = new DataBase();
$con = $db->dbConnect(); // Use the dbConnect method to create the connection

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Read raw POST data
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['email']) && isset($input['password'])) {
    $email = $input['email'];
    $password = $input['password'];

    // Prepare statement
    $stmt = $con->prepare("SELECT userID, password FROM user WHERE email=?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $dbpassword = $row['password'];

            if (password_verify($password, $dbpassword)) {
                // Login successful, return user ID
                echo json_encode(array("status" => "Login Success", "userId" => $row['userID']));
            } else {
                echo json_encode(array("status" => "Invalid Password"));
            }
        } else {
            echo json_encode(array("status" => "Invalid Email"));
        }

        $stmt->close();
    } else {
        echo json_encode(array("status" => "Database error"));
    }
} else {
    echo json_encode(array("status" => "Missing Email or password"));
}

$con->close();
?>
