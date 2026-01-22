<footer>
    <div>
        <div>
            <a><img src="view/assets/img/GooglePlay.webp" alt=""></a>
            <a><img src="view/assets/img/AppStore.webp" alt=""></a>
        </div>
        <a href="mentions">Mentions légales</a>
    </div>
</footer>

{if $scripts}
    {foreach $scripts as $script}
        <script src="view/assets/js/{$script}"></script>
    {/foreach}
{/if}