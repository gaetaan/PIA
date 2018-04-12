<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 06/04/2018
 * Time: 23:37
 */

session_start();

require("DatabaseLinkInstance.php");
$retour = array();

$sqlRequeteJeuxPosseder = "SELECT * FROM borrowing, games WHERE id_user = '".$_SESSION["id_user"]."' AND borrowing.id_game = games.id_game";
$requeteJeuxPosseder = $db->query($sqlRequeteJeuxPosseder);

foreach ($requeteJeuxPosseder as $jeuPossede){
    foreach ($jeuPossede as $cle => $valeur) {
        array_push($retour, array("{$$cle}" => "$valeur"));
    }
}

echo json_encode($retour);

?>
