    <footer>
		<div>
			<a><img src="view/assets/img/GooglePlay.webp" alt=""></a>
			<a><img src="view/assets/img/AppStore.webp" alt=""></a>
		</div>
		<div>
			<a href="index.php?action=legals">Mentions légales</a>
			<a href="index.php?action=gcu">Conditions Générales d'Utilisation</a>
		</div>
    </footer>

    <?php
	if (isset($script) && $script != null) {
		foreach ($script as $s) {
			echo ('<script src="view/assets/js/' . $s . '"></script>');
		}
	}
	?>

    </body>
</html>