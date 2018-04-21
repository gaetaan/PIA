<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 08/03/2018
 * Time: 11:18
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

if(isset($_POST['inscription'])) {

    if(empty($_POST['mail'])) {
        $erreur = "Le champ mail est vide.";
    } else {

        $deja_inscrit = "SELECT * FROM users WHERE user_mail = '".htmlspecialchars($_POST['mail'], ENT_QUOTES, "ISO-8859-1")."'";

        $requete = $db->query($deja_inscrit);

        if(count($requete) != 0){
            $erreur = "Un compte avec cet adresse mail existe déjà.(".count($requete).")";
        }
        else{

            $mdp = htmlspecialchars($_POST['mdp'], ENT_QUOTES, "ISO-8859-1");

            if(empty($_POST['mdp']) || strlen($mdp) < 5) {
                if(empty($_POST['mdp']))
                    $erreur = "Le champ Mot de passe est vide.";
                else{
                    $erreur = "Le mot de passe doit contenir au moins 5 caractères. (" . strlen($mdp) . ")";
                }
            } else {
                if($_POST['mdp2'] != $_POST['mdp']){
                    $erreur = "Les mots de passes sont differents.";
                }
                else{

                    if((strlen($_POST["tel"]) != 10) && intval($_POST['tel']) > 0){
                        $erreur = "Le numero de téléphone doit contenir 10 chiffres.";
                    }
                    else{
                        // les champs sont bien posté et pas vide, on sécurise les données entrées par le membre:
                        $nom = verifyInput($_POST['nom']);
                        $prenom = verifyInput($_POST['prenom']);
                        $mail = verifyInput($_POST['mail']);
                        $mdp = md5(verifyInput($_POST['mdp']));
                        $tel = intval($_POST['tel']);
                        $sexe = $_POST['sexe'];
                        $adr = verifyInput($_POST['adresse']);
                        $date = date($_POST['date']);

                        // on fait maintenant la requête dans la base de données pour rechercher si ces données existe et correspondent:
                        //si vous avez enregistré le mot de passe en md5() il vous suffira de faire la vérification en mettant mdp = '".md5($MotDePasse)."' au lieu de mdp = '".$MotDePasse."'

                            $sqlRequete = "INSERT INTO users (user_name, user_firstname, user_mail, user_password, user_phone_number, user_adress, user_birthdate, is_admin, user_gender)".
                                           "VALUE ('".$nom."', '".$prenom."', '".$mail."', '".$mdp."', '".$tel."', '".$adr."', '".$date."', 0, '".$sexe."');";

                            $Requete = $db->query($sqlRequete);

                            $_SESSION['mail'] = $mail;
                            $_SESSION['is_admin'] = 0;

                            header('Location: MonCompteBis.php');
                            exit();

                    }
                }

            }
        }

        $_POST['mail'] = "";

    }

}


?>

<head>
    <?php require("head.php"); ?>
    <script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script>
    <script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script>
    <meta charset='UTF-8'><meta name="robots" content="noindex">
    <link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
    <link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
    <link rel="canonical" href="https://codepen.io/frytyler/pen/EGdtg" />

    <!--link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'><script src='https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js'></script-->
    <link href="css/connexion.css" rel="stylesheet">


</head>
<body>
<?php require("header.php"); ?>

<?php if(isset($erreur)) if($erreur != null)echo '<br><p style="color: red; text-align: center;">'. $erreur .'</p>' ?>

<div class="login">
    <h1>Inscription</h1>
    <form method="post">

        <input type="text" name="nom" placeholder="Nom" required="required" />
        <input type="text" name="prenom" placeholder="Prénom" required="required" />
        <select name="sexe">
            <option value="M">Homme</option>
            <option value="F">Femme</option>
        </select>
        <input type="email" name="mail" placeholder="Adresse mail" required="required" />
        <input type="password" name="mdp" placeholder="Mot de passe" required="required" />
        <input type="password" name="mdp2" placeholder="Vérifiez le Mot de passe" required="required" />
        <input type="number" name="tel" placeholder="Numero de téléphone" required="required" />
        <input type="text" name="adresse" placeholder="Adresse postal" required="required" />
        <input type="date" name="date" placeholder="Date d'anniversaire" required="required" />


        <button type="submit" name="inscription" class="btn btn-primary btn-block btn-large">S'inscrire</button>
    </form>
    <br>

</div>

</body>
