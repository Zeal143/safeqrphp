<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['Id']) && isset($_POST['username']) && isset($_POST['email'])) {
    if ($db->dbConnect()) {
        if ($db->updateProfile("user", $_POST['Id'], $_POST['username'], $_POST['email'])) {
            echo "Update Success";
        } else {
            echo "Update Failed";
        }
    } else {
        echo "Error: Database connection";
    }
} else {
    echo "All fields are required!";
}
?>
