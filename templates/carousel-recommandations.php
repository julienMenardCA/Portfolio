<div id="carouselRecommendations" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">
    <?php 
    $nbrRecos = sizeof($recommandations);
    if($nbrRecos > 1)
    {
        for ($i=0; $i < $nbrRecos; $i++) 
        {
            $ifFirstCarousel = "";
            if($i == 0)
            {
                $ifFirstCarousel = ' class="active"';
            }?>
            <li data-target="#carouselRecommendations" data-slide-to="<?=$i?>" <?=$ifFirstCarousel?>></li>
        <?php }
    }?>
</ol>
<div class="carousel-inner">
    <?php 
    foreach ($recommandations as $recommandation) 
    {
        $firstReco = "";
        if($recommandation['id'] == '1')
        {
            $firstReco = 'active';
        }?>
    <div class="carousel-item <?=$firstReco?>">
        <div class="carousel-caption">
            <?php 
            $commentaire = "";
            $tailleReco = mb_strlen($recommandation['commentaire']);
            if($tailleReco > 250 )
            {
                $commentaireReduit = mb_substr($recommandation['commentaire'], 0, 250);
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
                $commentaire = $recommandation['commentaire'];
            }
            ?>
            <p><?=$commentaire?></p>
            <p><?=$recommandation['prenom'].' '.$recommandation['nom'].' le '.$recommandation['date_created']?></p>
        </div>
    </div>
    <?php }
    ?>
  </div>
  <?php 
  if($nbrRecos > 1)
  {?>
<a class="carousel-control-prev" href="#carouselRecommendations" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#carouselRecommendations" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
</a>
  <?php }
  ?>
</div>
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
