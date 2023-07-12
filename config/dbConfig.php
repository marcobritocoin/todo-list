<?php
// session_start();
class dbConnect
{
    private $server = 'localhost';
    private $username = 'root';
    private $password = 'Hack123?123';
    private $dbName = 'todo_list';
    public $db_conn;

    public function __construct()
    {

        // $this->db_conn = mysqli_connect($this->server, $this->user, $this->password, $this->dbName);
        // if (!$this->db_conn){
        //     die(mysqli_connect_error($this->db_conn));
        // }

        $this->db_conn = new PDO("mysql:host=$this->server;dbname=$this->dbName", $this->username, $this->password);
        $set_names = $this->db_conn -> prepare("SET NAMES 'utf8'");
        $set_names -> execute();
        if (!$this->db_conn){
            die($this->db_conn);
        }

    }

    public function execute_query($query, $parameters = []){
        $statement = $this->db_conn -> prepare($query);
        $statement -> execute($parameters);
        return $statement;
    }

    public function closeConnection(){
        $this->db_conn = null;
    }  

}