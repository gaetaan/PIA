<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 06/04/2018
 * Time: 23:00
 */
session_start();

if(! isset($_SESSION["mail"])){
    header('Location: connexion.php');
    exit();
}

if($_SESSION["is_admin"] == 0){
    header('Location: MonCompteBis.php');
    exit();
}

require("DatabaseLinkInstance.php");


$_SESSION["add_game_info"] = null;

?>


<!doctype html>
<html lang="fr">
<head>
    <?php require("head.php"); ?>

    <link href="css/MonCompteBis.css" rel="stylesheet">

    <title>Mon Compte</title>
</head>
<body>

<?php require("header.php"); ?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <ul id="nav1" class="nav">
                <li id="profil"> <a href="MonCompteBis.php"><p> Profil </p></a></li>
                <?php if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){ ?>
                <li id="espace-admin"> <a href="MonCompte-Admin.php"><p class="p-active"> Espace Administrateur </p></a> </li>
                <?php } ?>
                <li id="liste-location"><a href="MonCompte-ListeLoc.php"><p> Liste des jeux loués </p></a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="panel">
                <div class="panel-heading">
                    <p class="panel-heading-text"> Espace Administrateur </p>
                </div>
                <div class="panel-body">
                    <div>
                        <ul id="nav-Admin" class="nav">
                            <li id="Ajout_Jeu"> <a href="MonCompte-Admin.php"><p class="p-active"> Ajouter un jeu </p></a></li>
                            <li id="Modif_Jeu"> <a href="MonCompte-Admin-Modif-Jeu.php"><p> Modifier un jeu </p></a> </li>
                            <li id="Ajout_User"><a href="MonCompte-Admin-Ajout-User.php"><p> Ajouter un utilisateur </p></a></li>
                            <li id="Modif_User"><a href="MonCompte-Admin-Modif-User.php"><p> Modifier un Utilisateur </p></a></li>
                        </ul>
                    </div>

                    <form class="form" action="phpRequetes/add_game.php" method="post" id="registrationForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="game_title"><h4><u>Titre :</u></h4></label>
                                    <input type="text" class="form-control" name="game_title" id="game_title">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="game_type"><h4><u>Type de jeu :</u></h4></label>
                                    <input type="text" class="form-control" name="game_type" id="game_type">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="game_release_date" ><h4><u>Date de sortie :</u></h4></label>
                                    <input type="date" class="form-control" name="game_release_date" id="game_release_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pegi" ><h4><u>Pegi :</u></h4></label>
                                    <input type="number" class="form-control" name="pegi" id="pegi">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="game_dev" ><h4><u>Developpeur :</u></h4></label>
                                    <input type="text" class="form-control" name="game_dev" id="game_dev">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="game_editor"><h4><u>Éditeur :</u></h4></label>
                                    <input type="text" class="form-control" name="game_editor" id="game_editor">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock" ><h4><u>Stock disponible :</u></h4></label>
                                    <input type="number" min="0" class="form-control" name="stock" id="stock">

                                    <label for="game_plat" ><h4><u>Platform :</u></h4></label>
                                    <input type="text" class="form-control" name="game_plat" id="game_plat">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description" ><h4><u>Description :</u></h4></label>
                                    <textarea rows="4" cols="40" name="description" id="description"></textarea>
                                </div>
                            </div>
                        </div>

                        <?php if(isset($_SESSION["add_game_info"])){ ?>
                            <p style="color: green"><?php if(isset($_SESSION["add_game_info"]) || $_SESSION["add_game_info"] != null){ echo $_SESSION["add_game_info"]; $_SESSION["add_game_err"] = null;}?></p>
                        <?php } ?>

                        <?php if(isset($_SESSION["add_game_err"])){ ?>
                            <p style="color: red"><?php if(isset($_SESSION["add_game_err"]) || $_SESSION["add_game_err"] != null){ echo $_SESSION["add_game_err"]; $_SESSION["add_game_info"] = null;}?></p>
                        <?php } ?>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Ajouter</button>
                                <input class="btn btn-lg" type="reset">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<br>

<?php require("footer.php"); ?>

</body>
</html>