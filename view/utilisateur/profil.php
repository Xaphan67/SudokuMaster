<main>
    <h1>Informations de compte</h1>
    <div id="infos_compte">
        <div>
            <div>
                <p>Pseudo :</p>
                <p>Adresse mail :</p>
                <p>Mot de passe :</p>
            </div>
            <div>
                <p><?php echo $_SESSION["utilisateur"]["pseudo"]?></p>
                <p><?php echo $_SESSION["utilisateur"]["email"]?></p>
                <p>*********</p>
            </div>
        </div>
        <div>
            <div id="bouton_modifier" class="bouton boutonPrincipal boutonProfil">
                <img src="https://placehold.co/40x40/000000/FFFFFF/png" alt="">
                <p>Modifier</p>
            </div>
            <div id="bouton_supprimer" class="bouton boutonPrincipal boutonProfil">
                <img src="https://placehold.co/40x40/000000/FFFFFF/png" alt="">
                <p>Supprimer</p>
            </div>
        </div>
    </div>
    <div id="statistiques">
        <h2>Statistiques Personnelles</h2>
        <div class="onglets onglets-stats">
            <p>Solo</p>
            <p>Coopératif</p>
            <p>Compétitif</p>
        </div>
        <p>Score global</p>
        <p class="score_principal score_large">?</p>
        <table>
            <tbody>
                <tr>
                    <th>Grilles jouées</th>
                    <th>Grilles résolues</th>
                    <th>Temps moyen</th>
                    <th>Meilleur temps</th>
                    <th>Série de victoires</th>
                </tr>
                <tr>
                    <td>?</td>
                    <td>?</td>
                    <td>?</td>
                    <td>?</td>
                    <td>?</td>
                </tr>
            </tbody>
        </table>
    </div>
</main>