<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 11/04/2018
 * Time: 21:46
 */

    session_start();

    require("../DatabaseLinkInstance.php");

    function verifyInput($var){
        $var = trim($var);
        $var = stripcslashes($var);
        $var = htmlentities($var);
        $var = htmlspecialchars($var);
        return $var;
    }


    $deja_inscrit = "SELECT * FROM users WHERE user_mail = '".htmlspecialchars($_POST['mail'], ENT_QUOTES, "ISO-8859-1")."'";

    $requete = $db->query($deja_inscrit);

    if(count($requete) != 0){
        $_SESSION["add_user_err"] = "Un compte avec cet adresse mail existe déjà.(".count($requete).")";
    }
    else{
        $mdp = htmlspecialchars($_POST['mdp'], ENT_QUOTES, "ISO-8859-1");

        if(empty($_POST['mdp']) || strlen($mdp) < 5) {
            if(empty($_POST['mdp']))
                $_SESSION["add_user_err"] = "Le champ Mot de passe est vide.";
            else{
                $_SESSION["add_user_err"] = "Le mot de passe doit contenir au moins 5 caractères. (" . strlen($mdp) . ")";
            }
        } else {
            if($_POST['mdp2'] != $_POST['mdp']){
                $_SESSION["add_user_err"] = "Les mots de passes sont differents.";
            }
            else{
                if((strlen($_POST["tel"]) != 10) && intval($_POST['tel']) > 0){
                    $_SESSION["add_user_err"] = "Le numero de téléphone doit contenir 10 chiffres.";
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
                    $is_admin = intval($_POST["is_admin"]);

                    // on fait maintenant la requête dans la base de données pour rechercher si ces données existe et correspondent:
                    //si vous avez enregistré le mot de passe en md5() il vous suffira de faire la vérification en mettant mdp = '".md5($MotDePasse)."' au lieu de mdp = '".$MotDePasse."'

                    $sqlRequete = "INSERT INTO users (user_name, user_firstname, user_mail, user_password, user_phone_number, user_adress, user_birthdate, is_admin, user_gender)".
                        "VALUE ('".$nom."', '".$prenom."', '".$mail."', '".$mdp."', '".$tel."', '".$adr."', '".$date."', '". $is_admin . "', '".$sexe."');";

                    $Requete = $db->query($sqlRequete);
                    echo $Requete;

                    $_SESSION["add_user_info"] = "L'ajout a bien été effectué.";
                    $_SESSION["add_user_err"] = null;

                    header("Location: ../MonCompte-Admin-Ajout-User.php");
                    exit();

                }
            }

        }

    }

    echo $_SESSION["add_user_info"];
    echo $_SESSION["add_user_err"];

    header("Location: ../MonCompte-Admin-Ajout-User.php");
    exit();
