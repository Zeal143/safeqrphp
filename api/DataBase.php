<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        if (mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_connect_error());
        }
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }



    function signUp($table, $username, $password, $email)
    {
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $email = $this->prepareData($email);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $usertype = 3;
        $this->sql =
            "INSERT INTO " . $table . " (name, password, email, user_id) VALUES ('" . $username . "','" . $password . "','" . $email . "','" . $usertype . "')";
        return mysqli_query($this->connect, $this->sql);
    }

    public function updateProfile($table, $id, $username, $email)
    {
        $username = $this->prepareData($username);
        $email = $this->prepareData($email);
        $query = "UPDATE " . $table . " SET name = '" . $username . "', email = '" . $email . "' WHERE userID = '" . $id . "'";
        return mysqli_query($this->connect, $query);
    }

    public function deleteAccount($table, $id)
    {
        $query = "DELETE FROM " . $table . " WHERE userID = '" . $id . "'";
        return mysqli_query($this->connect, $query);
    }
}

?>
