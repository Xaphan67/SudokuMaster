    <footer>
		<div>
			<div>
				<a><img src="view/assets/img/GooglePlay.webp" alt=""></a>
				<a><img src="view/assets/img/AppStore.webp" alt=""></a>
			</div>
			<a href="mentions">Mentions légales</a>
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