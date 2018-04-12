<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 11/04/2018
 * Time: 10:30
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

$sqlRequeteJeuxPosseder = "SELECT * FROM borrowing, games WHERE id_user = '".$_SESSION["id_user"]."' AND borrowing.id_game = games.id_game";
$requeteJeuxPosseder = $db->query($sqlRequeteJeuxPosseder);

$sqlRequeteAbonnement = "SELECT * FROM subscribers Subs, subscription Subn, borrowing B  WHERE Subs.id_user = B.id_user AND Subs.subscription_name = Subn.subscription_name";
$RequeteAbonnement = $db->query($sqlRequeteAbonnement);


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
                <li id="espace-admin"> <a href="MonCompte-Admin.php"><p> Espace Administrateur </p></a> </li>
                <?php } ?>
                <li id="liste-location"><a href="MonCompte-ListeLoc.php"><p class="p-active"> Liste des jeux loués </p></a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="panel">
                <div class="panel-heading">
                    <p class="panel-heading-text"> Liste des jeux loués </p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php
                        if(count($requeteJeuxPosseder) != 0) {
                        ?>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Nom du jeu</th>
                                <th>Plateforme</th>
                                <th>Date pour rendre le jeu</th>
                                <th>Etat</th>
                            </tr>
                            </thead>
                            <tbody id="items">
                            <?php
                            foreach ($requeteJeuxPosseder as $jeuxPosseder) {
                                ?>
                                <tr>
                                    <td> <?php echo $jeuxPosseder['borrow_date']; ?> </td>

                                    <td> <?php echo $jeuxPosseder['game_title']; ?> </td>

                                    <td> <?php echo $jeuxPosseder['game_plat']; ?> </td>

                                    <td> <?php echo $jeuxPosseder['return_date']; ?> </td>

                                    <td>
                                        <?php
                                        if ($jeuxPosseder['real_return_date'] == null) {
                                            echo "<p style='color: red'> Jeux à rendre</p>";
                                        } else {
                                            echo "<p style='color: green'> Jeux rendu</p>";
                                        }
                                        ?>
                                    </td>

                                </tr>
                                <?php
                            }
                            }else{
                                echo "<p style='margin-top: 20px; font-size: 20px;'> Vous n'avez pas encore emprunter de jeu. </p>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

<?php require("footer.php"); ?>

</body>
</html>