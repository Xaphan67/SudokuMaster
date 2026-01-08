    <footer>
      <div>
        <div>
          <a><img src="app/view/assets/img/GooglePlay.webp" alt=""></a>
          <a><img src="app/view/assets/img/AppStore.webp" alt=""></a>
        </div>
        <div>
          <a href="index.php?action=legals">Mentions légales</a>
          <a href="index.php?action=gcu">Conditions Générales d'Utilisation</a>
        </div>
      </div>
    </footer>

    <?php
      if (isset($script) && $script != null) {
        foreach($script as $s) {
          echo('<script src="app/view/assets/js/' . $s . '"></script>');
        }
      }
    ?>

  </body>
</html>