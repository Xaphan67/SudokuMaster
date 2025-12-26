<?php
    require_once("view/partials/head.php");
?>

<body>
    <header>
        <div>
            <a href="index.php"><img src="https://placehold.co/132x54/000000/FFFFFF/png" alt=""></a>
            <nav>
                <a href="index.php?controller=partie&action=soloBoard">Jeu Solo</a>
                <a href="">Multijoueur</a>
                <a href="index.php?action=leaderboard">Classements</a>
                <a href="index.php?action=rules">Règles</a>
            </nav>
            <div id="utilisateur">
                <?php
                    if (isset($_SESSION["utilisateur"])) {
                        echo '<a href="index.php?controller=utilisateur&action=profil&utilisateurId=' . $_SESSION["utilisateur"]["id_utilisateur"] . '">' . $_SESSION["utilisateur"]["pseudo"] .' </a>';
                    }
                    else {
                        echo '<a href="index.php?controller=utilisateur&action=login">Connexion</a>';
                    }
                ?>
                <img src="https://placehold.co/54x54/000000/FFFFFF/png" alt="">
            </div>
        </div>
    </header>