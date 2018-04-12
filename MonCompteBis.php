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

    require("DatabaseLinkInstance.php");

    $sqlRequete = "SELECT * FROM users WHERE user_mail = '".$_SESSION["mail"]."'";

    $Requete = $db->query($sqlRequete);

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
    }

    $sqlRequeteAbonnement = "SELECT subscription_name FROM subscribers  WHERE date_end_sub is not NULL && id_user = " . $_SESSION['id_user'];
    $RequeteAbonnement = $db->query($sqlRequeteAbonnement);

    //var_dump($RequeteAbonnement);

    $_SESSION["modif_info_usr"] = null;
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
                    <li id="profil"> <a href="MonCompteBis.php"><p class="p-active"> Profil </p></a></li>
                    <?php if(isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){ ?>
                    <li id="espace-admin"> <a href="MonCompte-Admin.php"><p> Espace Administrateur </p></a> </li>
                    <?php } ?>
                    <li id="liste-location"><a href="MonCompte-ListeLoc.php"><p> Liste des jeux loués </p></a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <div class="panel">
                    <div class="panel-heading">
                        <p class="panel-heading-text"> Profil </p>
                    </div>
                    <div class="panel-body">
                        <form class="form" action="phpRequetes/modify_user.php" method="post" id="registrationForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name"><h4><u>Nom :</u></h4></label>
                                        <input type="text" class="form-control" name="name" id="first_name" placeholder=<?php echo '"' . $_SESSION['user_name'] .'"' ?> title="Inserez votre nom.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name" ><h4><u>Prénom :</u></h4></label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder=<?php echo '"' . $_SESSION['user_firstname'] .'"' ?> title="prénom">
                                        </div>
                                    </div>
                                </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile" ><h4><u>Numéro de téléphone :</u></h4></label>
                                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder=<?php echo '"' . $_SESSION['user_phone_number'] .'"' ?> title="Inserer le numéro de téléphone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" ><h4><u>Email :</u></h4></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder=<?php echo '"' . $_SESSION['mail'] .'"' ?> title="inserer l'email">
                                        </div>
                                    </div>
                                </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="adr" ><h4><u>Adresse:</u></h4></label>
                                        <input type="text" class="form-control" name="adr" id="adr" placeholder=<?php echo '"' . $_SESSION['user_adress'] .'"' ?> title="Inserer le numéro de téléphone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><h4><u>Abonnement:</u></h4></label>
                                        <br>
                                        <label>
                                            <h4>
                                                <?php
                                                    if(count($RequeteAbonnement) > 0){ echo $RequeteAbonnement[0]["subscription_name"];}
                                                    else echo "Vous n'avez pas encore d'abonnement.";
                                                ?>
                                            </h4>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <p style="color: green"><?php if(isset($_SESSION["modif_info_usr"]) || $_SESSION["modif_info_usr"] != null) echo $_SESSION["modif_info_usr"]; ?></p>

                            <div class="col-md-12">
                                <div class="form-group">

                                    <br>
                                    <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Modifier</button>
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