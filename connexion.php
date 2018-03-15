<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 08/02/2018
 * Time: 13:49
 */

session_start();

if(isset($_POST['connexion'])) { // si le bouton "Connexion" est appuyé
    // on vérifie que le champ "Pseudo" n'est pas vide
    // empty vérifie à la fois si le champ est vide et si le champ existe belle et bien (is set)
    if(empty($_POST['mail'])) {
        $erreur =  "Le champ mail est vide.";
    } else {
        // on vérifie maintenant si le champ "Mot de passe" n'est pas vide"
        if(empty($_POST['mdp'])) {
            $erreur =  "Le champ Mot de passe est vide.";
        } else {
            // les champs sont bien posté et pas vide, on sécurise les données entrées par le membre:
            $mail = htmlentities($_POST['mail'], ENT_QUOTES, "ISO-8859-1"); // le htmlentities() passera les guillemets en entités HTML, ce qui empêchera les injections SQL
            $MotDePasse = htmlentities($_POST['mdp'], ENT_QUOTES, "ISO-8859-1");

            //on se connecte à la base de données:
            $servername = "localhost";
            $username = "root";
            $password = "root";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=PIA", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo"Connected\n";
            }catch(PDOException $e) {
                echo "Erreur de connexion à la base de données: " . $e->getMessage();
            }

            $sqlRequete = "SELECT * FROM users WHERE user_mail = '".$mail."' AND user_password = '".md5($MotDePasse)."'";

            $Requete = $conn->prepare($sqlRequete);

            $Requete->execute();

            // set the resulting array to associative
            $resultat = $Requete->setFetchMode(PDO::FETCH_ASSOC);

            // si il y a un résultat, $Requete->rowCount() nous donnera alors 1
            // si $Requete->rowCount() retourne 0 c'est qu'il a trouvé aucun résultat
            if($Requete->rowCount() == 0) {
                $erreur =  "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
            } else {

                $_SESSION['mail'] = $mail;

                echo "il est admin : " . $Requete['is_admin'];

                header('Location: monCompte.php');
                exit();
            }

            echo md5($MotDePasse);
            echo "<br>";
            if("de01c1d48db6c321c637457113ed80d5" == "de01c1d48db6c321c63745711") echo "la meme";

        }
    }
}

$_POST['connexion'] = 0;

?>

<head>
    <script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script>
    <script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script>
    <meta charset='UTF-8'><meta name="robots" content="noindex">
    <link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
    <link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
    <link rel="canonical" href="https://codepen.io/frytyler/pen/EGdtg" />

    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'><script src='https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js'></script>
    <link href="css/connexion.css" rel="stylesheet">


    <?php require("head.php"); ?>
</head>
<body>
<?php require("header.php"); ?>

<div class="login">
    <h1>Se connecter</h1>
    <form method="post">
        <input type="email" name="mail" placeholder="Adresse mail" required="required" />
        <input type="password" name="mdp" placeholder="Mot de passe" required="required" />
        <button type="submit" name="connexion" class="btn btn-primary btn-block btn-large">Connexion</button>
    </form>
    <br>
        <?php if(isset($erreur)) echo "<p style='color:red;'>" . $erreur . "</p>"; ?>
    <br>
    <p style="color: #fff; width: 500px;">Vous n'etes pas encore client chez nous ? <br> Inscrivez-vous <a href="inscription.php" >ici</a> </p>
</div>

    </body>
</html>