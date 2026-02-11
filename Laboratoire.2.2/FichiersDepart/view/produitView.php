<?php $title = 'Produit - ' . $produit->get_produit(); ?>

<?php ob_start(); ?>
<h1><?= $produit->get_produit(); ?></h1>

    <div>
        <h3>Categorie: <?= htmlspecialchars($produit->get_categorie()) ?> </h3>        
        <p>Description: <?= htmlspecialchars($produit->get_description()) ?> </p>        
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>