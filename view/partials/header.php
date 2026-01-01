<?php
    require_once("view/partials/head.php");
?>

<body>
    <header>
        <div>
            <a href="index.php"><img src="https://placehold.co/132x54/000000/FFFFFF/png" alt=""></a>
            <nav>
                <a href="index.php?controller=partie&action=soloBoard">Jeu Solo</a>
                <a href="index.php?controller=partie&action=lobby">Multijoueur</a>
                <a href="index.php?action=leaderboard">Classements</a>
                <a href="index.php?action=rules">Règles</a>
            </nav>
            <div id="utilisateur">
                <?php
                    if (isset($_SESSION["utilisateur"])) {
                        echo '<a href="index.php?controller=utilisateur&action=profil&utilisateurId=' . $_SESSION["utilisateur"]["id_utilisateur"] . '">' . $_SESSION["utilisateur"]["pseudo_utilisateur"] .' </a>';
                    }
                    else {
                        echo '<a href="index.php?controller=utilisateur&action=login">Connexion</a>';
                    }
                ?>
                <img src="https://placehold.co/54x54/000000/FFFFFF/png" alt="">
                 <?php
                    if(isset($_SESSION["utilisateur"])) {
                ?>
                <div id="menu_utilisateur">
                    <div>
                        <img src="https://placehold.co/36x36/000000/FFFFFF/png" alt="">
                        <a href="index.php?controller=utilisateur&action=profil&utilisateurId=<?php echo $_SESSION["utilisateur"]["id_utilisateur"]; ?>">Profil</a>
                    </div>
                    <div>
                        <img src="https://placehold.co/36x36/000000/FFFFFF/png" alt="">
                        <a href="index.php?#">Accessibilité</a>
                    </div>
                    <div>
                        <img src="https://placehold.co/36x36/000000/FFFFFF/png" alt="">
                        <a href="index.php?controller=utilisateur&action=logout">Se déconnecter</a>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </header>