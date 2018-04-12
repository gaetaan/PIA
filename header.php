<header>
    <nav class="navbar navbar-dark bg-dark">
        <!-- Navbar content -->

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">
                <!--img src="/assets/icon.png" width="30" height="30" class="d-inline-block align-top rounded-circle" alt=""-->
                FindYourGame
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="index.php">Accueil</a>
                    <a class="nav-item nav-link active" href="catalogue.php">Catalogue</a>
                    <a class="nav-item nav-link active" href="monCompteBis.php">Mon Compte</a>
                </div>
            </div>
        </nav>

        <!--form-- class="form-inline" style="width: 400px;">
            <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
        </form-->

        <div class="pull-right">
            <ul class="nav pull-right">
                <?php if(isset($_SESSION["mail"])){ ?>
                    <li><a href="deconnexion.php"><i class="icon-off"></i> Déconnexion</a></li>
                <?php }else{ ?>
                    <li><a href="connexion.php"><i class="icon-off"></i> Connexion</a></li>
                <?php } ?>
            </ul>
        </div>


    </nav>
</header>

