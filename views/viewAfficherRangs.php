    <h1>Rang de <?php echo $lat . " ; " . $long ?></h1>
    <br><br>

    <?php if (empty($rangs)) { ?>
    <h2>Aucun rang</h2>
    <?php } else { ?>
    <div class="table-responsive" id="parcelle-tab">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Rang</th>
                    <th scope="col">Latitude</th>
                    <th scope="col">Longitude</th>
                    <th scope="col">Contenu</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rangs as $index => $contenu) { ?>
                <tr>
                    <th scope="row"><?php echo ($index + 1) ?></th>
                    <th><?php echo $contenu["latitudeR"] ?></th>
                    <th><?php echo $contenu["longitudeR"] ?></th>
                    <td>
                        <ul><?php
                                    $var = getVarietesOnRang($connexion, $contenu["latitudeR"], $contenu["longitudeR"]);
                                    $ps = getPlantesSauvagesOnRang($connexion, $contenu["latitudeR"], $contenu["longitudeR"]);
                                    if (!empty($var)) {
                                        foreach ($var as $v) {
                                            echo "<li><p class=\"text-success\">" . $v["codeVariété"] . " / " . $v["typeO"] . "</p></li>";
                                        }
                                    } elseif (!empty($ps)) {
                                        echo "<li><p class=\"text-danger\">" . $ps[0]["nomPS"] . "</p></li>";
                                    } else {
                                        echo "<p class=\"text-primary\">Libre</p>";
                                    }
                                    ?></ul>
                    </td>
                    <td>
                        <ul class="list-inline m-0">
                            <li>
                                <a class="btn btn-danger"
                                    href='index.php?page=afficher-rangs&lat=<?php echo htmlspecialchars($lat, ENT_QUOTES, 'UTF-8') . "&long=" . htmlspecialchars($long, ENT_QUOTES, 'UTF-8') . "&delete=true&latD=" . htmlspecialchars($contenu["latitudeR"], ENT_QUOTES, 'UTF-8') . "&longD=" . htmlspecialchars($contenu["longitudeR"], ENT_QUOTES, 'UTF-8') ?>'>Supprimer</a>
                            </li>
                        </ul>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php } ?>