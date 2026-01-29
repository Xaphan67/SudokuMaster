{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal" class="vertical">
    <h1>Oups!</h1>
    <section id="section_erreur">
        <h2>{$titre}</h2>
        <p>{$texte}</p>
        <img src="assets/img/{$image}.webp" alt="">
        <p>Pourquoi ne pas se détendre en jouant une partie rapide ?</p>
        <a href="solo" class="bouton boutonPrincipal boutonLarge">Jouer seul</a>
    </section>
</div>
{/block}