<?php include("top.php") ?>

<main>
    <?php 
    foreach ($allRecommandations as $recommandation) 
    {?>
        <div class="recommendations">
            <p class="author"><?=$recommandation['prenom'].' '.$recommandation['nom']?></p>
            <p class="comment"><?=$recommandation['commentaire']?></p>
            <p class="date"><?='Le '.$recommandation['date_created']?></p>
        </div>
    <?php }
    ?>
</main>

<?php include("bottom.php") ?>