<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 08/03/2018
 * Time: 10:24
 */

    session_start();

    if(! isset($_SESSION["mail"])){
        header('Location: connexion.php');
        exit();
    }

    //on se connecte à la base de données:
    $servername = "localhost";
    $username = "root";
    $password = "root";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=PIA", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo"Connected\n";

        $sqlRequete = "SELECT * FROM users WHERE user_mail = '".$_SESSION["mail"]."'";

        $Requete = $conn->prepare($sqlRequete);

        $Requete->execute();

        // set the resulting array to associative
        $resultat = $Requete->setFetchMode(PDO::FETCH_ASSOC);

    }catch(PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
    }

    if($Requete->rowCount() == 0) {
        echo "probleme pas trouvé le mail.";
    }else{
        while($infos = $Requete->fetch()){
            $_SESSION['id_user'] = $infos['id_user'];
            $_SESSION['user_name'] = $infos['user_name'];
            $_SESSION['user_firstname'] = $infos['user_firstname'];
            $_SESSION['user_phone_number'] = $infos['user_phone_number'];
            $_SESSION['user_adress'] = $infos['user_adress'];
            $_SESSION['user_birthdate'] = $infos['user_birthdate'];
            $_SESSION['is_admin'] = $infos['is_admin'];
            $_SESSION['user_gender'] = $infos['user_gender'];
            $_SESSION['malus'] = $infos['malus'];
            $_SESSION['malus_date'] = $infos['malus_date'];
        }

    }

    try {

        $sqlRequeteJeuxPosseder = "SELECT * FROM borrowing, games WHERE id_user = '".$_SESSION["id_user"]."' AND borrowing.id_game = games.id_game";

        $requeteJeuxPosseder = $conn->prepare($sqlRequeteJeuxPosseder);

        $requeteJeuxPosseder->execute();

        // set the resulting array to associative
        $resultatRequeteJeuxPosseder = $requeteJeuxPosseder->setFetchMode(PDO::FETCH_ASSOC);

    }catch(PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
    }

    try {

        $sqlRequeteAbonnement = "SELECT * FROM subscribers Subs, subscription Subn, borrowing B  WHERE Subs.id_user = B.id_user AND Subs.subscription_name = Subn.subscription_name";

        $RequeteAbonnement = $conn->prepare($sqlRequeteAbonnement);

        $RequeteAbonnement->execute();

        // set the resulting array to associative
        $resultatRequeteAbonnement = $RequeteAbonnement->setFetchMode(PDO::FETCH_ASSOC);



    }catch(PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
    }


?>

<!doctype html>
<html lang="fr">
<head>

    <?php require("head.php"); ?>

    <link href="css/monCompte.css" rel="stylesheet">

    <title>Mon Compte</title>
</head>
<body>

<?php require("header.php"); ?>

