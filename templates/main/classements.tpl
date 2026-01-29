{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal">
    <h1>Classements</h1>
    <div id="classements">
        <section>
            <div class="onglets onglets_classements">
                <p class="onglet_actif">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M229.19 213c-15.81-27.32-40.63-46.49-69.47-54.62a70 70 0 1 0-63.44 0C67.44 166.5 42.62 185.67 26.81 213a6 6 0 1 0 10.38 6c19.21-33.19 53.15-53 90.81-53s71.6 19.81 90.81 53a6 6 0 1 0 10.38-6ZM70 96a58 58 0 1 1 58 58a58.07 58.07 0 0 1-58-58Z"/>
                    </svg>
                </p>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M117.82 217.45A6 6 0 0 1 112 222a6.14 6.14 0 0 1-1.46-.18l-32-8a6.15 6.15 0 0 1-1.87-.83l-24-16a6 6 0 0 1 6.66-10l23.13 15.42l31 7.75a6 6 0 0 1 4.36 7.29Zm132.73-96.6a13.89 13.89 0 0 1-7 8.09l-24 12l-55.31 55.31A6 6 0 0 1 160 198a6.08 6.08 0 0 1-1.46-.18l-64-16a6 6 0 0 1-2-.94L36.9 141.16l-24.43-12.22a14 14 0 0 1-6.26-18.78l24.85-49.69a14 14 0 0 1 18.78-6.26L72.6 65.59l53.75-15.36a6 6 0 0 1 3.3 0l53.75 15.36l22.76-11.38a14 14 0 0 1 18.78 6.26l24.85 49.69a13.93 13.93 0 0 1 .76 10.69Zm-232.71-2.64L37.32 128L64 74.68l-19.53-9.74a2 2 0 0 0-2.68.9l-24.85 49.69a2 2 0 0 0-.1 1.52a1.92 1.92 0 0 0 1 1.16ZM191 152.49l-30.73-24.61c-19 16.38-43.58 18.8-63.8 5.88a14 14 0 0 1-2.39-21.71l45.72-44.36a6 6 0 0 1 2.35-1.4L128 62.24L76.19 77l-28.53 57.1l50.9 36.35l59.6 14.9Zm17.68-17.68L180.29 78h-33.86l-43.91 42.6a1.9 1.9 0 0 0-.51 1.55a2 2 0 0 0 .94 1.5c13.29 8.49 34.14 10.87 52.79-7.92a6 6 0 0 1 8-.45L199.56 144Zm30.36-19.28l-24.83-49.69a2 2 0 0 0-2.68-.9l-19.48 9.74L218.68 128l19.48-9.74a1.92 1.92 0 0 0 1-1.16a2 2 0 0 0-.1-1.57Z"/>
                    </svg>
                </p>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M216 34h-64a6 6 0 0 0-4.76 2.34l-65.39 85L70.6 110.1a14 14 0 0 0-19.8 0l-12.7 12.7a14 14 0 0 0 0 19.81L59.51 164L30.1 193.42a14 14 0 0 0 0 19.8l12.69 12.69a14 14 0 0 0 19.8 0L92 196.5l21.4 21.4a14 14 0 0 0 19.8 0l12.7-12.69a14 14 0 0 0 0-19.81l-11.25-11.25l85-65.39A6 6 0 0 0 222 104V40a6 6 0 0 0-6-6ZM54.1 217.42a2 2 0 0 1-2.83 0l-12.68-12.69a2 2 0 0 1 0-2.82L68 172.5L83.51 188Zm83.31-20.7l-12.69 12.7a2 2 0 0 1-2.84 0l-75.29-75.3a2 2 0 0 1 0-2.83l12.69-12.7a2 2 0 0 1 2.84 0l75.29 75.3a2 2 0 0 1 0 2.83ZM210 101.05l-83.91 64.55l-13.6-13.6l51.75-51.76a6 6 0 0 0-8.48-8.48L104 143.51l-13.6-13.6L155 46h55Z"/>
                    </svg>
                </p>
            </div>
            {for $mode = 1 to 3}
                <div id="classements_{$mode == 1 ? "solo" : ($mode == 2 ? "cooperatif" : "competitif")}">
                    <div class="top_3">
                        {for $place = 0 to 2}
                            {if isset($classements[$mode][$place])}
                                <div>
                                    <div class="info_joueur info_joueur_haut">
                                        <h3>{$classements[$mode][$place]["pseudo_utilisateur"]}</h3>
                                        <div>
                                            <div>
                                                <p>Nombre total de grilles jouées :</p>
                                                <p>Nombre de grilles résolues :</p>
                                                <p>Temps moyen :</p>
                                                <p>Meilleur temps :</p>
                                                <p>Série de victoires :</p>
                                            </div>
                                            <div>
                                                <p>{$classements[$mode][$place]["grilles_jouees"]}></p>
                                                <p>{$classements[$mode][$place]["grilles_resolues"]}</p>
                                                <p>{substr($classements[$mode][$place]["temps_moyen"], 3, 5)}</p>
                                                <p>{substr($classements[$mode][$place]["meilleur_temps"], 3, 5)}</p>
                                                <p>{$classements[$mode][$place]["serie_victoires"]}</p>
                                            </div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                            <path d="m229.66 141.66l-96 96a8 8 0 0 1-11.32 0l-96-96A8 8 0 0 1 32 128h40V48a16 16 0 0 1 16-16h80a16 16 0 0 1 16 16v80h40a8 8 0 0 1 5.66 13.66Z"/>
                                        </svg>
                                    </div>
                                    <img src="assets/img/Trophee{$place == 0 ? "Or" : ($place == 1 ? "Argent" : "Bronze")}.webp" alt="">
                                    <p class="score_principal score_top {$place == 0 ? "score_top_1" : ""}">{$classements[$mode][$place]["score_global"]}</p>
                                    <p>{$classements[$mode][$place]["pseudo_utilisateur"]}</p>
                                </div>
                            {else}
                                <div>
                                    <img src="assets/img/Trophee{$place == 0 ? "Or" : ($place == 1 ? "Argent" : "Bronze")}.webp" alt="">
                                    <p class="score_principal score_top {$place == 0 ? "score_top_1" : ""}">0</p>
                                    <p>{$place + 1}<sup>{$place == 0 ? "ère" : "eme"}</sup> place</p>
                                </div>
                            {/if}
                        {/for}
                    </div>
                    <div class="top_10">
                        {for $place = 3 to 9}
                            {if isset($classements[$mode][$place])}
                                <div>
                                    <div class="info_joueur info_joueur_haut">
                                        <h3>{$classements[$mode][$place]["pseudo_utilisateur"]}</h3>
                                        <div>
                                            <div>
                                                <p>Nombre total de grilles jouées :</p>
                                                <p>Nombre de grilles résolues :</p>
                                                <p>Temps moyen :</p>
                                                <p>Meilleur temps :</p>
                                                <p>Série de victoires :</p>
                                            </div>
                                            <div>
                                                <p>{$classements[$mode][$place]["grilles_jouees"]}</p>
                                                <p>{$classements[$mode][$place]["grilles_resolues"]}</p>
                                                <p>{substr($classements[$mode][$place]["temps_moyen"], 3, 5)}</p>
                                                <p>{substr($classements[$mode][$place]["meilleur_temps"], 3, 5)}</p>
                                                <p>{$classements[$mode][$place]["serie_victoires"]}</p>
                                            </div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                            <path d="m229.66 141.66l-96 96a8 8 0 0 1-11.32 0l-96-96A8 8 0 0 1 32 128h40V48a16 16 0 0 1 16-16h80a16 16 0 0 1 16 16v80h40a8 8 0 0 1 5.66 13.66Z"/>
                                        </svg>
                                    </div>
                                    <p>{$classements[$mode][$place]["pseudo_utilisateur"]}</p>
                                    <p class="score_principal score">{$classements[$mode][$place]["score_global"]}</p>
                                </div>
                            {else}
                                <div>
                                    <p>{$place + 1}<sup>eme</sup> place</p>
                                    <p class="score_principal score">0</p>
                                </div>
                            {/if}
                        {/for}
                    </div>
                </div>
            {/for}
        </section>
        {for $mode = 1 to 3}
            <section>
                <div>
                    <h2>{$mode == 1 ? "Solo" : ($mode == 2 ? "Coopératif" : "Compétitif")}</h2>
                    {if $mode == 1}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <path d="M229.19 213c-15.81-27.32-40.63-46.49-69.47-54.62a70 70 0 1 0-63.44 0C67.44 166.5 42.62 185.67 26.81 213a6 6 0 1 0 10.38 6c19.21-33.19 53.15-53 90.81-53s71.6 19.81 90.81 53a6 6 0 1 0 10.38-6ZM70 96a58 58 0 1 1 58 58a58.07 58.07 0 0 1-58-58Z"/>
                        </svg>
                    {else if ($mode == 2)}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <path d="M117.82 217.45A6 6 0 0 1 112 222a6.14 6.14 0 0 1-1.46-.18l-32-8a6.15 6.15 0 0 1-1.87-.83l-24-16a6 6 0 0 1 6.66-10l23.13 15.42l31 7.75a6 6 0 0 1 4.36 7.29Zm132.73-96.6a13.89 13.89 0 0 1-7 8.09l-24 12l-55.31 55.31A6 6 0 0 1 160 198a6.08 6.08 0 0 1-1.46-.18l-64-16a6 6 0 0 1-2-.94L36.9 141.16l-24.43-12.22a14 14 0 0 1-6.26-18.78l24.85-49.69a14 14 0 0 1 18.78-6.26L72.6 65.59l53.75-15.36a6 6 0 0 1 3.3 0l53.75 15.36l22.76-11.38a14 14 0 0 1 18.78 6.26l24.85 49.69a13.93 13.93 0 0 1 .76 10.69Zm-232.71-2.64L37.32 128L64 74.68l-19.53-9.74a2 2 0 0 0-2.68.9l-24.85 49.69a2 2 0 0 0-.1 1.52a1.92 1.92 0 0 0 1 1.16ZM191 152.49l-30.73-24.61c-19 16.38-43.58 18.8-63.8 5.88a14 14 0 0 1-2.39-21.71l45.72-44.36a6 6 0 0 1 2.35-1.4L128 62.24L76.19 77l-28.53 57.1l50.9 36.35l59.6 14.9Zm17.68-17.68L180.29 78h-33.86l-43.91 42.6a1.9 1.9 0 0 0-.51 1.55a2 2 0 0 0 .94 1.5c13.29 8.49 34.14 10.87 52.79-7.92a6 6 0 0 1 8-.45L199.56 144Zm30.36-19.28l-24.83-49.69a2 2 0 0 0-2.68-.9l-19.48 9.74L218.68 128l19.48-9.74a1.92 1.92 0 0 0 1-1.16a2 2 0 0 0-.1-1.57Z"/>
                        </svg>
                    {else}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <path d="M216 34h-64a6 6 0 0 0-4.76 2.34l-65.39 85L70.6 110.1a14 14 0 0 0-19.8 0l-12.7 12.7a14 14 0 0 0 0 19.81L59.51 164L30.1 193.42a14 14 0 0 0 0 19.8l12.69 12.69a14 14 0 0 0 19.8 0L92 196.5l21.4 21.4a14 14 0 0 0 19.8 0l12.7-12.69a14 14 0 0 0 0-19.81l-11.25-11.25l85-65.39A6 6 0 0 0 222 104V40a6 6 0 0 0-6-6ZM54.1 217.42a2 2 0 0 1-2.83 0l-12.68-12.69a2 2 0 0 1 0-2.82L68 172.5L83.51 188Zm83.31-20.7l-12.69 12.7a2 2 0 0 1-2.84 0l-75.29-75.3a2 2 0 0 1 0-2.83l12.69-12.7a2 2 0 0 1 2.84 0l75.29 75.3a2 2 0 0 1 0 2.83ZM210 101.05l-83.91 64.55l-13.6-13.6l51.75-51.76a6 6 0 0 0-8.48-8.48L104 143.51l-13.6-13.6L155 46h55Z"/>
                        </svg>
                    {/if}
                </div>
                <div class="top_3">
                    {for $place = 0 to 2}
                        {if isset($classements[$mode][$place])}
                            <div>
                                <div class="info_joueur info_joueur_haut">
                                    <h3>{$classements[$mode][$place]["pseudo_utilisateur"]}</h3>
                                    <div>
                                        <div>
                                            <p>Nombre total de grilles jouées :</p>
                                            <p>Nombre de grilles résolues :</p>
                                            <p>Temps moyen :</p>
                                            <p>Meilleur temps :</p>
                                            <p>Série de victoires :</p>
                                        </div>
                                        <div>
                                            <p>{$classements[$mode][$place]["grilles_jouees"]}</p>
                                            <p>{$classements[$mode][$place]["grilles_resolues"]}</p>
                                            <p>{substr($classements[$mode][$place]["temps_moyen"], 3, 5)}</p>
                                            <p>{substr($classements[$mode][$place]["meilleur_temps"], 3, 5)}</p>
                                            <p>{$classements[$mode][$place]["serie_victoires"]}</p>
                                        </div>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <path d="m229.66 141.66l-96 96a8 8 0 0 1-11.32 0l-96-96A8 8 0 0 1 32 128h40V48a16 16 0 0 1 16-16h80a16 16 0 0 1 16 16v80h40a8 8 0 0 1 5.66 13.66Z"/>
                                    </svg>
                                </div>
                                <img src="assets/img/Trophee{$place == 0 ? "Or" : ($place == 1 ? "Argent" : 'Bronze')}.webp" alt="">
                                <p class="score_principal score_top {$place == 0 ? "score_top_1" : ""}">{$classements[$mode][$place]["score_global"]}</p>
                                <p>{$classements[$mode][$place]["pseudo_utilisateur"]}</p>
                            </div>
                        {else}
                            <div>
                                <img src="assets/img/Trophee{$place == 0 ? "Or" : ($place == 1 ? "Argent" : "Bronze")}.webp" alt="">
                                <p class="score_principal score_top {$place == 0 ? "score_top_1" : ""}">0</p>
                                <p>{$place + 1}<sup>{$place == 0 ? "ère" : "eme"}</sup> place</p>
                            </div>
                        {/if}
                    {/for}
                </div>
                <div class="top_10">
                    {for $place = 3 to 9}
                        {if isset($classements[$mode][$place])}
                            <div>
                                <div class="info_joueur info_joueur_haut">
                                    <h3>{$classements[$mode][$place]["pseudo_utilisateur"]}></h3>
                                    <div>
                                        <div>
                                            <p>Nombre total de grilles jouées :</p>
                                            <p>Nombre de grilles résolues :</p>
                                            <p>Temps moyen :</p>
                                            <p>Meilleur temps :</p>
                                            <p>Série de victoires :</p>
                                        </div>
                                        <div>
                                            <p>{$classements[$mode][$place]["grilles_jouees"]}</p>
                                            <p>{$classements[$mode][$place]["grilles_resolues"]}</p>
                                            <p>{substr($classements[$mode][$place]["temps_moyen"], 3, 5)}</p>
                                            <p>{substr($classements[$mode][$place]["meilleur_temps"], 3, 5)}</p>
                                            <p>{$classements[$mode][$place]["serie_victoires"]}</p>
                                        </div>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <path d="m229.66 141.66l-96 96a8 8 0 0 1-11.32 0l-96-96A8 8 0 0 1 32 128h40V48a16 16 0 0 1 16-16h80a16 16 0 0 1 16 16v80h40a8 8 0 0 1 5.66 13.66Z"/>
                                    </svg>
                                </div>
                                <p>{$classements[$mode][$place]["pseudo_utilisateur"]}</p>
                                <p class="score_principal score">{$classements[$mode][$place]["score_global"]}</p>
                            </div>
                        {else}
                            <div>
                                <p>{$place + 1}<sup>eme</sup> place</p>
                                <p class="score_principal score">0</p>
                            </div>
                        {/if}
                    {/for}
                </div>
            </section>
        {/for}
    </div>
</div>
{/block}