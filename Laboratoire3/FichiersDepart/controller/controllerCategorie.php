<?php

require("model/CategorieManager.php");


function listCategories(){
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategories();


    require('view/categoriesView.php');
}
?>