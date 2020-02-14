<?php include("top.php") ?>
<header class="bg-primary text-white" id="imieBgnd">
    <div class="container text-center">
      <div id="img-text">
        <h1>Welcome to my success</h1>
      </div>
    </div>
</header>

<main>
<section id="Accueil">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Accueil</h2>
                <p class="lead">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Autem commodi quidem rerum optio voluptas totam earum deleniti veritatis voluptatem quasi ipsam facilis beatae eveniet id, cum dolor quae, asperiores recusandae nihil atque similique consequatur amet porro eligendi. Officia, iusto quas? Soluta earum mollitia, iste explicabo dolores delectus tempore aspernatur veritatis.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-light" id="CurriculumVitae">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Curriculum Vitae</h2>
                <?php include("cv.php") ?>
                <br>
                <form action="index.php?page=cv" method="post" target="_blank">
                    <button class="btn btn-primary" type="submit">Voir mon CV en plein écran (format pdf)</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="TravauxRealises">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Travaux Réalisés</h2>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero odio fugiat voluptatem dolor, provident officiis, id iusto! Obcaecati incidunt, qui nihil beatae magnam et repudiandae ipsa exercitationem, in, quo totam.</p>
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
                        include("carousel.php");
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<?php include("back-to-top-button.php"); ?>
</main>

<?php include("bottom.php") ?>