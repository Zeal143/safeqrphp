<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['Id'])) {
    if ($db->dbConnect()) {
        if ($db->deleteAccount("user", $_POST['Id'])) {
            echo "Delete Success";
        } else {
            echo "Delete Failed";
        }
    } else {
        echo "Error: Database connection";
    }
} else {
    echo "User ID is required!";
}
?>
