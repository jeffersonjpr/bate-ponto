<?php

namespace App\Models;

use PDO;

class Db
{
    private $host = '172.17.0.2';
    private $user = 'root';
    private $pass = 'root';
    private $dbname = 'bate_ponto';

    public function connect()
    {
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}
