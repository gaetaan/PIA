<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 29/03/2018
 * Time: 11:00
 */

    session_start();

    require("DatabaseLinkInstance.php");

    function verifyInput($var){
        $var = trim($var);
        $var = stripcslashes($var);
        $var = htmlentities($var);
        $var = htmlspecialchars($var);
        return $var;
    }

    $id_game = verifyInput($_GET['id']);

    $sql = "select * from games where id_game=" . $id_game . " ";

    $Requete = $db->query($sql);

    if(count($Requete) > 0){
        foreach ($Requete as $infos) {
            $title = $infos['game_title'];
            $release_date = $infos['game_release_date'];
            $dev = $infos['game_developers'];

            $editor = $infos['game_editor'];
            if( $editor == NULL) $editor = $dev;

            $pegi = $infos['age_type'];
            $type = $infos['type_game'];
            $platform = $infos['game_plat'];
            $stock = $infos['stock'];
            $description = $infos['game_description'];

        }
    }else{
        $erreur = "Pas de jeux avec cet id!";
    }

?>

<!doctype html>
<html lang="fr">
<head>
    <?php require("head.php"); ?>

    <link href="css/monCompte.css" rel="stylesheet">

    <title>Fiche jeu</title>
</head>
<body>

<?php require("header.php"); ?>

<?php
    if(isset($erreur)) echo $erreur;
    else{
?>

        <br>

        <div class="container">
            <div class="row">

                <div class="col-md-4">
                    <h2><?php echo $title;?></h2>
                    <br>
                    <?php

                    $titre = strtoupper($title);
                    $titre_dec = str_replace(" ", "_", $titre);
                    $platf = $platform;
                    $image = $titre_dec."_".$platf.".jpeg";
                    //echo "\"images/".$image."\"";
                    ?>
                    <img style="width: 300px;" class="img-responsive" src= <?php echo "\"images/".$image."\""?> alt="CouvertureJeu">

                    <h4>Plateforme: </h4>
                    <p><?php echo  $platform; ?></p>
                </div>
                <div class="col-md-8 ">
                    <br><br>

                    <div class="row">
                        <div class="col-xs-5" style="margin-left: 15px; margin-right: 10px;"><h4>Developpeurs: </h4></div>
                        <div class="col-xs-6"><p style="font-size: 22px;" ><?php echo $dev; ?></p></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-5" style="margin-left: 15px; margin-right: 10px;"><h4>Éditeur: </h4></div>
                        <div class="col-xs-6"><p style="font-size: 22px;" ><?php echo $editor; ?></p></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-5" style="margin-left: 15px; margin-right: 10px;"><h4>Pegi: </h4></div>
                        <div class="col-xs-6"><p style="font-size: 22px;" ><?php echo $pegi; ?></p></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-5" style="margin-left: 15px; margin-right: 10px;"><h4>Type de jeu: </h4></div>
                        <div class="col-xs-6"><p style="font-size: 22px;" ><?php echo $type; ?></p></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-5" style="margin-left: 15px; margin-right: 10px;"><h4>Date de sortie: </h4></div>
                        <div class="col-xs-6"><p style="font-size: 22px;" ><?php echo $release_date; ?></p></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-5" style="margin-left: 15px; margin-right: 10px;"><h4>En stock: </h4></div>
                        <div class="col-xs-6"><p style="font-size: 22px;" ><?php echo $stock; ?></p></div>
                    </div>

                    <h4>Description: </h4>
                    <p><?php echo $description; ?></p>
                </div>
            </div>
        </div>


<?php } ?>
<?php require("footer.php"); ?>

</body>
</html>
