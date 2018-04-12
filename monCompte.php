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
    <link href="css/monCompte.css" rel="stylesheet">

    <title>Mon Compte</title>
</head>
<body>

<?php require("header.php"); ?>

<hr>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-sm-10"><h1 style="color: white;"><?php echo $_SESSION['user_name'] . " " . $_SESSION['user_firstname'] ;?></h1></div>
        <!--div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive" src=""></a></div-->
    </div>
    <div class="row">
        <div class="col-sm-3"><!--left col-->

            <ul class="list-group">
                <li class="list-group-item text-muted">Profil:</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Nom :</strong></span> <?php echo $_SESSION['user_name']; ?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Email :</strong></span> <?php echo $_SESSION['mail']; ?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Numéro de téléphone :</strong></span> <?php echo $_SESSION['user_phone_number']; ?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Abonnement :</strong></span> <?php echo ""; ?></li>
            </ul>

        </div><!--/col-3-->
        <div class="col-sm-9">

            <ul class="nav nav-tabs" id="myTab">
                <?php if( $_SESSION['is_admin'] == 1 ){?>
                    <li class="active"><a href="#espace_admin" data-toggle="tab"> Espace administrateur</a></li>
                <?php } ?>
                <li <?php if($_SESSION['is_admin'] == 0){ echo' class="active"';} ?> ><a href="#listesJeux" data-toggle="tab">Liste des jeux louées</a></li>
                <li><a href="#settings"  data-toggle="tab"> Modifier les informations</a></li>
            </ul>

            <div class="tab-content">

                <?php if( $_SESSION['is_admin'] == 1 ){?>

                <div class="tab-pane active" id="espace_admin">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#form_ajout_modif_jeux" data-toggle="tab">Ajouter/Modifier un jeu</a></li>
                            <li><a href="#form_ajout_modif_user" data-toggle="tab">Ajouter/Modifier un utilisateur</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="form_ajout_modif_jeux">
                                <div class="col-sm-10">
                                    <ul class="nav nav-tabs" id="myTab">
                                        <li class="active"><a href="#form_ajout_jeux"  data-toggle="tab">Ajouter un jeu</a></li>
                                        <li><a href="#form_modif_jeux" data-toggle="tab">Modifier un jeu</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane active" id="form_ajout_jeux">
                                            <h2>Ajout d'un jeu</h2>
                                            <form class="form" action="##" method="post" id="registrationForm">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="name"><h4><u>Titre :</u></h4></label>
                                                            <input type="text" class="form-control" name="name" id="first_name" placeholder="Titre du jeu.">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="last_name" ><h4><u>Plateforme :</u></h4></label>
                                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder=<?php echo '"' . $_SESSION['user_firstname'] .'"' ?> title="prénom">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="mobile" ><h4><u>Numéro de téléphone :</u></h4></label>
                                                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder=<?php echo '"' . $_SESSION['user_phone_number'] .'"' ?> title="Inserer le numéro de téléphone">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="email" ><h4><u>Email :</u></h4></label>
                                                            <input type="email" class="form-control" name="email" id="email" placeholder=<?php echo '"' . $_SESSION['mail'] .'"' ?> title="inserer l'email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <br>
                                                        <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Ajouter</button>
                                                        <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Annuler </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!--/tab-content-->

                                        <div class="tab-pane" id="form_modif_jeux">
                                            <h2>Modification d'un jeu :</h2>
                                            <form class="form" action="##" method="post" id="registrationForm">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="name"><h4><u>Nom :</u></h4></label>
                                                            <input type="text" class="form-control" name="name" id="first_name" placeholder=<?php echo '"' . $_SESSION['user_name'] .'"' ?> title="Inserez votre nom.">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="last_name" ><h4><u>Prénom :</u></h4></label>
                                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder=<?php echo '"' . $_SESSION['user_firstname'] .'"' ?> title="prénom">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="mobile" ><h4><u>Numéro de téléphone :</u></h4></label>
                                                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder=<?php echo '"' . $_SESSION['user_phone_number'] .'"' ?> title="Inserer le numéro de téléphone">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="email" ><h4><u>Email :</u></h4></label>
                                                            <input type="email" class="form-control" name="email" id="email" placeholder=<?php echo '"' . $_SESSION['mail'] .'"' ?> title="inserer l'email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <br>
                                                        <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Valider </button>
                                                        <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Annuler </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!--/tab-pane-->
                                    </div><!--/table-content-->
                                </div><!--/col-sm-10-->
                            </div><!--/tab-pane-->

                            <div class="tab-pane" id="form_ajout_modif_user">
                                <div class="col-sm-10">
                                    <ul class="nav nav-tabs" id="myTab">
                                        <li class="active"><a href="#form_ajout_user" data-toggle="tab">Ajouter un utilisater</a></li>
                                        <li><a href="#form_modif_user" data-toggle="tab">Modifier un utilisateur</a></li>
                                    </ul>

                                    <br>

                                    <div class="tab-content">
                                        <div class="tab-pane active" id="form_ajout_jeux">
                                            <h2>Ajout d'un utilisateur</h2>

                                        </div><!--/tab-content-->

                                        <div class="tab-pane" id="form_modif_jeux">
                                            <h2>Modification d'un utilisateur</h2>
                                            <form class="form" action="##" method="post" id="registrationForm">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="name"><h4><u>Nom :</u></h4></label>
                                                            <input type="text" class="form-control" name="name" id="first_name" placeholder=<?php echo '"' . $_SESSION['user_name'] .'"' ?> title="Inserez votre nom.">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="last_name" ><h4><u>Prénom :</u></h4></label>
                                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder=<?php echo '"' . $_SESSION['user_firstname'] .'"' ?> title="prénom">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="mobile" ><h4><u>Numéro de téléphone :</u></h4></label>
                                                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder=<?php echo '"' . $_SESSION['user_phone_number'] .'"' ?> title="Inserer le numéro de téléphone">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="email" ><h4><u>Email :</u></h4></label>
                                                            <input type="email" class="form-control" name="email" id="email" placeholder=<?php echo '"' . $_SESSION['mail'] .'"' ?> title="inserer l'email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <br>
                                                        <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Valider </button>
                                                        <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Annuler </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!--/tab-pane-->
                                    </div><!--/table-content-->
                                </div><!--/col-sm-10-->
                            </div><!--/table-pane-->
                        </div><!--/tab-content-->
                    </div><!--/col-sm-12-->
                </div><!--/tab-pane espace_admin-->
                <?php } ?>

                <div <?php if($_SESSION['is_admin'] == 0){ echo' class="tab-pane active"';}else{echo' class="tab-pane"';} ?>  id="listesJeux">

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

                </div><!--/tab-pane-->

                <div class="tab-pane" id="settings">
                    <hr>
                    <form class="form" action="##" method="post" id="registrationForm">

                        <div class="row">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="name"><h4><u>Nom :</u></h4></label>
                                    <input type="text" class="form-control" name="name" id="first_name" placeholder=<?php echo '"' . $_SESSION['user_name'] .'"' ?> title="Inserez votre nom.">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6" style="margin-left:10px;">
                                    <label for="last_name" ><h4><u>Prénom :</u></h4></label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder=<?php echo '"' . $_SESSION['user_firstname'] .'"' ?> title="prénom">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="mobile" ><h4><u>Numéro de téléphone :</u></h4></label>
                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder=<?php echo '"' . $_SESSION['user_phone_number'] .'"' ?> title="Inserer le numéro de téléphone">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <label for="email" ><h4><u>Email :</u></h4></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder=<?php echo '"' . $_SESSION['mail'] .'"' ?> title="inserer l'email">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="adr" ><h4><u>Adresse:</u></h4></label>
                                    <input type="text" class="form-control" name="adr" id="adr" placeholder=<?php echo '"' . $_SESSION['user_adress'] .'"' ?> title="Inserer le numéro de téléphone">
                                </div>
                            </div>

                            <!--div class="form-group">
                                <div class="col-xs-6">
                                    <label for="email" ><h4><u>Email :</u></h4></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder=<?php echo '"' . $_SESSION['mail'] .'"' ?> title="inserer l'email">
                                </div>
                            </div-->
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <br>
                                <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Sauvegarder</button>
                                <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat" ></i> Restaurer</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div><!--/tab-pane-->

        </div><!--/tab-content-->

    </div><!--/col-9-->
</div><!--/row-->
</hr>

<?php require("footer.php"); ?>

</body>
</html>