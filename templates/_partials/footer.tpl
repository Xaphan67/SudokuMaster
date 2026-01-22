<footer>
    <div>
        <div>
            <a><img src="assets/img/GooglePlay.webp" alt=""></a>
            <a><img src="assets/img/AppStore.webp" alt=""></a>
        </div>
        <a href="mentions">Mentions légales</a>
    </div>
</footer>

{if $scripts}
    {foreach $scripts as $script}
        <script src="assets/js/{$script}"></script>
    {/foreach}
{/if}