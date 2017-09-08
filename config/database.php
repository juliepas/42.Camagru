<?php
class myDb {
    private $DB_USER = "jpascal";
    private $DB_PASSWORD =  "8SVUPM0X";
    private $DB_HOST = "localhost";
    private $DB_NAME = "camagru";
    private $DB_DBH;
    private $connexion;
    private $error;
    private $statement;
        public function __construct() {
            $DB_DSN = "mysql:dbname=".$this->DB_NAME.";hostname=".$this->DB_HOST;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                );
            $this->DB_DBH = new PDO("mysql:hostname=".$this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD);
            $requete = "CREATE DATABASE IF NOT EXISTS ".$this->DB_NAME;
            $this->DB_DBH->prepare($requete)->execute();
            try { 
                $this->connexion = new PDO($DB_DSN, $this->DB_USER, $this->DB_PASSWORD, $options); 
            }
            catch (PDOException $e) {
                  $this->error = $e->getMessage();
                  echo ($this->error);
            }
        }
        public function query($query) {
            try {
                $this->statement = $this->connexion->prepare($query);
            }
            catch (PDOException $e) { 
                $this->error = $e->getMessage();
                 echo ($this->error);
            }
        }
        public function execute() {
            return $this->statement->execute();
        }
        public function fetchAll() {
            return $this->statement->fetchAll();
        }
        public function fetchOne() {
            return $this->statement->fetch();
        }
        public function bind($param, $value, $type = NULL) {
            if (is_null($type)) {
                switch(true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default: 
                        $type = PDO::PARAM_STR;
                }
            }
            $this->statement->bindValue($param, $value, $type);
        }
}
