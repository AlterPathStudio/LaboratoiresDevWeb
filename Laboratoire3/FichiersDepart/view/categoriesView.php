<?php $title = 'Categories'?>
<?php require('template.php'); ?>
<h1>Les catégories</h1>



<?php foreach($categories as $categorie) { ?>
    <div>
        <h3>Catégorie: <?= htmlspecialchars($categorie->get_categorie()) ?> </h3>        
        <p>Description: <?= htmlspecialchars($categorie->get_description()) ?> </p>      
        <!-- Voir les produits mène vers la page: produitscategorie/id_categorie -->
        <p><a href="index.php?action=produitCategorie&amp;id=<?= $categorie->get_id_categorie(); ?>">Voir les produits</a></p>     

        <hr>
    </div>
<?php } ?>
