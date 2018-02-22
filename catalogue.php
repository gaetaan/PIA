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

    $servername = "localhost";
    $username = "root";
    $password = "root";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=PIA", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // echo"Connected\n";
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    try {
        $sql = "Select * from games";

        $stmt = $conn->prepare("Select * from games");

        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        /*
        while( $rep = $stmt->fetch() ) {
            var_dump($rep);
        }
        */
    }catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    /**/
    $conn = null;

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
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <link href="css/catalogue.css" rel="stylesheet">

        <title>API</title>

    </head>

    <body>

    <?php require("header.php"); ?>

    <div class="container" style="background-color: darkgrey;">
        <h2>Notre top 3 des jeux les plus demandés</h2>

        <div id="top-3-best">

            <div class="card-deck">

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Titre du jeu.</h5>
                        <img src="" />
                        <br/><br/>
                        <a href="#" class="btn btn-primary">Voir la fiche du jeu.</a>
                    </div>
                </div>

                <br/>

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Titre du jeu.</h5>
                        <img src="" />
                        <br/><br/>
                        <a href="#" class="btn btn-primary">Voir la fiche du jeu.</a>
                    </div>
                </div>

                <br/>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Titre du jeu.</h5>
                        <img src="" />
                        <br/><br/>
                        <a href="#" class="btn btn-primary">Voir la fiche du jeu.</a>
                    </div>
                </div>

                <br/>
            </div>

        </div>

        <br/>

        <div id="catalogue">
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
                            while( $rep = $stmt->fetch()) {
                                ?>
                        <?php if(($numberOfGames % 3) == 0) echo"<div class=\"card-deck\">"; ?>
                            <!--div class="card-deck"-->
                                <?php //for($j = 0; $j < 3; $j++){ ?>
                                <?php //while( $rep = $stmt->fetch() ) {?>
                                <div class="card">
                                    <img class="card-img-top" src="" alt="Card image cap">
                                    <div class="card-block">
                                        <h4 class="card-title"><?php echo $rep['game_title']; ?></h4>
                                        <p class="card-text">
                                            <?php
                                                $desc = $rep['game_description'];
                                                $desc = tronquer($desc);
                                                echo $desc;
                                            ?>
                                        </p>
                                        <p class="card-text"><small class="text-muted"><?php echo $rep["game_release_date"]; ?></small></p>
                                        <a href="#" class="btn btn-primary">Voir la fiche du jeu.</a>
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




    <?php require("footer.php"); ?>

    </body>
</html>
