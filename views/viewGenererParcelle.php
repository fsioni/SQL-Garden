<h1>Générer une parcelle</h1>
<br />

<?php if (isset($errorMessage)) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage ?>
    </div>
<?php } ?>


<form method="post" action="#parcelle-tab">
    <h4>Jardin</h4>

    <div class="form-group">
        <label for="jardin">Jardin associé</label>

        <select name="jardin" class="form-select" class="form-select" required>
            <?php foreach ($jardins as $j) { ?>
                <option value="<?php echo $j['nomJ'] ?>"><?php echo $j['nomJ'] ?></option>
            <?php } ?>
        </select>
    </div>
    <br>

    <h4>Nombre de rangs</h4>

    <div class="form-group">
        <label for="minR">Nombre de rangs minimum</label>
        <input type="number" name="minR" min="1" max="2000" step="1" value="50" class="form-control" required>
    </div>
    <br />

    <div class="form-group">
        <label for="maxR">Nombre de rangs maximum</label>
        <input type="number" name="maxR" min="1" max="2000" step="1" value="100" class="form-control" required>
    </div>
    <br />

    <h4>Pourcentage d'occupation</h4>

    <div class="form-group">
        <label for="minR">Pourcentage des rangs occupés par des cultures</label>
        <input type="number" name="pourcVar" min="0" max="100" step="1" value="50" class="form-control" required>
    </div>
    <br />

    <div class="form-group">
        <label for="minR">Pourcentage des rangs occupés par des nuisibles</label>
        <input type="number" name="pourcSauv" min="0" max="100" step="1" value="10" class="form-control" required>
    </div>

    <br /><br />
    <button type="submit" name="boutonValider" value="Ajouter" class="btn btn-primary">Soumettre</button>
</form>

<?php if ($formTraite) : ?>
    <hr />
    <h1>Parcelle générée pour <strong><?php echo $jardin ?></strong> </h1>
    <br />
    <p><strong>Nombre de rangs de la parcelle :</strong> <?php echo $nbRangs ?></p>
    <p><strong>Nombre de rangs libres : </strong> <?php echo ($nbRangs - ($nbRangsCult + $nbRangsSauv)) ?></p>
    <p><strong>Nombre de rangs occupés par des cultures : </strong><?php echo $nbRangsCult ?></p>
    <p><strong>Nombre de rangs occupés par des plantes sauvages : </strong><?php echo $nbRangsSauv ?></p>

    <br />
    <div class="table-responsive" id="parcelle-tab">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Rang</th>
                    <th scope="col">Contenu / type de mise en place</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parcelle as $index => $contenu) { ?>
                    <tr>
                        <th scope="row"><?php echo ($index + 1) ?></th>
                        <td><?php if ($contenu == "Libre") {
                                echo "<p class=\"text-primary\">" . $contenu . "</p>";
                            } elseif (array_key_exists('nomPS', $contenu[0])) {
                                echo "<p class=\"text-danger\">" . ucfirst($contenu[0]["nomPS"]) . "</p>";
                            } else {
                                foreach ($contenu as $var) {
                                    $temp = getNomVariete($connexion, $var["Plante"][0]["id"]);
                                    echo "<p class=\"text-success\">" . $temp[0]["codeVariété"] . " (" . $temp[0]["nomEspèce"] .
                                        ") / " . $var['Type'] . "</p>";
                                }
                            }
                            ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>