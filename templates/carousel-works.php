<div id="carouselTravaux" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">
    <?php 
    $nbrRecos = sizeof($works);
    if($nbrRecos > 1)
    {
        for ($i=0; $i < $nbrRecos; $i++) 
        {
            $ifFirstCarousel = "";
            if($i == 0)
            {
                $ifFirstCarousel = ' class="active"';
            }?>
            <li data-target="#carouselTravaux" data-slide-to="<?=$i?>" <?=$ifFirstCarousel?>></li>
        <?php }
    }?>
</ol>
<div class="carousel-inner">
    <?php 
    foreach ($works as $work) 
    {
        $firstReco = "";
        if($work['id'] == '1')
        {
            $firstReco = 'active';
        }?>
    <div class="carousel-item <?=$firstReco?>">
        <a href="index.php?page=detail-projet&id=<?=$work['id']?>"><img class="d-block w-100" src="assets/img/works/<?=$work['image']?>"></a>
        <div class="carousel-caption">
            <?php 
            $commentaire = "";
            $tailleReco = mb_strlen($work['description']);
            if($tailleReco > 100 )
            {
                $commentaireReduit = mb_substr($work['description'], 0, 50);
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
                $commentaire = $work['description'];
            }
            ?>
            <p><?=$commentaire?></p>
        </div>
    </div>
    <?php }
    ?>
</div>
<?php 
if($nbrRecos > 1)
{?>
<a class="carousel-control-prev" href="#carouselTravaux" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#carouselTravaux" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
</a>
  <?php }
  ?>
</div>