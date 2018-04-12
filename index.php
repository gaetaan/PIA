<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 08/02/2018
 * Time: 11:09
 */

require("DatabaseLinkInstance.php");

?>

<!doctype html>
<html lang="fr">
    <head>
        <?php require("head.php"); ?>
        <link rel="stylesheet" href="css/index.css">

        <title>PIA</title>

    </head>

    <body>

        <?php require("header.php"); ?>

        <br>

        <div class="container">
            <div class="masthead" style="background-image: url('img/home-bg.jpg')">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-10 mx-auto">
                            <div class="site-heading">
                                <h1>Bienvenue sur FindYourGame !</h1>
                                <span class="subheading"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Container avec le titre -->

        <div class="container">
            <h2><u>Nos jeux les plus demandées : </u></h2>
            <?php
            $res = [];
            $platforms = array("ps3","ps4","xbox","xboxone","ps1","ps2","3ds" ,"ds","switch","wii","wiiu");

            foreach($platforms as $plat){
               $reqTopJeuParPlatforme = "SELECT borrowing.id_game, game_plat, game_title, count(*) as nombre  FROM borrowing JOIN games on borrowing.id_game = games.id_game
where game_plat = '".$plat."' GROUP BY id_game  ORDER BY nombre DESC";

                $resultsqlTop = $db->query($reqTopJeuParPlatforme);

                if (! empty($resultsqlTop))
                    $res[] = $resultsqlTop;

            }

           // var_dump ($res);

            ?>
            <div class="card-deck">
                <?php
                foreach ($res as $result) {
                    //var_dump($result);

                        ?>
                        <!-- PRICE ITEM -->
                        <div class="panel price panel-top" style="width: 225px;">
                            <div class="panel-heading  text-center">
                                <h3><?php echo $result[0]['game_plat']; ?></h3>
                            </div>
                            <div class="panel-body text-center" style="height: 40%;">
                                <h3><?php echo $result[0]['game_title']; ?></h3>
                            </div>
                            <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item"><i class="icon-ok text-danger"></i> <a
                                            href="<?php echo "ficheJeu.php?id=" . $result[0]['id_game']; ?>"
                                            class="btn btn-primary">Voir la fiche du jeu.</a></li>
                            </ul>
                        </div>

                        <?php

                }?>
            </div>

        </div> <!-- Container Jeux les plus demandés -->

        <br>

        <div class="container">
            <h2 id="CSM-title"><u>Comment sa marche ?</u></h2>

            <br>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 CMS-etape">
                    <h3>Étape 1: </h3>
                    <p>S'inscrire sur le site ou en magasin.</p>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-1 col-lg-1">
                        <img style="width:50px; margin-top: 50%;" src="images/fleche.png" alt="->">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 CMS-etape">
                    <h3>Étape 2:</h3>
                    <p>Prendre abonnement en magasin</p>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-1 col-lg-1">
                    <img style="width:50px; margin-top: 50%;" src="images/fleche.png" alt="->">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 CMS-etape">
                    <h3>Étape 3:</h3>
                    <p>Louer les jeux videos qui vous correspondent.</p>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-1 col-lg-1">
                    <img style="width:50px; margin-top: 50%;" src="images/fleche.png" alt="->">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 CMS-etape">
                    <h3>Étape 4:</h3>
                    <p>Rendez les jeux à la date prévu et louer en d'autre</p>
                </div>

            </div>

        </div> <!-- Container Comment sa marche -->

        <br>

        <div class="container">
                <h2><u>Nos abonnements :</u></h2>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">

                        <!-- PRICE ITEM -->
                        <div class="panel price panel-red">
                            <div class="panel-heading  text-center">
                                <h3>Noob</h3>
                            </div>
                            <div class="panel-body text-center">
                                <p class="lead" style="font-size:40px"><strong>5€ / mois</strong></p>
                            </div>
                            <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item"><i class="icon-ok text-danger"></i> Possibilitée de louer jusqu'à 2 jeux par mois.</li>
                                <li class="list-group-item"><i class="icon-ok text-danger"></i> Aucun delai d'attentre entre le depot et le retrait de jeu(x)*.</li>
                                <li class="list-group-item"><i class="icon-ok text-danger"></i> Durée max de la location est de 1 mois.</li>
                            </ul>
                        </div>
                        <!-- /PRICE ITEM -->


                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">

                        <!-- PRICE ITEM -->
                        <div class="panel price panel-blue">
                            <div class="panel-heading arrow_box text-center">
                                <h3>Normal</h3>
                            </div>
                            <div class="panel-body text-center">
                                <p class="lead" style="font-size:40px"><strong>7€ / mois</strong></p>
                            </div>
                            <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item"><i class="icon-ok text-info"></i> Possibilitée de louer jusqu'à 3 jeux par mois.</li>
                                <li class="list-group-item"><i class="icon-ok text-danger"></i> Aucun delai d'attentre entre le depot et le retrait de jeu(x)*.</li>
                                <li class="list-group-item"><i class="icon-ok text-info"></i>Durée max de la location est de 2 mois.</li>
                            </ul>
                        </div>
                        <!-- /PRICE ITEM -->


                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">

                        <!-- PRICE ITEM -->
                        <div class="panel price panel-green">
                            <div class="panel-heading arrow_box text-center">
                                <h3>Gamer</h3>
                            </div>
                            <div class="panel-body text-center">
                                <p class="lead" style="font-size:40px"><strong>10€ / mois</strong></p>
                            </div>
                            <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item"><i class="icon-ok text-success"></i> Possibilitée de louer jusqu'à 5 jeux par mois.</li>
                                <li class="list-group-item"><i class="icon-ok text-danger"></i> Aucun delai d'attentre entre le depot et le retrait de jeu(x)*.</li>
                                <li class="list-group-item"><i class="icon-ok text-success"></i> Durée max de la location est de 3 mois.</li>
                            </ul>
                        </div>
                        <!-- /PRICE ITEM -->
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                        <!-- INFO ITEM -->
                        <div class="panel price panel-infos">
                            <div class="panel-body text-center">
                                <p class="lead" style="font-size:40px"><strong>Infos :</strong></p>
                            </div>
                            <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item">
                                    <i class="icon-ok text-success"></i>
                                    Le payement de l'abonnement pour chaque client peut seulement être effectuer en magasin.
                                </li>
                                <li class="list-group-item">
                                    <i class="icon-ok text-success"></i>
                                    Pour toute question notre service client sera à votre écoute.
                                </li>
                                <li class="list-group-item">
                                    <i class="icon-ok text-success"></i>
                                    Nous sommes joignable 24/7.
                                </li>
                            </ul>
                        </div>
                        <!-- /INFO ITEM -->
                    </div>
                </div>
            <p style="color: gray;">En cas de probleme avec le rendu de jeu vous vous verrez recevoir un malus*. Voir les termes et conditions.</p>

        </div> <!-- Container d'abonnements -->

        <?php require("footer.php"); ?>
    </body>
</html>