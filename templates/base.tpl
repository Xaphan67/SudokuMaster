<!DOCTYPE html>
<html lang="fr">
    {* Head (meta données, JS, CSS, etc...) *}
    {include '_partials/head.tpl'}
    <body>
        {* Header *}
        {include '_partials/header.tpl'}
        <main>
            {* Contenu spécifique à chaque page *}
            {block name="contenu"}{/block}
        </main>
        {* Footer *}
        {include '_partials/footer.tpl'}
    </body>
</html>