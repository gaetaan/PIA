<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 29/03/2018
 * Time: 11:00
 */

    session_start();

    require("DatabaseLinkInstance.php");

    function verifyInput($var){
        $var = trim($var);
        $var = stripcslashes($var);
        $var = htmlentities($var);
        $var = htmlspecialchars($var);
        return $var;
    }

    $sql = "select * from games where id_game = ".verifyInput($_GET['id_game']);

    $stmt = $db->query($sql);

    if(count($Requete) > 0){
        foreach ($Requete as $infos) {
            $_SESSION['id_user'] = $infos['id_user'];
            $_SESSION['user_name'] = $infos['user_name'];
            $_SESSION['user_firstname'] = $infos['user_firstname'];
            $_SESSION['user_phone_number'] = $infos['user_phone_number'];
            $_SESSION['user_adress'] = $infos['user_adress'];
            $_SESSION['user_birthdate'] = $infos['user_birthdate'];
            $_SESSION['is_admin'] = $infos['is_admin'];
            $_SESSION['user_gender'] = $infos['user_gender'];
            $_SESSION['malus'] = $infos['malus'];
            $_SESSION['malus_date'] = $infos['malus_date'];
        }
    }else{
        print("<br>Pas de jeux avec cet id!<br>");
    }