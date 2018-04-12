<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 11/04/2018
 * Time: 11:39
 */

session_start();

require ("../DatabaseLinkInstance.php");

if(! isset($_POST["modified_user"]))
    $id_user = $_SESSION["id_user"];
else
    $id_user = $_POST["modified_user"];

if(isset($_POST["is_admin"]))
    $admin = $_POST["is_admin"];
else
    $admin = 0;

$err = $db->modify_user_informations($id_user, $_POST["name"], $_POST["last_name"],  $_POST["email"], $_POST["adr"], $_POST["mobile"], intval($admin));

$_SESSION["modif_info_usr"] = $err;

if(isset($_POST["is_admin"])){
    header('Location: ../MonCompte-Admin-Modif-User.php');
    exit();
}
else {
    header('Location: ../MonCompteBis.php');
    exit();
}
