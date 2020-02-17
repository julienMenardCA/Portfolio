<?php include(dirname(__FILE__)."/../../templates/top.php");
//echo password_hash('adminTest.1234.', PASSWORD_DEFAULT);?>

<main class="admin-connect">
    <h2>Connexion</h2>

    <form method="post">
        <div class="form-group"> 
            <label for="username">Votre email</label>
            <input class="form-control" type="email" name="email" id="email">
        </div>
        
        <div class="form-group"> 
            <label for="password">Votre mot de passe</label>
            <input class="form-control" type="password" name="password" id="password">
        </div>
    
        <?php 
        if(isset($formIsValid) && $formIsValid === false){
            echo '<div class="alert alert-danger">Mauvais identifiants</div>';
        }
        ?>

        <button class="btn btn-primary">Envoyer !</button>
    </form>
</main>

<?php include(dirname(__FILE__)."/../../templates/bottom.php") ?>