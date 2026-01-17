<body>
    <header>
        <div>
            <a href="index.php"><img class="logo" src="view/assets/img/SudokuMaster.png" alt=""></a>
            <nav>
                <a href="solo">Jeu Solo</a>
                <a href="salon">Multijoueur</a>
                <a href="classements">Classements</a>
                <a href="regles">Règles</a>
            </nav>
            <div id="utilisateur">
                <?php
                    if (isset($_SESSION["utilisateur"])) {
                        echo '<a href="profil&utilisateurId=' . $_SESSION["utilisateur"]["id_utilisateur"] . '">' . $_SESSION["utilisateur"]["pseudo_utilisateur"] .' </a>';
                    }
                    else {
                        echo '<a href="connexion">Connexion</a>';
                    }
                ?>
                <img src="view/assets/svg/AvatarUtilisateur.svg" alt="">
                <div id="menu_burger">
                    <input type="checkbox" id="checkbox_menu">
                    <img src="view/assets/svg/Menu.svg" alt="">
                    <div class="menu_burger">
                        <a href="solo">Jeu Solo</a>
                        <a href="salon">Multijoueur</a>
                        <a href="classements">Classements</a>
                        <a href="regles">Règles</a>
                         <?php
                            if(isset($_SESSION["utilisateur"])) {
                        ?>
                                <a href="profil&utilisateurId=<?php echo $_SESSION["utilisateur"]["id_utilisateur"]; ?>">Profil</a>
                                <a href="index.php?#">Accessibilité</a>
                                <a href="ideconnexion">Se déconnecter</a>
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
                        <a href="profil&utilisateurId=<?php echo $_SESSION["utilisateur"]["id_utilisateur"]; ?>">Profil</a>
                    </div>
                    <div>
                        <img src="view/assets/svg/Accessibilite.svg" alt="">
                        <a href="index.php?#">Accessibilité</a>
                    </div>
                    <div>
                        <img src="view/assets/svg/Deconnexion.svg" alt="">
                        <a href="deconnexion">Se déconnecter</a>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </header>