<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="./inc/css/style.css" rel="stylesheet" /> 
        <script src="https://accounts.google.com/gsi/client" async defer></script>
        <script src="./inc/js/script.js" defer></script>.
    </head>
        
    <body>
        

        <?php
        if (isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'deconnexion') {
            }
        }
        ?>

        <?php if (isset($_SESSION['courriel'])) { ?>
            <div>
                <p>Bienvenue <?= htmlspecialchars($_SESSION['courriel']) ?>   <a href="?action=deconnexion">Se déconnecter</a></p>
            </div>
        <?php } else { ?>
            <div>
                <a href="?action=connexion">Se connecter</a>
            </div>
        <?php } ?>

        <nav>
            <ul>
                <li><a href=".">Accueil</a></li>
                <li><a href="./produits">Les produits</a></li>
                <li><a href="./categories">Les catégorie</a></li>
                <?php if (isset($_SESSION['courriel'])) { ?>
                    <li><a href="?action=deconnexion">Se déconnecter</a></li>
                <?php } else { ?>
                    <li><a href="?action=connexion">Se connecter</a></li>
                <?php } ?>
                
            </ul>
        </nav>
        <?= $content ?>
    </body>
</html>