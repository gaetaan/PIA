<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 10/04/2018
 * Time: 12:41
 */
$date_du_jour = date("Y-m-d");
echo $date_du_jour;

require("../DatabaseLinkInstance.php");

$sqlRequete = "SELECT * FROM malus WHERE  datediff(date_end_malus ,'".$date_du_jour."') >= 0 and (malus > 0)";// problème possible

 $Requete_ligne_malus = $db->query($sqlRequete);

 echo "<br>";

 foreach ($Requete_ligne_malus as $infos) {
     $_id_user = $infos['id_user'];
     $_id_malus = $infos['id_malus'];
     $_malus =  $infos['malus'];
     $_date_decrementation = $infos['date_decrementation'];

     $sqlRequete = "SELECT  game_counter FROM subscribers as ers JOIN subscription as ion on ers.subscription_name = ion.subscription_name where date_end_sub is NULL and id_user = '".$_id_user."'";

     $Requete_game_counter = $db->query($sqlRequete);
     echo "<br> game counter = ";
     var_dump($Requete_game_counter);

     foreach ($Requete_game_counter  as $subscription) {
         $game_counter = $subscription['game_counter'];
         echo "<br>" .$game_counter ;

         echo "<br><br><br> ";

         if( $_malus - $game_counter < 0) $game_counter = $_malus;
         $sqlRequete = "UPDATE malus SET malus = malus - ".$game_counter." WHERE id_malus = ".$_id_malus ;// possible problème

         $requete_update = $db->query($sqlRequete);
         echo "<br> update malus <br>";

         $sqlRequete = "UPDATE malus SET date_decrementation = '".$date_du_jour."' WHERE id_malus = ".$_id_malus ;// possible problème

         $requete_update = $db->query($sqlRequete);
     }
 }
