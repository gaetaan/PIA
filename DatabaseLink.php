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

    public function __construct($host = NULL, $dbname = NULL, $username = NULL, $password = NULL)
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
            return;
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

    function modify_user_informations($id_user ,$name = NULL, $firstname = NULL, $mail = NULL, $adress = NULL, $number = NULL, $admin = 0){

        if( $number != NULL || $adress != NULL || $mail != NULL || $firstname != NULL || $name != NULL || $admin == 0 || $admin == 1) {

            $query = "UPDATE users SET ";

            if ($name != NULL) {
                $query .= "user_name = '" . $name . "' ";
            }

            if ($firstname != NULL) {
                if ($name != NULL) $query .= ', ';
                $query .= "user_firstname = '" . $firstname . "' ";
            }

            if ($mail != NULL) {
                if ($firstname != NULL || $name != NULL) $query .= ', ';
                $query .= "user_mail = '" . $mail . "' ";
            }

            if ($adress != NULL) {
                if ($mail != NULL || $firstname != NULL || $name != NULL) $query .= ', ';
                $query .= "user_adress = '" . $adress . "' ";
            }

            if ($number != NULL) {
                if ($adress != NULL || $mail != NULL || $firstname != NULL || $name != NULL) $query .= ', ';
                $query .= "user_phone_number = '" . $number . "' ";
            }

            if ($admin == 0 || $admin == 1) {
                if ($number != NULL || $adress != NULL || $mail != NULL || $firstname != NULL || $name != NULL) $query .= ', ';
                $query .= "is_admin = '" . $admin . "' ";
            }

            $query .= "WHERE id_user = " . $id_user;

            $this->query($query);

            //echo "<br>" . $query . "<br>";

            return "Les informations ont été correctement modifiés";
        }

        return " ";

    }

    function modify_game_informations($modified_game = null, $game_title = null, $game_release_date = null, $game_dev = null, $game_editor = null, $pegi = null,  $game_type = null, $game_plat = null,  $stock = null, $description = null){

        if( $modified_game != null || $game_title != null || $game_release_date != null || $game_dev != null || $game_editor != null || $pegi != null || $game_type != null || $game_plat != null|| $stock != null || $description != null) {

            $query = "UPDATE games SET ";

            if ($game_title != NULL) {
                $query .= "game_title = '" . $game_title . "' ";
            }

            if ($game_release_date != NULL) {
                if ($game_title != NULL) $query .= ', ';
                $query .= "game_release_date = '" . $game_release_date . "' ";
            }

            if ($game_dev != NULL) {
                if ($game_release_date != NULL || $game_title != NULL) $query .= ', ';
                $query .= "game_developers = '" . $game_dev . "' ";
            }

            if ($game_editor != NULL) {
                if ($game_dev != NULL || $game_release_date != NULL || $game_title != NULL) $query .= ', ';
                $query .= "game_editor = '" . $game_editor . "' ";
            }

            if ($pegi != NULL) {
                if ($game_editor != NULL || $game_dev != NULL || $game_release_date != NULL || $game_title != NULL) $query .= ', ';
                $query .= "age_type = '" . $pegi . "' ";
            }

            if ($game_type != null) {
                if ($pegi != NULL || $game_editor != NULL || $game_dev != NULL || $game_release_date != NULL || $game_title != NULL) $query .= ', ';
                $query .= "type_game = '" . $game_type . "' ";
            }

            if ( $game_plat != null ) {
                if ($game_type != null || $pegi != NULL || $game_editor != NULL || $game_dev != NULL || $game_release_date != NULL || $game_title != NULL) $query .= ', ';
                $query .= "game_plat = '" . $game_plat . "' ";
            }

            if ($stock != null) {
                if ($game_plat != null || $pegi != NULL || $game_editor != NULL || $game_dev != NULL || $game_release_date != NULL || $game_title != NULL) $query .= ', ';
                $query .= "stock = '" . $stock . "' ";
            }

            if ($description != null) {
                if ($stock != null || $game_plat != null || $pegi != NULL || $game_editor != NULL || $game_dev != NULL || $game_release_date != NULL || $game_title != NULL) $query .= ', ';
                $query .= "game_description = '" . $description . "' ";
            }

            $query .= "WHERE id_game = " . $modified_game;

            $this->query($query);

            //echo "<br>" . $query . "<br>";

            return "Les informations ont été correctement modifiés";
        }

        return " ";

    }

    function add_game($title = null, $release_date = null, $dev = null, $editor = null, $pegi = null, $type = null, $plat = null, $stock = null, $description = null ){
        if($title == null|| $release_date == null|| $dev == null|| $editor == null|| $pegi == null|| $type == null|| $stock == null|| $description == null){
           return "Un problème est survenu , des informations sont manquantes.";
        }

        $query = "INSERT INTO games(game_title, game_release_date, game_developers, game_editor, age_type, type_game, game_plat, stock, game_description) VALUE ('" . $title . "', '" . $release_date . "', '" . $dev . "', '" . $editor . "', '" . $pegi . "', '" . $type . "', '" . $plat. "', '" . $stock . "', '" . $description . "')";

        $this->query($query);

        return null;
    }

}

?>

