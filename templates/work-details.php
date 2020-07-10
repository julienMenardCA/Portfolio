<?php include("top.php") ?>
<!-- Page de détail des travaux -->
<main class="work-detail">
    <h2><?=$work['titre']?></h2>
    <img src="assets/img/works/<?=$work['image']?>">
    <br>
    <br>
    <p><?=$work['description']?></p>
    <?php 
    if($work['lien_github'] !== null && $work['lien_github'] !== 'null')
    {?>
        <a href="<?=$work['lien_github']?>" target="_blank">Github</a>
    <?php }
    ?>
    <?php 
    if($work['lien_projet'] !== null && $work['lien_projet'] !== 'null')
    {?>
        <br>
        <a href="<?=$work['lien_projet']?>" target="_blank">Lien vers le projet</a>
    <?php }
    ?>
</main>

<?php include("bottom.php") ?>