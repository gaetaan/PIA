<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 11/04/2018
 * Time: 15:59
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
                            <li id="Ajout_Jeu"> <a href="MonCompte-Admin.php"><p> Ajouter un jeu </p></a></li>
                            <li id="Modif_Jeu"> <a href="MonCompte-Admin-Modif-Jeu.php"><p> Modifier un jeu </p></a> </li>
                            <li id="Ajout_User"><a href="MonCompte-Admin-Ajout-User.php"><p class="p-active"> Ajouter un utilisateur </p></a></li>
                            <li id="Modif_User"><a href="MonCompte-Admin-Modif-User.php"><p> Modifier un Utilisateur </p></a></li>
                        </ul>
                    </div>

                    <form class="form" action="phpRequetes/inscription.php" method="post" id="registrationForm">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nom"><h4><u>Nom :</u></h4></label>
                                    <input type="text" class="form-control" name="nom">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prenom"><h4><u>Prénom :</u></h4></label>
                                    <input type="text" class="form-control" name="prenom">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date" ><h4><u>Date de Naissance :</u></h4></label>
                                    <input type="date" class="form-control" name="date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail" ><h4><u>Email :</u></h4></label>
                                    <input type="email" class="form-control" name="mail">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mdp" ><h4><u>Mot de passe :</u></h4></label>
                                    <input type="password" class="form-control" name="mdp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mdp2"><h4><u>Confirmation de mot de passe :</u></h4></label>
                                    <input type="password" class="form-control" name="mdp2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tel" ><h4><u>Numéro de téléphone :</u></h4></label>
                                    <input type="number" min="0" class="form-control" name="tel">

                                    <br>

                                    <label for="sexe" ><h4><u>Sexe :</u></h4></label>
                                    <select name="sexe" class="form-control">
                                        <option value="H">Homme</option>
                                        <option value="F">Femme</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adresse" ><h4><u>Adresse :</u></h4></label>
                                    <input type="adresse" class="form-control" name="adresse">
                                </div>
                                <div class="form-group">
                                    <label for="is_admin" ><h4><u> Administrateur :</u></h4></label>
                                    <select name="is_admin" class="form-control">
                                        <option value="1">Oui</option>
                                        <option value="0">Non</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <?php if(isset($_SESSION["add_game_info"])){ ?>
                            <p style="color: green"><?php if(isset($_SESSION["add_user_info"]) || $_SESSION["add_user_info"] != null){ echo $_SESSION["add_user_info"]; $_SESSION["add_game_err"] = null;}?></p>
                        <?php } ?>

                        <?php if(isset($_SESSION["add_game_err"])){ ?>
                            <p style="color: red"><?php if(isset($_SESSION["add_user_err"]) || $_SESSION["add_user_err"] != null){ echo $_SESSION["add_user_err"]; $_SESSION["add_game_info"] = null;}?></p>
                        <?php } ?>

                        <div class="col-md-12">
                            <div class="form-group">

                                <br>
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