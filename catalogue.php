<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 08/02/2018
 * Time: 14:56
 **/

    /**
    * tronquer_texte
    * Coupe une chaine sans couper les mots
    */

    session_start();

    require("DatabaseLinkInstance.php");

    $sqlTop3 = "SELECT * FROM borrowing B , games G WHERE B.id_game = G.id_game GROUP BY B.id_game ORDER BY B.id_game DESC";

    $resultsqlTop3 = $db->query($sqlTop3);

    $sql = "Select * from games";

    $stmt = $db->query($sql);

    function tronquer($description)
    {
        //nombre de caractères à afficher
        $max_caracteres=130;
        // Test si la longueur du texte dépasse la limite
        if (strlen($description)>$max_caracteres)
        {
            // Séléction du maximum de caractères
            $description = substr($description, 0, $max_caracteres);
            // Récupération de la position du dernier espace (afin déviter de tronquer un mot)
            $position_espace = strrpos($description, " ");
            $description = substr($description, 0, $position_espace);
            // Ajout des "..."
            $description = $description."...";
        }
        return $description;
    }
?>

<!doctype html>
<html lang="fr">
    <head>
       <?php require("head.php"); ?>
        <link href="css/catalogue.css" rel="stylesheet">

        <title>Catalogue</title>

    </head>

    <body>

    <?php require("header.php"); ?>

    <div class="container" style="background-color: darkgrey;">
        <h2>Notre top 3 des jeux les plus demandés : </h2>

        <div id="top-3-best">

            <div class="card-deck">
                <?php
                    $nbJeux = 0;
                    foreach ($resultsqlTop3 as $result) {
                        if($nbJeux < 3) {
                            ?>
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $result['game_title']; ?></h5>
                                    <img src=""/>
                                    <br/><br/>
                                    <a href="<?php echo "ficheJeu.php?id=".$result['id_game']; ?>"  class="btn btn-primary">Voir la fiche du jeu.</a>
                                </div>
                            </div>
                            <br>
                            <?php
                            $nbJeux++;
                        }
                    }?>
            </div>

        </div>

        <br>

        <div id="catalogue" class="container">
            <nav id="nav-header" class="col-md-12">
                <ul>
                    <li><a href="#">Ps4</a></li>
                    <li><a href="#">Xbox One</a></li>
                    <li><a href="#">Switch</a></li>
                    <li><a href="#">Ps3</a></li>
                    <li><a href="#">Ps2</a></li>

                </ul>
                <ul id="nav-header-search-bar">
                    <form>
                        <input type="text" id="recherche-bar" placeholder="Rechercher">
                        <button type="button" class="btn btn-primary">Rechercher</button>
                    </form>
                </ul>

            </nav>


                <div class="row">
                    <div class="col-md-2">
                        <nav class="nav-search-games">
                            <ul>
                                <li> <h5>Affiner :</h5> </li>
                                <li>  </li>
                                <li> <a href="#">Switch</a> </li>
                                <li> <a href="#">Ps3</a> </li>
                                <li> <a href="#">Ps2</a> </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="col-md-10">
                        <?php
                            $numberOfGames = 0;
                            foreach( $stmt as $rep ) {
                                ?>
                        <?php if(($numberOfGames % 3) == 0) echo"<div class=\"card-deck\">"; ?>
                            <!--div class="card-deck"-->
                                <div class="card" style="width: 300px;">
                                    <div class="card-block">
                                        <div id="title">
                                            <h4 class="card-title"><?php echo $rep['game_title']; ?></h4>
                                        </div>
                                        <div id="desc">
                                            <p class="card-text">
                                                <?php
                                                $desc = $rep['game_description'];
                                                $desc = tronquer($desc);
                                                echo $desc;
                                                ?>
                                            </p>
                                        </div>
                                        <div id="plat">
                                            <p class="card-text"><small class="text-muted"><?php echo $rep["game_plat"] . "      " . $rep["game_release_date"];  ?></small></p>
                                        </div>
                                        <div id="bouton">
                                            <a href=<?php echo "ficheJeu.php?id=".$rep['id_game']; ?> class="btn btn-primary">Voir la fiche du jeu.</a>
                                        </div>
                                    </div>
                                </div>
                                <?php //} ?>
                            <?php
                                $numberOfGames++ ;
                                if(($numberOfGames % 3) == 0) echo"</div>";
                                ?>
                            <br>

                        <?php } ?>

                        <?php

                            if(($numberOfGames % 3) == 1 ){
                                echo "<div class=\"card empty\"></div>";
                                $numberOfGames++;
                            }
                            if(($numberOfGames % 3) == 2){
                                echo "<div class=\"card empty\"></div>";
                                $numberOfGames++;
                            }

                            echo"</div>";
                        ?>

                    </div>
                </div>



        </div>

    </div>


    <br>


    <?php require("footer.php"); ?>

    </body>
</html>
