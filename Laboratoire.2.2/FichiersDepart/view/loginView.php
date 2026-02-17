<?php $title = 'Se connecter'; ?>
<?php require('template.php'); ?>

<?php

//Formulaire pour la connexion
?>
<form action="index.php" method="post">
    <input type="hidden" name="action" value="authentifier">
    <h2>Se connecter</h2>

    <label for="courriel">Courriel: </label>
    <input type="email" id="courriel" name="courriel" required><br>

    <label for="motPasse">Mot de passe: </label>
    <input type="password" id="motPasse" name="motPasse" required><br>

    <label>
        <input type="checkbox" name="souvenirMoi" id="souvenirMoi">Se souvenir de moi
    </label><br>
    <button type="submit">Se connecter</button>
</form>



<!-- g_id_onload contains Google Identity Services settings -->
<div id="g_id_onload" data-auto_prompt="false" data-login_uri="<?=
    'http://' .
    $_SERVER['HTTP_HOST'] .
    rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') .
    '/index.php?action=authGoogle';
?>" data-client_id="968412325146-5ipedunslal15l7q1tfl4itr21mohi3h.apps.googleusercontent.com"></div>
<!-- g_id_signin places the button on a page and supports customization -->
<div class="g_id_signin"></div>
