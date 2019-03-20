<?php

namespace App\Database;

defined('APP_NAME') || exit('No direct access allowed.');

interface DatabaseInterface
{
    public function getConnection();
    public function runQuery($query);
    public function getQueryRows($query_instance);
    public function getSingleQueryRow($query_instance);
    public function getPreparedSQLStatement($query);
    public function runPreparedSQLStatement($query, $parameter_values);
}

class DB implements DatabaseInterface
{
    private static $instance = null;
    private $db = null;
    private $db_creds;

    private function __construct()
    {
        if(!file_exists(dirname(__FILE__) . '/DB_Creds.php')) {
            exit('Database credentials file is missing.');
        }
        $this->db_creds = require_once dirname(__FILE__) . '/DB_Creds.php';
        try {
            $this->db = new \PDO('mysql:host='.$this->db_creds['host'].';dbname='.$this->db_creds['dbname'], $this->db_creds['username'], $this->db_creds['password']);
        }
        catch(\PDOException $e) {
            echo 'There was an error connecting to the database.';
            if(ENVIRONMENT == 'development') {
                echo '<br />Error!: ' . $e->getMessage() . '<br/>';
            }
        }
    }

    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->db;
    }

    public function runQuery($query)
    {
        return $this->db->query($query);
    }

    public function getQueryRows($query_instance)
    {
        return $query_instance->fetchAll();
    }

    public function getSingleQueryRow($query_instance)
    {
        return $query_instance->fetch();
    }

    public function getPreparedSQLStatement($query)
    {
       return $this->db->prepare($query);
    }

    public function runPreparedSQLStatement($query, $parameter_values)
    {
        $query->execute($parameter_values);
        return $query;
    }

    private function __clone() { }
}
