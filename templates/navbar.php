<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="/">Portfolio de Julien Menard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <?php 
                    //Si l'admin est connecté, ces deux bouttons s'affichent
                    if(isset($_SESSION['admin']['connected']) && $_SESSION['admin']['connected'] === true)
                    {?>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="index.php?page=itsadmintime" style="color : red">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="index.php?page=itsdecotime" style="color : red">Déconnexion</a>
                    </li>
                    <?php }
                ?>

                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php?page=accueil#Accueil">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php?page=accueil#CurriculumVitae">Curriculum Vitae</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php?page=accueil#TravauxRealises">Travaux Réalisés</a>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php?page=accueil#Recommandations">Recommandations</a>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php?page=contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>