<hr>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-sm-10"><h1 style="color: white;"><?php echo $_SESSION['user_name'] . " " . $_SESSION['user_firstname'] ;?></h1></div>
        <!--div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive" src=""></a></div-->
    </div>
    <div class="row">
        <div class="col-sm-3"><!--left col-->

            <ul class="list-group">
                <li class="list-group-item text-muted">Profils</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Nom :</strong></span> <?php echo $_SESSION['user_name']; ?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Email :</strong></span> <?php echo $_SESSION['mail']; ?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Numéro de téléphone :</strong></span> <?php echo $_SESSION['user_phone_number']; ?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Abonnement :</strong></span> <?php echo ""; ?></li>
            </ul>


        </div><!--/col-3-->
        <div class="col-sm-9">

            <ul class="nav nav-tabs" id="myTab">
                <?php if( $_SESSION['is_admin'] == 1 ){?>
                    <li class="active"><a href="#espace_admin" style="margin-left: 10px;" data-toggle="tab"> Espace administrateur</a></li>
                <?php } ?>
                <li <?php if($_SESSION['is_admin'] == 0){ echo' class="active"';} ?> ><a href="#listesJeux" style="margin-left: 10px;" data-toggle="tab">Liste des jeux louées</a></li>
                <li><a href="#settings" style="margin-left: 10px;" data-toggle="tab"> Modifier les informations</a></li>
            </ul>

            <div class="tab-content">

                <?php if( $_SESSION['is_admin'] == 1 ){?>

                <div class="tab-pane active" id="espace_admin">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Trattamento</th>
                                <th>Prodotti utilizzati</th>
                                <th>Colori utilizzati</th>
                                <th>Note</th>
                                <th>Modifica</th>
                            </tr>
                            </thead>
                            <tbody id="items">
                            <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle ">
                                <td>10.05.2017</td>
                                <td>MASSAGGIO schiena</td>
                                <td>usato loreal</td>
                                <td>colore rosso</td>
                                <td>il cliente preferisce il verde</td>
                                <td><button type="button" data-toggle="modal" data-target="#edit" data-uid="1" class="update btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button></td>
                                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                            </tr>

                            <tr>
                                <td colspan="12" class="hiddenRow">
                                    <div class="accordian-body collapse" id="demo1">
                                        <table class="table table-striped">
                                            <h1>Dettagli trattamento</h1>

                                            <tbody>
                                            <tr id='addr0'>
                                                <td>

                                                </td>
                                                <td>
                                                    <input type="text" name='name0'  placeholder='Name' class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name='mail0' placeholder='Mail' class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name='mobile0' placeholder='Mobile' class="form-control"/>
                                                </td>
                                            </tr>
                                            <tr id='addr1'></tr>
                                            </tbody>

                                        </table>
                                        <a id="add_row" class="btn btn-default pull-left">Aggiungi riga</a><a id='delete_row' class="pull-right btn btn-default">Elimina riga</a>

                                    </div>
                                </td>
                            </tr>



                            </tbody>

                        </table>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-4 text-center">
                                <ul class="pagination" id="myPager"></ul>
                            </div>
                        </div>
                    </div><!--/table-resp-->

                    <div id="edit" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4 class="modal-title">Modifica dati per (servizio)</h4>
                                </div>
                                <div class="modal-body">
                                    <input id="fn" type="text" class="form-control" name="fname" placeholder="Prodotti utilizzati">
                                    <input id="ln" type="text" class="form-control" name="fname" placeholder="Colori Utilizzati">
                                    <input id="mn" type="text" class="form-control" name="fname" placeholder="Note">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="up" class="btn btn-success" data-dismiss="modal">Aggiorna</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div><!--/tab-pane-->

                <?php } ?>

                <div <?php if($_SESSION['is_admin'] == 0){ echo' class="tab-pane active"';} ?>  id="listesJeux">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Nom du jeu</th>
                                <th>Plateforme</th>
                                <th>Date pour rendre le jeu</th>
                                <th>Etat</th>
                            </tr>
                            </thead>
                            <tbody id="items">
                            <?php while($jeuxPosseder = $requeteJeuxPosseder->fetch()){ ?>
                                <tr>
                                    <td> <?php echo $jeuxPosseder['borrow_date']; ?> </td>

                                    <td> <?php echo $jeuxPosseder['game_title']; ?> </td>

                                    <td> <?php echo $jeuxPosseder['game_plat']; ?> </td>

                                    <td> <?php echo $jeuxPosseder['return_date']; ?> </td>

                                    <td> <?php
                                        if($jeuxPosseder['real_return_date'] == null){
                                            echo "<p style='color: red'> Jeux à rendre</p>";
                                        }else{
                                            echo "<p style='color: green'> Jeux rendu</p>";
                                        }
                                        ?>
                                    </td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div><!--/tab-pane-->

                <div class="tab-pane" id="settings">
                    <hr>
                    <form class="form" action="##" method="post" id="registrationForm">

                        <div class="row">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="name"><h4><u>Nom :</u></h4></label>
                                    <input type="text" style="width: 350px;" class="form-control" name="name" id="first_name" placeholder=<?php echo '"' . $_SESSION['user_name'] .'"' ?> title="Inserez votre nom.">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-xs-6" style="margin-left:10px;">
                                    <label for="last_name" ><h4><u>Prénom :</u></h4></label>
                                    <input type="text" style="width: 350px;" class="form-control" name="last_name" id="last_name" placeholder=<?php echo '"' . $_SESSION['user_firstname'] .'"' ?> title="prénom">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="mobile" ><h4><u>Numéro de téléphone :</u></h4></label>
                                    <input type="text" style="width: 350px;" class="form-control" name="mobile" id="mobile" placeholder=<?php echo '"' . $_SESSION['user_phone_number'] .'"' ?> title="Inserer le numéro de téléphone">
                                </div>
                            </div>
                            <div class="form-group" style="margin-left:10px;">

                                <div class="col-xs-6">
                                    <label for="email" ><h4><u>Email :</u></h4></label>
                                    <input type="email" style="width: 350px;" class="form-control" name="email" id="email" placeholder=<?php echo '"' . $_SESSION['mail'] .'"' ?> title="inserer l'email">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <br>
                                <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Sauvegarder</button>
                                <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Restaurer</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div><!--/tab-pane-->

        </div><!--/tab-content-->

    </div><!--/col-9-->
</div><!--/row-->
</hr>

<?php require("footer.php"); ?>

</body>
</html>