<?php

class DataBaseConfig
{
    public $servername;
    public $username;
    public $password;
    public $databasename;

    public function __construct()
    {
        // AWS RDS configuration
        $this->servername = 'fyp.cxy44geoe8g0.ap-southeast-1.rds.amazonaws.com';
        $this->username = 'admin';
        $this->password = 'Civic12345!';
        $this->databasename = 'reportsystem';
    }
}

?>
