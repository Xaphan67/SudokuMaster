{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal">
    <h1>SUDOKU MASTER</h1>
    <div id="boutons_haut">
        <a href="solo" class="bouton boutonPrincipal boutonLarge">Jouer seul</a>
        <a href="salon" class="bouton boutonPrincipal boutonLarge">Jouer à plusieurs</a>
    </div>
    <section id="accueil_haut">
        <img src="assets/img/Grille.webp" alt="">
        <div>
            <h2>Jouez à Sudoku Master gratuitement !</h2>
            <img src="assets/img/Grille.webp" alt="">
            <p>
                Sudoku Master est un jeu de logique dont l'objectif est de compléter une grille en respectant des règles simples, faisant appel à la réflexion, à la concentration et au raisonnement.<br>
                Pratiqué régulièrement, il contribue à stimuler les fonctions cognitives telles que la mémoire, l'attention et la capacité de résolution de problèmes.
            </p>
            <h3>Différents modes de jeu !</h3>
            <p>Sudoku Master propose plusieurs modes de jeu : un mode solo pour jouer à son rythme et améliorer ses performances, un mode compétitif pour se mesurer à d'autres joueurs et relever des défis chronométrés, ainsi qu'un mode coopératif permettant de résoudre une grille à plusieurs, en favorisant l'échange et la collaboration.</p>
        </div>
    </section>
    <div id="boutons_centre">
        <a href="solo" class="bouton boutonPrincipal boutonLarge">Jouer seul</a>
        <a href="salon" class="bouton boutonPrincipal boutonLarge">Jouer à plusieurs</a>
    </div>
    <section id="accueil_bas">
        <h3>Comment jouer au Sudoku</h3>
        <p>
            Le but du Sudoku est de remplir une grille de 9 x 9 cases avec des chiffres, afin que chaque ligne, chaque colonne et section de 3x3 contienne les chiffres de 1 à 9. Au début du jeu, la grille de 9x9 aura des cases déjà remplies. Votre tâche consistera à vous baser sur la logique pour remplir les chiffres manquants et compléter la grille. Notez qu'un déplacement est incorrect si :<br>
            Chaque ligne contient plusieurs du même chiffre de 1 à 9<br>
            Chaque colonne contient plusieurs du même chiffre de 1 à 9<br>
            Chaque grille de 3x3 cases contient plusieurs du même chiffre de 1 à 9
        </p>
    </section>
</div>
{/block}