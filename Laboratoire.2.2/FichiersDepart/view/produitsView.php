<?php $title = 'Produits'?>
<?php require('template.php'); ?>

<?php
    // Déclaration de la variable
    $titreH1 = "Les produits";

    // Si une catégorie est sélectionnée
    if (isset($categorie)) {
        $titreH1 .= " de la catégorie " . $categorie;
    }

    // Affichage du titre
    echo "<h1>$titreH1</h1>";
?>

<?php foreach($produits as $produit) { ?>
    <div>
        <h3>Produit: <?= htmlspecialchars($produit->get_produit()) ?> </h3>        
        <p>Description: <?= htmlspecialchars($produit->get_description()) ?> </p>        
        <hr>
    </div>
<?php } ?>
