<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 22/03/2018
 * Time: 10:18
 */

require("DatabaseLinkInstance.php");

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

        $sqlRequete = "SELECT * FROM users WHERE user_mail = '".$mail."' AND user_password = '".md5($MotDePasse)."'";

        $Requete = $db->query($sqlRequete);

        if($Requete->rowCount() == 0) {
            $erreur =  "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
        } else {

            $_SESSION['mail'] = $mail;

            echo "il est admin : " . $Requete['is_admin'];

            header('Location: monCompte.php');
            exit();
        }
    }
}

if(isset($erreur)){
    echo '</p style="color:red;">'. $erreur .'</p>';
}


?>