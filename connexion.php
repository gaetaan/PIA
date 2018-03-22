<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 08/02/2018
 * Time: 13:49
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


if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty($_POST['mail'])) {
        $erreur =  "Le champ mail est vide.";
    } else {
        // on vérifie maintenant si le champ "Mot de passe" n'est pas vide"
        if(empty($_POST['mdp'])) {
            $erreur =  "Le champ Mot de passe est vide.";
        } else {
            // les champs sont bien posté et pas vide, on sécurise les données entrées par le membre:
            $mail = verifyInput($_POST['mail']);
            $MotDePasse = verifyInput($_POST['mdp']);

            $sqlRequete = "SELECT * FROM users WHERE user_mail = '".$mail."'";

            $Requete = $db->query($sqlRequete);

            if(count($Requete) == 1){

                if($Requete[0]['user_password'] == md5($MotDePasse)) {

                    $_SESSION['mail'] = $mail;

                    echo "il est admin : " . $Requete['is_admin'];

                    header('Location: monCompte.php');
                    exit();
                }else{
                    $erreur = "Le mot de passe n'est pas valide.";
                }

            } else {
                $erreur =  "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
            }
        }
    }
}

?>

<head>
    <script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script>
    <script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script>
    <script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script>
    <meta charset='UTF-8'><meta name="robots" content="noindex">
    <link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
    <link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
    <link rel="canonical" href="https://codepen.io/frytyler/pen/EGdtg" />

    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js'></script>
    <link href="css/connexion.css" rel="stylesheet">


    <?php require("head.php"); ?>
</head>
<body>
<?php require("header.php"); ?>

<div class="login">
    <h1>Se connecter</h1>

    <form id="myForm" method="post" action="" target="myFrame">
        <input type="email" id="mail" name="mail" placeholder="Adresse mail" required="required" />
        <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" required="required" />
        <button type="submit" onclick="sendForm()" name="connexion" class="btn btn-primary btn-block btn-large">Connexion</button>
    </form>

    <br>
        <?php if(isset($erreur)) echo "<p style='color:red;'>" . $erreur . "</p>"; ?>
    <br>
    <p style="color: #fff; width: 500px;">Vous n'etes pas encore client chez nous ? <br> Inscrivez-vous <a href="inscription.php" >ici</a> </p>
</div>

    </body>
</html>