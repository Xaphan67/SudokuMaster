<body>
    <header>
        <a href="index.php"><img class="logo" src="view/assets/img/SudokuMaster.png" alt=""></a>
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
            <img src="view/assets/svg/AvatarUtilisateur.svg" alt="">
            <div id="menu_burger">
                <input type="checkbox" id="checkbox_menu">
                <img src="view/assets/svg/Menu.svg" alt="">
                <div class="menu_burger">
                    <a href="index.php?controller=partie&action=soloBoard">Jeu Solo</a>
                    <a href="index.php?controller=partie&action=lobby">Multijoueur</a>
                    <a href="index.php?action=leaderboard">Classements</a>
                    <a href="index.php?action=rules">Règles</a>
                     <?php
                        if(isset($_SESSION["utilisateur"])) {
                    ?>
                            <a href="index.php?controller=utilisateur&action=profil&utilisateurId=<?php echo $_SESSION["utilisateur"]["id_utilisateur"]; ?>">Profil</a>
                            <a href="index.php?#">Accessibilité</a>
                            <a href="index.php?controller=utilisateur&action=logout">Se déconnecter</a>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <?php
                if(isset($_SESSION["utilisateur"])) {
            ?>
            <div id="menu_utilisateur">
                <div>
                    <img src="view/assets/svg/Profil.svg" alt="">
                    <a href="index.php?controller=utilisateur&action=profil&utilisateurId=<?php echo $_SESSION["utilisateur"]["id_utilisateur"]; ?>">Profil</a>
                </div>
                <div>
                    <img src="view/assets/svg/Accessibilite.svg" alt="">
                    <a href="index.php?#">Accessibilité</a>
                </div>
                <div>
                    <img src="view/assets/svg/Deconnexion.svg" alt="">
                    <a href="index.php?controller=utilisateur&action=logout">Se déconnecter</a>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </header>