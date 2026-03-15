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
                    $infosNouveauProduit = json_decode(file_get_contents('php://input'), true);
                    $champsFautifs = array();

                    if (!is_array($infosNouveauProduit)) {
                        http_response_code(400);
                        echo '{"ÉCHEC" : "L\'ajout du produit a échoué. Le corps de la requête doit être un JSON valide."}';
                        break;
                    }

                    if (!isset($infosNouveauProduit['produit']) || $infosNouveauProduit['produit'] === '') {
                        $champsFautifs[] = 'produit';
                    }

                    if (!isset($infosNouveauProduit['id_categorie']) || $infosNouveauProduit['id_categorie'] === '') {
                        $champsFautifs[] = 'id_categorie';
                    }

                    if (!isset($infosNouveauProduit['description']) || $infosNouveauProduit['description'] === '') {
                        $champsFautifs[] = 'description';
                    }

                    if (!empty($champsFautifs)) {
                        http_response_code(400);
                        echo json_encode(array(
                            'ÉCHEC' => "L'ajout du produit a échoué. Champ(s) fautif(s) : " . implode(', ', $champsFautifs) . '.'
                        ), JSON_UNESCAPED_UNICODE);
                        break;
                    }

                    require_once('controller/controllerProduit.php');
                    $resultatAjout = addProduit(
                        $infosNouveauProduit['produit'],
                        $infosNouveauProduit['id_categorie'],
                        $infosNouveauProduit['description']
                    );

                    if ($resultatAjout['success']) {
                        http_response_code(200);
                        echo json_encode(array('SUCCÈS' => $resultatAjout['message']), JSON_UNESCAPED_UNICODE);
                    } else {
                        http_response_code(400);
                        echo json_encode(array('ÉCHEC' => $resultatAjout['message']), JSON_UNESCAPED_UNICODE);
                    }
                    break;
                
                    case 'PUT':
                        // Cas pour mettre à jour un ou des renseignement(s) en BD sur un produit spécifique
                        $infosProduitExistant = json_decode(file_get_contents('php://input'), true);
                        $champsFautifs = array();

                        if (!is_array($infosProduitExistant)) {
                            http_response_code(400);
                            echo '{"ÉCHEC" : "La modification du produit a échoué. Le corps de la requête doit être un JSON valide."}';
                            break;
                        }

                    
                        if (!isset($infosProduitExistant['id_produit']) || $infosProduitExistant['id_produit'] === '') {
                            $champsFautifs[] = 'id_produit';
                        } elseif (filter_var($infosProduitExistant['id_produit'], FILTER_VALIDATE_INT) === false || (int)$infosProduitExistant['id_produit'] <= 0) {
                            $champsFautifs[] = 'id_produit (doit être un entier strictement positif)';
                        }

                        if (!isset($infosProduitExistant['produit']) || trim((string)$infosProduitExistant['produit']) === '') {
                            $champsFautifs[] = 'produit';
                        }

                        if (!isset($infosProduitExistant['id_categorie']) || $infosProduitExistant['id_categorie'] === '') {
                            $champsFautifs[] = 'id_categorie';
                        } elseif (filter_var($infosProduitExistant['id_categorie'], FILTER_VALIDATE_INT) === false || (int)$infosProduitExistant['id_categorie'] <= 0) {
                            $champsFautifs[] = 'id_categorie (doit être un entier strictement positif)';
                        }

                        if (!isset($infosProduitExistant['description']) || trim((string)$infosProduitExistant['description']) === '') {
                            $champsFautifs[] = 'description';
                        }

                        if (!empty($champsFautifs)) {
                            http_response_code(400);
                            echo json_encode(array(
                                'ÉCHEC' => "La modification du produit a échoué. Champ(s) fautif(s) : " . implode(', ', $champsFautifs) . '.'
                            ), JSON_UNESCAPED_UNICODE);
                            break;
                        }

                        require_once('controller/controllerProduit.php');
                        $resultatModification = editProduit(
                            (int)$infosProduitExistant['id_produit'],
                            trim((string)$infosProduitExistant['produit']),
                            (int)$infosProduitExistant['id_categorie'],
                            trim((string)$infosProduitExistant['description'])
                        );

                        if ($resultatModification['success']) {
                            http_response_code(200);
                            echo json_encode(array('SUCCÈS' => $resultatModification['message']), JSON_UNESCAPED_UNICODE);
                        } else {
                            http_response_code(400);
                            echo json_encode(array('ÉCHEC' => $resultatModification['message']), JSON_UNESCAPED_UNICODE);
                        }
                        break;
                
                    case 'DELETE':
                        // Cas pour supprimer en BD un produit spécifique
                        if (!isset($_REQUEST['id']) || $_REQUEST['id'] === '') {
                            http_response_code(400);
                            echo '{"ÉCHEC" : "La suppression du produit a échoué. Champ fautif : id."}';
                            break;
                        }

                        if (filter_var($_REQUEST['id'], FILTER_VALIDATE_INT) === false || (int)$_REQUEST['id'] <= 0) {
                            http_response_code(400);
                            echo '{"ÉCHEC" : "La suppression du produit a échoué. Le champ id doit être un entier strictement positif."}';
                            break;
                        }

                        require_once('controller/controllerProduit.php');
                        $resultatSuppression = deleteProduit((int)$_REQUEST['id']);

                        if ($resultatSuppression['success']) {
                            http_response_code(200);
                            echo json_encode(array('SUCCÈS' => $resultatSuppression['message']), JSON_UNESCAPED_UNICODE);
                        } else {
                            http_response_code(400);
                            echo json_encode(array('ÉCHEC' => $resultatSuppression['message']), JSON_UNESCAPED_UNICODE);
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