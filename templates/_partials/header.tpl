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
            {if $smarty.session.utilisateur|isset}
                <a href="profil">{$smarty.session.utilisateur.pseudo_utilisateur}</a>
            {else}
                <a href="connexion">Connexion</a>
            {/if}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                <path d="M139 158.25a66 66 0 1 0-62 0c-22 6.23-41.88 19.16-57.61 37.89a6 6 0 0 0 9.18 7.72C49.1 179.44 77.31 166 108 166s58.9 13.44 79.41 37.86a6 6 0 1 0 9.18-7.72C180.86 177.41 161 164.48 139 158.25ZM54 100a54 54 0 1 1 54 54a54.06 54.06 0 0 1-54-54Zm189.25 44.8l-5.92-3.41a22 22 0 0 0 0-10.78l5.92-3.41a6 6 0 0 0-6-10.4l-5.93 3.43a22 22 0 0 0-9.32-5.39V108a6 6 0 0 0-12 0v6.84a22 22 0 0 0-9.32 5.39l-5.93-3.43a6 6 0 0 0-6 10.4l5.92 3.41a22 22 0 0 0 0 10.78l-5.92 3.41a6 6 0 0 0 6 10.4l5.93-3.43a22 22 0 0 0 9.32 5.39V164a6 6 0 0 0 12 0v-6.84a22 22 0 0 0 9.32-5.39l5.93 3.43a6 6 0 0 0 6-10.4ZM216 146a10 10 0 1 1 10-10a10 10 0 0 1-10 10Z"/>
            </svg>
            <div id="menu_burger">
                <input type="checkbox" id="checkbox_menu">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                    <path d="M222 128a6 6 0 0 1-6 6H40a6 6 0 0 1 0-12h176a6 6 0 0 1 6 6ZM40 70h176a6 6 0 0 0 0-12H40a6 6 0 0 0 0 12Zm176 116H40a6 6 0 0 0 0 12h176a6 6 0 0 0 0-12Z"/>
                </svg>
                <div class="menu_burger">
                    {if $smarty.session.utilisateur|isset}
                        <a href="profil">Profil</a>
                    {/if}
                    <a href="solo">Jeu Solo</a>
                    <a href="salon">Multijoueur</a>
                    <a href="classements">Classements</a>
                    <a href="regles" class="menu_burger_sans_bord">Règles</a>
                    <div class="switch">
                        <p>Mode sombre</p>
                        <input type="checkbox" id="mode_sombre_mobile" class="switch_input mode_sombre">
                        <label for="mode_sombre_mobile" class="switch_label"></label>
                    </div>
                    <div class="switch">
                        <p>Mode dyslexique</p>
                        <input type="checkbox" id="mode_dyslexique_mobile" class="switch_input mode_dyslexique">
                        <label for="mode_dyslexique_mobile" class="switch_label"></label>
                    </div>
                    {if $smarty.session.utilisateur|isset}
                        <a href="deconnexion">Se déconnecter</a>
                    {else}
                        <a href="connexion">Se connecter</a>
                    {/if}
                </div>
            </div>
            <div id="menu_utilisateur">
                {if $smarty.session.utilisateur|isset}
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <path d="M229.19 213c-15.81-27.32-40.63-46.49-69.47-54.62a70 70 0 1 0-63.44 0C67.44 166.5 42.62 185.67 26.81 213a6 6 0 1 0 10.38 6c19.21-33.19 53.15-53 90.81-53s71.6 19.81 90.81 53a6 6 0 1 0 10.38-6ZM70 96a58 58 0 1 1 58 58a58.07 58.07 0 0 1-58-58Z"/>
                        </svg>
                        <a href="profil">Profil</a>
                    </div>
                {/if}
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M240 96a8 8 0 0 1-8 8h-16v16a8 8 0 0 1-16 0v-16h-16a8 8 0 0 1 0-16h16V72a8 8 0 0 1 16 0v16h16a8 8 0 0 1 8 8Zm-96-40h8v8a8 8 0 0 0 16 0v-8h8a8 8 0 0 0 0-16h-8v-8a8 8 0 0 0-16 0v8h-8a8 8 0 0 0 0 16Zm72.77 97a8 8 0 0 1 1.43 8A96 96 0 1 1 95.07 37.8a8 8 0 0 1 10.6 9.06a88.07 88.07 0 0 0 103.47 103.47a8 8 0 0 1 7.63 2.67Zm-19.39 14.88c-1.79.09-3.59.14-5.38.14A104.11 104.11 0 0 1 88 64c0-1.79 0-3.59.14-5.38a80 80 0 1 0 109.24 109.24Z"/>
                    </svg>
                    <div class="switch">
                        <p>Mode sombre</p>
                        <input type="checkbox" id="mode_sombre" class="switch_input mode_sombre">
                        <label for="mode_sombre" class="switch_label"></label>
                    </div>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M224 50h-64a38 38 0 0 0-32 17.55A38 38 0 0 0 96 50H32a14 14 0 0 0-14 14v128a14 14 0 0 0 14 14h64a26 26 0 0 1 26 26a6 6 0 0 0 12 0a26 26 0 0 1 26-26h64a14 14 0 0 0 14-14V64a14 14 0 0 0-14-14ZM96 194H32a2 2 0 0 1-2-2V64a2 2 0 0 1 2-2h64a26 26 0 0 1 26 26v116.31A37.86 37.86 0 0 0 96 194Zm130-2a2 2 0 0 1-2 2h-64a37.87 37.87 0 0 0-26 10.32V88a26 26 0 0 1 26-26h64a2 2 0 0 1 2 2Zm-20-96a6 6 0 0 1-6 6h-40a6 6 0 0 1 0-12h40a6 6 0 0 1 6 6Zm0 32a6 6 0 0 1-6 6h-40a6 6 0 0 1 0-12h40a6 6 0 0 1 6 6Zm0 32a6 6 0 0 1-6 6h-40a6 6 0 0 1 0-12h40a6 6 0 0 1 6 6Z"/>
                    </svg>
                    <div class="switch">
                        <p>Mode dyslexique</p>
                        <input type="checkbox" id="mode_dyslexique" class="switch_input mode_dyslexique">
                        <label for="mode_dyslexique" class="switch_label"></label>
                    </div>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M110 216a6 6 0 0 1-6 6H48a14 14 0 0 1-14-14V48a14 14 0 0 1 14-14h56a6 6 0 0 1 0 12H48a2 2 0 0 0-2 2v160a2 2 0 0 0 2 2h56a6 6 0 0 1 6 6Zm110.24-92.24l-40-40a6 6 0 0 0-8.48 8.48L201.51 122H104a6 6 0 0 0 0 12h97.51l-29.75 29.76a6 6 0 1 0 8.48 8.48l40-40a6 6 0 0 0 0-8.48Z"/>
                    </svg>
                    {if $smarty.session.utilisateur|isset}
                        <a href="deconnexion">Se déconnecter</a>
                    {else}
                        <a href="connexion">Se connecter</a>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</header>