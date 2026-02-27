<?php $title = 'Produit - ' . $produit->get_produit(); ?>
<?php require('template.php'); ?>
<h1><?= $produit->get_produit(); ?></h1>

    <div>
        <h3>Categorie: <?= htmlspecialchars($produit->get_categorie()) ?> </h3>        
        <p>Description: <?= htmlspecialchars($produit->get_description()) ?> </p>        
    </div>
