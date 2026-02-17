<?php $title = 'Inscription'; ?>
<?php require('template.php'); ?>

<form action="index.php" method="post">
    <input type="hidden" name="action" value="inscription">
    <h2>S'inscrire</h2>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" required><br>

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required><br>

    <label for="courriel">Courriel :</label>
    <input type="email" id="courriel" name="courriel" required><br>

    <label for="mot_de_passe">Mot de passe :</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>

    <button type="submit">S'inscrire</button>
</form>



