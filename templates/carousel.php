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
            <h5><?=$recommandation['commentaire']?></h5>
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
<form action="index.php?page=ajout-recommandation" method="post">
    <button class="btn btn-primary" type="submit">Ajouter une recommandation</button>
</form>