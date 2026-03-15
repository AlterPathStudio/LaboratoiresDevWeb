<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link href="./inc/css/style.css" rel="stylesheet" />
    <script src="./inc/js/script.js" defer></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>

<body>
    <?php
    echo '</pre>
          $_COOKIE :<br>
          <pre>';
    print_r($_COOKIE);
echo '</pre>----------------------------<br>';
?>

    <?php if (isset($_SESSION['courriel'])) { ?>
        <div>
            <p>Bienvenue <?= htmlspecialchars($_SESSION['courriel']) ?> <a href="index.php?action=deconnexion">Se déconnecter</a></p>
        </div>
    <?php } else { ?>
        <div>
            <a href="index.php?action=connexion">Se connecter</a>
        </div>
    <?php } ?>
    <nav>
        <ul>
            <li><a href=".">Accueil</a></li>
            <li><a href="index.php?action=produits">Les produits</a></li>
            <li><a href="index.php?action=categories">Les catégories</a></li>
            <li><a href="index.php?action=sessionFermer">Fermer la session<a></li>
            <?php if (isset($_SESSION['courriel'])) { ?>
                <li><a href="index.php?action=deconnexion">Se déconnecter</a></li>
            <?php } else { ?>
                <li><a href="index.php?action=connexion">Se connecter</a></li>
                <li><a href="index.php?action=inscription">S'inscrire</a></li>
            <?php } ?>

        </ul>
    </nav>
