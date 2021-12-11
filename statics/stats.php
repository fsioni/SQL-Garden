<div class="p-5 mb-4 gray-200 border rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Statistiques de la base de données</h1>
        <div class="row">
            <div class="col-sm-6 mt-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombres d'instances par tables des plus importantes</h5>
                        <ul>
                            <li>
                                <p class="card-text">Plantes :
                                    <strong><?php echo countInstances($connexion, "Plantes") ?></strong>
                                </p>
                            </li>
                            <li>
                                <p class="card-text">Variétés : <strong>
                                        <?php echo countInstances($connexion, "Variétés") ?></strong></p>
                            </li>
                            <li>
                                <p class="card-text">Plantes Sauvages : <strong>
                                        <?php echo countInstances($connexion, "PlantesSauvages") ?></strong></p>
                            </li>
                            <li>
                                <p class="card-text">Rangs : <strong>
                                        <?php echo countInstances($connexion, "Rangs") ?></strong></p>
                            </li>
                            <li>
                                <p class="card-text">Parcelles : <strong>
                                        <?php echo countInstances($connexion, "Parcelles") ?></strong>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Utilisation des types d'occupation</h5>
                        <ul>
                            <?php $typeOcc = getStatsTypeOcc($connexion);
                            foreach ($typeOcc as $t) {
                                echo '<li><p class="card-text">' . $t['typeO'] . ' : <strong>' . $t['nb'] . '</strong> fois</p></li>';
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre de parcelles par jardin (top 5)</h5>
                        <ul>
                            <?php $jardin = getStatsNbParcelles($connexion);
                            foreach ($jardin as $j) {
                                echo '<li><p class="card-text">' . $j['nomJ'] . ' (ID : ' . $j['idJ'] . ') : <strong>' . $j['nb'] . '</strong> parcelles</p></li>';
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Plantes avec le plus de variétés (top 5)</h5>
                        <ul>
                            <?php $plantes = getPlusVariétés($connexion);
                            foreach ($plantes as $p) {
                                echo '<li><p class="card-text">' . $p['PlanteAssociée'] . ' : <strong>' . $p['nb'] . '</strong> variétés</p></li>';
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>