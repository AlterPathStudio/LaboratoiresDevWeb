<?php // Ce fichier sert à gérer l'affichage de la page d'accueil ?>

<?php // La variable $title servira pour la balise <title> dans le fichier template.php ?>
<?php $title = 'Accueil'; ?>

<?php //Démarre la tamporisation du contenu ?>
<?php ob_start(); ?>
<h1>Démonstration du modèle MVC</h1>
<p>Liste des produits sur la page d'accueil</p>


<?php
//Pour chaque produits, crée le code HTML suivant. La variables $produits provient du controleur et est un tableau d'objet de type Produit.
foreach ($produits as $produit){ ?>
    <div>
        <?php //htmlspecialchars() permet de convertir les caractères HTML en caractère encodé ?>
        <h3> <?= htmlspecialchars($produit->get_produit()) ?> </h3>        
        <p><a href="index.php?action=produit&amp;id=<?= $produit->get_id_produit() ?>">Voir les détails</a></p>        
    </div>
<?php } ?>

<?php // Termine la tamporisation et place le contenu dans $content ?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>