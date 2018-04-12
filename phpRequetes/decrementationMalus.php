<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 10/04/2018
 * Time: 12:41
 */

require ("../DatabaseLinkInstance.php");

$date_du_jour = date("Y-m-d");

$sqlRequete = "SELECT * FROM malus WHERE date_end_malus >=  $date_du_jour";

$resultRequete = $db->query($sqlRequete);

foreach ($resultRequete as $item){
    echo $item["id_user"] . "<br>";
}