<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 12/04/2018
 * Time: 00:26
 */

    session_start();

    require ("../DatabaseLinkInstance.php");

    $err = $db->modify_game_informations($_POST["modified_game"], $_POST["game_title"], $_POST["game_release_date"],  $_POST["game_dev"], $_POST["game_editor"], $_POST["pegi"],  $_POST["game_type"], $_POST["game_plat"],  $_POST["stock"], $_POST["description"]);

    echo $err;

    if($err == null)
        $_SESSION["modif_game_info"] = "Les informationsnt été correctement ajoutées";
    else
        $_SESSION["modif_game_err"] = $err;



    header('Location: ../MonCompte-Admin-Modif-Jeu.php');
    exit();


