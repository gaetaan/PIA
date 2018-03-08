<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 08/03/2018
 * Time: 11:18
 */

session_start();
session_destroy();
header('Location: index.php');
exit();

?>