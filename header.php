<?php
/**
 * Created by PhpStorm.
 * User: gaetanbarbaria
 * Date: 08/02/2018
 * Time: 13:07
 */
?>

<header>
    <nav class="navbar navbar-dark bg-dark">
        <!-- Navbar content -->

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">
                <!--img src="/assets/icon.png" width="30" height="30" class="d-inline-block align-top rounded-circle" alt=""-->
                PIA
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="index.php">Accueil</a>
                    <a class="nav-item nav-link active" href="catalogue.php">Catalogue</a>
                    <a class="nav-item nav-link active" href="connexion.php">Mon Compte</a>
                </div>
            </div>
        </nav>

        <!--form-- class="form-inline" style="width: 400px;">
            <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
        </form-->

        <div class="pull-right">
            <ul class="nav pull-right">
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, User <b class="caret"></b></a>
                    <ul class="dropdown-menu navbar-dark bg-dark">
                        <li><a href="#"><i class="icon-cog"></i> Preferences</a></li>
                        <li><a href="#"><i class="icon-envelope"></i> Contact Support</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-off"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>


    </nav>
</header>

