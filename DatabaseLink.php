<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 21/03/2018
 * Time: 21:40
 */

class DatabaseLink
{
    private $db;
    private $dbname;
    private $host;
    private $username;
    private $password;

    public function __construct($host = NULL,$dbname = NULL, $username = NULL, $password = NULL)
    {
        if($dbname == NULL || $host == NULL || $username == NULL || $password == NULL){
            print("DatabaseLink bad arguments in constructor\n");
            return;
        }

        $this->dbname = $dbname;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;

        try{
            $this->db = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname."", $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e) {
            echo "Erreur de connexion à la base de données: " . $e->getMessage();
        }

    }

    function query( $sql = NULL ){

        try{

            $Requete = $this->db->prepare($sql);
            $Requete->execute();
            $Requete->setFetchMode(PDO::FETCH_ASSOC);
            return $Requete->fetchAll();

        }catch(PDOException $e) {
            echo "Erreur d'acces au donnes de la requete: " . $e->getMessage();

        }

        return NULL;
    }

}


