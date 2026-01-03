<main>
    <div id="conteneur_principal" class="vertical">
        <h1>Classements</h1>
        <div id="classements">
            <div>
                <div>
                    <h2>Solo</h2>
                    <img src="view/assets/svg/Solo.svg" alt="">
                </div>
                <div class="top_3">
                    <div>
                        <img src="view/assets/img/TropheeOr.webp" alt="">
                        <p class="score_principal score_top score_top_1"><?php echo isset($classements[1][0]) ? $classements[1][0]["score_global"] : "0" ?></p>
                        <p><?php echo isset($classements[1][0]) ? $classements[1][0]["pseudo_utilisateur"] : "Place libre" ?></p>
                    </div>
                    <div>
                        <img src="view/assets/img/TropheeArgent.webp" alt="">
                        <p class="score_principal score_top"><?php echo isset($classements[1][1]) ? $classements[1][1]["score_global"] : "0" ?></p>
                        <p><?php echo isset($classements[1][1]) ? $classements[1][1]["pseudo_utilisateur"] : "Place libre" ?></p>
                    </div>
                    <div>
                        <img src="view/assets/img/TropheeBronze.webp" alt="">
                        <p class="score_principal score_top"><?php echo isset($classements[1][2]) ? $classements[1][2]["score_global"] : "0" ?></p>
                        <p><?php echo isset($classements[1][2]) ? $classements[1][2]["pseudo_utilisateur"] : "Place libre" ?></p>
                    </div>
                </div>
                <div class="top_10">
                    <?php
                        for($place = 3; $place <= 9; $place++) {
                            if (isset($classements[1][$place])) {
                            ?>
                                <div>
                                    <p><?php echo $classements[1][$place]["pseudo_utilisateur"] ?></p>
                                    <p class="score_principal score"><?php echo  $classements[1][$place]["score_global"] ?></p>
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
            <div>
                <div>
                    <h2>Coopératif</h2>
                    <img src="view/assets/svg/Cooperatif.svg" alt="">
                </div>
                <div class="top_3">
                    <div>
                        <img src="view/assets/img/TropheeOr.webp" alt="">
                        <p class="score_principal score_top score_top_1"><?php echo isset($classements[2][0]) ? $classements[2][0]["score_global"] : "0" ?></p>
                        <p><?php echo isset($classements[2][0]) ? $classements[2][0]["pseudo_utilisateur"] : "Place libre" ?></p>
                    </div>
                    <div>
                        <img src="view/assets/img/TropheeArgent.webp" alt="">
                        <p class="score_principal score_top"><?php echo isset($classements[2][1]) ? $classements[2][1]["score_global"] : "0" ?></p>
                        <p><?php echo isset($classements[2][1]) ? $classements[2][1]["pseudo_utilisateur"] : "Place libre" ?></p>
                    </div>
                    <div>
                        <img src="view/assets/img/TropheeBronze.webp" alt="">
                        <p class="score_principal score_top"><?php echo isset($classements[2][2]) ? $classements[2][2]["score_global"] : "0" ?></p>
                        <p><?php echo isset($classements[2][2]) ? $classements[2][2]["pseudo_utilisateur"] : "Place libre" ?></p>
                    </div>
                </div>
                <div class="top_10">
                    <?php
                        for($place = 3; $place <= 9; $place++) {
                            if (isset($classements[2][$place])) {
                            ?>
                                <div>
                                    <p><?php echo $classements[2][$place]["pseudo_utilisateur"] ?></p>
                                    <p class="score_principal score"><?php echo  $classements[2][$place]["score_global"] ?></p>
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
            <div>
                <div>
                    <h2>Compétitif</h2>
                    <img src="view/assets/svg/Competitif.svg" alt="">
                </div>
                <div class="top_3">
                    <div>
                        <img src="view/assets/img/TropheeOr.webp" alt="">
                        <p class="score_principal score_top score_top_1"><?php echo isset($classements[3][0]) ? $classements[3][0]["score_global"] : "0" ?></p>
                        <p><?php echo isset($classements[3][0]) ? $classements[3][0]["pseudo_utilisateur"] : "Place libre" ?></p>
                    </div>
                    <div>
                        <img src="view/assets/img/TropheeArgent.webp" alt="">
                        <p class="score_principal score_top"><?php echo isset($classements[3][1]) ? $classements[3][1]["score_global"] : "0" ?></p>
                        <p><?php echo isset($classements[3][1]) ? $classements[3][1]["pseudo_utilisateur"] : "Place libre" ?></p>
                    </div>
                    <div>
                        <img src="view/assets/img/TropheeBronze.webp" alt="">
                        <p class="score_principal score_top"><?php echo isset($classements[3][2]) ? $classements[3][2]["score_global"] : "0" ?></p>
                        <p><?php echo isset($classements[3][2]) ? $classements[3][2]["pseudo_utilisateur"] : "Place libre" ?></p>
                    </div>
                </div>
                <div class="top_10">
                    <?php
                        for($place = 3; $place <= 9; $place++) {
                            if (isset($classements[3][$place])) {
                            ?>
                                <div>
                                    <p><?php echo $classements[3][$place]["pseudo_utilisateur"] ?></p>
                                    <p class="score_principal score"><?php echo  $classements[3][$place]["score_global"] ?></p>
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
        </div>
    </div>
</main>