<?php 
include("top.php"); 
//Inclue carousel.php pour ensuite appellé sa fonction pour afficher les carousels
include("carousel.php");?>
<!-- Page d'accueil -->
<header class="bg-primary text-white" id="imieBgnd"></header>

<main>
<section id="Accueil">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Accueil</h2>
                <p>Bienvenue sur mon portfolio. Plus bas vous trouverez mon CV, mes travaux réalisés et des 
                    recommandations laissés par des professionnels.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-light" id="CurriculumVitae">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <button type="button" class="collapsible"><h2>Curriculum Vitae</h2></button>
                <div class="content">
                    <?php include("cv.php") ?>
                    <br>
                    <form action="index.php?page=cv" method="post" target="_blank">
                        <button class="btn btn-primary" type="submit">Voir mon CV (format pdf)</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="TravauxRealises">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Travaux Réalisés</h2>
                <?php carousel('travaux', $works);?>
            </div>
        </div>
    </div>
</section>

<section class="bg-light" id="Recommandations">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Recommandations</h2>
                <?php 
                    if(empty($recommandations))
                    {?>
                    <div class="shrug">¯\_(ツ)_/¯</div>
                    <div class="yarien">
                        <p>Pour l'instant il n'y aucune recommandations, mais vous pouvez en ajouter</p>
                        <form action="index.php?page=ajout-recommandation" method="post">
                            <button class="btn btn-primary" type="submit">Ajouter une recommandation</button>
                        </form>
                    </div>
                    <?php }
                    else
                    {
                        carousel('recommandations', $recommandations);
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<?php include("back-to-top-button.php"); ?>
</main>

<?php include("bottom.php") ?>