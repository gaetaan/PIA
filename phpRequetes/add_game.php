<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 11/04/2018
 * Time: 15:45
 */

session_start();

require ("../DatabaseLinkInstance.php");
if($_POST["game_title"] == "" || $_POST["game_release_date"] == ""|| $_POST["game_dev"] == "" || $_POST["game_editor"] == "" || $_POST["pegi"] == "" || $_POST["game_type"] == "" || $_POST["game_plat"] == "" || $_POST["stock"] == "" || $_POST["description"] == ""){
    $_SESSION["add_game_err"] = "Tous les champs doivent être complétés.";
    header('Location: ../MonCompte-Admin.php');
    exit();
}
    /*
    echo $_POST["game_title"] . "<br>";
    echo $_POST["game_release_date"]. "<br>";
    echo $_POST["game_dev"]. "<br>";
    echo $_POST["game_editor"]. "<br>";
    echo $_POST["pegi"]. "<br>";
    echo $_POST["game_type"]. "<br>";
    echo $_POST["game_plat"]. "<br>";
    echo $_POST["stock"]. "<br>";
    echo $_POST["description"]. "<br>";
    */

    $err = $db->add_game($_POST["game_title"], $_POST["game_release_date"],  $_POST["game_dev"], $_POST["game_editor"], $_POST["pegi"],  $_POST["game_type"], $_POST["game_plat"],  $_POST["stock"], $_POST["description"]);

    echo $err;

    if($err == null)
        $_SESSION["add_game_info"] = "Les informationsnt été correctement ajoutées";
    else
        $_SESSION["add_game_err"] = $err;

    $_POST["game_title"] = "";
    $_POST["game_release_date"] = "";
    $_POST["game_dev"] = "";
    $_POST["game_editor"] = "";
    $_POST["pegi"] = "";
    $_POST["game_type"] = "";
    $_POST["game_type"] = "";
    $_POST["stock"] = "";
    $_POST["Description"] = "";

    header('Location: ../MonCompte-Admin.php');
    exit();
