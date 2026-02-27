<?php
    header('Content-Type: application/json'); // Le contenu est au format JSON


    //Pour tester: 
    //GET tous les produits: http://localhost:8080/LaboratoiresDevWeb/Laboratoire3/FichiersDepart/api.php?objet=produit
    //GET un produit: http://localhost:8080/LaboratoiresDevWeb/Laboratoire3/FichiersDepart/api.php?objet=produit&id=1
    //POST: http://localhost:8080/LaboratoiresDevWeb/Laboratoire3/FichiersDepart/api.php?objet=produit&nom=ProduitTest&description=DescriptionTest&prix=9.99
    //PUT: http://localhost:8080/LaboratoiresDevWeb/Laboratoire3/FichiersDepart/api.php?objet=produit&id=1&nom=ProduitMisAJour&description=DescriptionMisAJour&prix=19.99
    //DELETE: http://localhost:8080/LaboratoiresDevWeb/Laboratoire3/FichiersDepart/api.php?objet=produit&id=1
    
    if (isset($_REQUEST['objet'])){
        switch ($_REQUEST['objet']) {
            case 'produit':
                switch ($_SERVER["REQUEST_METHOD"]) {
                    case 'GET':
                        // Cas pour sélectionner en BD un ou des produit(s)
                        if (isset($_REQUEST['id'])) {
                            // Sélectionner un produit spécifique via le contrôleur
                            require_once('controller/controllerProduit.php');
                            $produit = produit($_REQUEST['id'], true);
                            if ($produit !== null) {
                                http_response_code(200);
                                echo $produit;
                            } else {
                                http_response_code(400);
                                echo '{"ÉCHEC" : "Produit non trouvé."}';
                            }
                        } else {
                            // Sélectionner tous les produits
                            require_once('controller/controllerProduit.php');
                            http_response_code(200);
                            echo listProduits(true);
                        }
                        break;
                    
                    case 'POST':
                        // Cas pour insérer en BD un nouveau produit
                        echo "test post";
                        if (
                            isset($_REQUEST['nom']) &&
                            isset($_REQUEST['description']) &&
                            isset($_REQUEST['prix'])
                        ) {
                            require_once('model/ProduitManager.php');
                            $produitManager = new ProduitManager();
                            $nouveauProduit = $produitManager->addProduit(
                                ($_REQUEST['nom']),
                                ($_REQUEST['description']),
                                ($_REQUEST['prix'])
                            );
                            if ($nouveauProduit !== null) {
                                http_response_code(201);
                                echo json_encode($nouveauProduit);
                            } else {
                                http_response_code(500);
                                echo '{"ÉCHEC" : "Erreur lors de l\'insertion du produit."}';
                            }
                        } else {
                            http_response_code(400);
                            echo '{"ÉCHEC" : "Paramètres manquants pour l\'insertion du produit."}';
                        }
                        break; 
                
                    case 'PUT':
                        // Cas pour mettre à jour un ou des renseignement(s) en BD sur un produit spécifique
                        echo "test put";
                        if (
                            isset($_REQUEST['id']) &&
                            isset($_REQUEST['nom']) &&
                            isset($_REQUEST['description']) &&
                            isset($_REQUEST['prix'])
                        ) {
                            require_once('model/ProduitManager.php');
                            $produitManager = new ProduitManager();
                            $produitMisAJour = $produitManager->updateProduit(
                                ($_REQUEST['id']),
                                ($_REQUEST['nom']),
                                ($_REQUEST['description']),
                                ($_REQUEST['prix'])
                            );
                            if ($produitMisAJour !== null) {
                                echo json_encode($produitMisAJour);
                            } else {
                                http_response_code(500);
                                echo '{"ÉCHEC" : "Erreur lors de la mise à jour du produit."}';
                            }
                        } else {
                            http_response_code(400);
                            echo '{"ÉCHEC" : "Paramètres manquants pour la mise à jour du produit."}';
                        }
                        break;
                
                    case 'DELETE':
                        echo "test delete";
                        // Cas pour supprimer en BD un produit spécifique
                        if (
                            isset($_REQUEST['id'])
                        ) {
                            require_once('model/ProduitManager.php');
                            $produitManager = new ProduitManager();
                            $produitSupprime = $produitManager->deleteProduit($_REQUEST['id']);
                            if ($produitSupprime) {
                                echo '{"SUCCÈS" : "Produit supprimé avec succès."}';
                            } else {
                                http_response_code(500);
                                echo '{"ÉCHEC" : "Erreur lors de la suppression du produit."}';
                            }
                        } else {
                            http_response_code(400);
                            echo '{"ÉCHEC" : "Paramètre manquant pour la suppression du produit."}';
                        }
                        break;
                    
                    default:
                        http_response_code(400);
                        echo '{"ÉCHEC" : "Seules les requêtes GET, POST, PUT ou DELETE sont permises."}';
                }

                break;
            
            default:
                http_response_code(400);
                echo '{"ÉCHEC" : "Seules les requêtes concernant des produits peuvent être traitées."}';
        }
    }
?>