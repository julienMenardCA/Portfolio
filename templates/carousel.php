<?php 
//Cette fonction permet de faire un carousel différent correspondant à ce que je veux afficher
//Soit pour les recommandations ou pour les travaux effectué
function carousel($carouselType, $daraArray)
{
    $id = "";
    $comment = "";
    $img = false;
    $recommandation = false;
    //Pour les travaux
    if($carouselType == 'travaux')
    {
        $id = 'carouselTravaux';
        $characterLimit = 50;
        $img = true;
        $comment = 'description';
    }
    //Pour les recommandations
    elseif($carouselType == 'recommandations')
    {
        $id = 'carouselRecommendations';
        $characterLimit = 250;
        $comment = 'commentaire';
        $recommandation = true;
    }
    ?>
    <div id="<?=$id?>" class="carousel slide" data-ride="carousel">
    <?php // ?>
    <ol class="carousel-indicators">
        <?php 
        $nbrRecos = sizeof($daraArray);
        if($nbrRecos > 1)
        {
            for ($i=0; $i < $nbrRecos; $i++) 
            {
                $ifFirstCarousel = "";
                if($i == 0)
                {
                    $ifFirstCarousel = ' class="active"';
                }?>
                <li data-target="#<?=$id?>" data-slide-to="<?=$i?>" <?=$ifFirstCarousel?>></li>
            <?php }
        }?>
    </ol>
    <div class="carousel-inner">
        <?php 
        foreach ($daraArray as $data) 
        {
            $firstReco = "";
            if($data['id'] == '1')
            {
                $firstReco = 'active';
            }?>
        <div class="carousel-item <?=$firstReco?>">
        <?php 
        if($img)
        {?>
        <a href="index.php?page=detail-projet&id=<?=$data["id"]?>"><img class="d-block w-100" src="assets/img/works/<?=$data["image"]?>"></a>
        <?php }
        ?>
            <div class="carousel-caption">
                <?php 
                $commentaire = "";
                $tailleReco = mb_strlen($data[$comment]);
                if($tailleReco > 100 )
                {
                    $commentaireReduit = mb_substr($data[$comment], 0, $characterLimit);
                    $commentaireExplode = explode(" ", $commentaireReduit);
                    for ($i=0; $i < sizeof($commentaireExplode)-1; $i++) 
                    { 
                        $commentaire .= $commentaireExplode[$i];
                        if($i < sizeof($commentaireExplode)-2)
                        {
                            $commentaire .= " ";
                        }
                        else
                        {
                            $commentaire .= "[...]";
                        }
                    }
                }
                else
                {
                    $commentaire = $data[$comment];
                }
                ?>
                <p><?=$commentaire?></p>
                <?php 
                if($recommandation)
                {?>
                <p><?=$data['prenom'].' '.$data['nom'].' le '.$data['date_created']?></p>
                <?php }
                ?>
            </div>
        </div>
        <?php }
        ?>
    </div>
    <?php 
    if($nbrRecos > 1)
    {?>
    <a class="carousel-control-prev" href="#<?=$id?>" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#<?=$id?>" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    <?php }
    ?>
    </div>
    <?php
    if($recommandation)
    {?>
    <div class="carousel-buttons">
        <div class="gauche">
            <form action="index.php?page=ajout-recommandation" method="post">
                <button class="btn btn-primary" type="submit">Ajouter une recommandation</button>
            </form>
        </div>
        <div class="droite">
            <form action="index.php?page=toutes-recommandation" method="post">
                <button class="btn btn-primary" type="submit">Voir toutes les recommandations</button>
            </form>
        </div>
    </div>
    <?php }
    ?>
<?php 
} ?>