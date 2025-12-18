    <footer>
        <a><img src="https://placehold.co/124x40/000000/FFFFFF/png" alt=""></a>
        <a><img src="https://placehold.co/124x40/000000/FFFFFF/png" alt=""></a>
        <a href="index.php?action=legals">Mentions légales</a>
        <a href="index.php?action=gcu">Conditions Générales d'Utilisation</a>
    </footer>

    <?php
      if (isset($script) && $script != null) {
        foreach($script as $s) {
          echo('<script src="view/assets/js/' . $s . '"></script>');
        }
      }
    ?>

  </body>
</html>