<?php include("top.php") ?>
<!-- Page de détail des travaux -->
<main class="work-detail">
    <h2><?=$work['titre']?></h2>
    <img src="assets/img/works/<?=$work['image']?>">
    <p><?=$work['description']?></p>
    <?php 
    if($work['lien_github'] !== null && $work['lien_github'] !== 'null')
    {?>
    <a href="<?=$work['lien_github']?>" target="_blank">Lien Github</a>
    <?php }
    ?>
    <?php 
    if($work['lien_web'] !== null && $work['lien_web'] !== 'null')
    {?>
    <a href="<?=$work['lien_web']?>" target="_blank">Lien Github</a>
    <?php }
    ?>
</main>

<?php include("bottom.php") ?>