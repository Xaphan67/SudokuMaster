<main>
    <div id="conteneur_principal" class="vertical">
        <h1>Classements</h1>
        <div id="classements">
            <?php
                for ($mode = 1; $mode <= 3; $mode++) {
                ?>
                    <div>
                        <div>
                            <h2><?php echo ($mode == 1 ? 'Solo' : ($mode == 2 ? 'Coopératif' : 'Compétitif')) ?></h2>
                            <img src="view/assets/svg/<?php echo ($mode == 1 ? 'Solo' : ($mode == 2 ? 'Cooperatif' : 'Competitif')) ?>.svg" alt="">
                        </div>
                        <div class="top_3">
                            <?php
                                for ($place = 0; $place <= 2; $place++) {
                                    if (isset($classements[$mode][$place])) {
                                    ?>
                                        <div>
                                            <div class="info_joueur">
                                                <h3><?php echo $classements[$mode][$place]["pseudo_utilisateur"] ?></h3>
                                                <div>
                                                    <div>
                                                        <p>Nombre total de grilles jouées :</p>
                                                        <p>Nombre de grilles résolues :</p>
                                                        <p>Temps moyen :</p>
                                                        <p>Meilleur temps :</p>
                                                        <p>Série de victoires :</p>
                                                    </div>
                                                    <div>
                                                        <p><?php echo $classements[$mode][$place]["grilles_jouees"] ?></p>
                                                        <p><?php echo $classements[$mode][$place]["grilles_resolues"] ?></p>
                                                        <p><?php echo substr($classements[$mode][$place]["temps_moyen"], 3, 5) ?></p>
                                                        <p><?php echo substr($classements[$mode][$place]["meilleur_temps"], 3, 5) ?></p>
                                                        <p><?php echo $classements[$mode][$place]["serie_victoires"] ?></p>
                                                    </div>
                                                </div>
                                                <img src="view/assets/svg/Fleche.svg" alt="">
                                            </div>
                                            <img src="view/assets/img/Trophee<?php echo ($place == 0 ? 'Or' : ($place == 1 ? 'Argent' : 'Bronze')) ?>.webp" alt="">
                                            <p class="score_principal score_top <?php echo $place == 0 ? 'score_top_1' : '' ?>"><?php echo $classements[$mode][$place]["score_global"] ?></p>
                                            <p><?php echo $classements[$mode][$place]["pseudo_utilisateur"] ?></p>
                                        </div>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <div>
                                            <img src="view/assets/img/Trophee<?php echo ($place == 0 ? 'Or' : ($place == 1 ? 'Argent' : 'Bronze'))?>.webp" alt="">
                                            <p class="score_principal score_top <?php echo $place == 0 ? 'score_top_1' : '' ?>">0</p>
                                            <p>Place libre</p>
                                        </div>
                                    <?php
                                    }
                                }
                            ?>
                        </div>
                        <div class="top_10">
                            <?php
                                for($place = 3; $place <= 9; $place++) {
                                    if (isset($classements[$mode][$place])) {
                                    ?>
                                        <div>
                                            <p><?php echo $classements[$mode][$place]["pseudo_utilisateur"] ?></p>
                                            <p class="score_principal score"><?php echo  $classements[$mode][$place]["score_global"] ?></p>
                                        </div>
                                    <?php
                                    }
                                    else {
                                    ?>
                                        <div>
                                            <p>Place libre</p>
                                            <p class="score_principal score">0</p>
                                        </div>
                                    <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
</main>