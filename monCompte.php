<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 08/03/2018
 * Time: 10:24
 */
session_start();

if(! isset($_SESSION["mail"])){
    header('Location: connexion.php');
    exit();
}

?>

<!doctype html>
<html lang="fr">
<head>

    <?php require("head.php"); ?>

    <link href="css/connexion.css" rel="stylesheet">

    <title>Mon Compte</title>
</head>
<body>

<?php require("header.php"); ?>


<div class="container">



</div>

<?php require("footer.php"); ?>

</body>
</html>