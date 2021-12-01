    <h1>Ajouter une variété</h1>
    <br>

    <?php if (isset($errorMessage)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage ?>
        </div>
    <?php } ?>

    <?php if (isset($successMessage)) { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage ?>
        </div>
    <?php } ?>

    <h4>Informations générales</h4>

    <form method="post" action="#">
        <div class="form-group">
            <label for="nomVariete">Nom de la variété</label>
            <input type="text" name="nomVariete" class="form-control" placeholder="Fraisier des bois" value="Fraisier des bois" required>
        </div>
        <br>


        <div class="form-group">
            <label for="plante">Plante associée</label>

            <select class="form-select" name="plante" class="form-select" required>
                <?php foreach ($plantes as $plante) { ?>
                    <option value="<?php echo $plante['nomP'] ?>"><?php echo $plante['nomP'] ?></option>
                <?php } ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="semencier">Semencier</label>

            <select class="form-select" name="semencier" class="form-control" required>
                <?php foreach ($semenciers as $semencier) { ?>
                    <option value="<?php echo $semencier['nomSem'] ?>"><?php echo $semencier['nomSem'] ?></option>
                <?php } ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="descriptions">Descriptions pour le semis</label> <br>
            <input type="text" name="descriptions" class="form-control" placeholder="Couper les feuilles" value="Couper les feuilles">
            <small class="form-text text-muted">Séparez les descriptions par des points virgules.</small>
        </div>
        <br>

        <div class="form-group">
            <label for="commentaire">Commentaire général</label>
            <input type="text" name="commentaire" class="form-control" value="Version sauvage et sucrée de la fraise traditionnelle" placeholder="Version sauvage et sucrée de la fraise traditionnelle">
        </div>
        <br>

        <div class="form-group">
            <label for="année">Année d'enregistrement</label>
            <input name="année" type="number" min="1900" max="2022" step="1" value="2021" class="form-control" required>
        </div>
        <br>

        <h4>Adapation aux sols</h4>

        <?php foreach ($sols as $sol) { ?>
            <div class="form-group">
                <label for="adapt<?php echo $sol['nomTS'] ?>">Adaptation aux sols <?php echo $sol['nomTS'] ?></label>
                <input name="adapt<?php echo $sol['nomTS'] ?>" type="number" min="0" max="1" step="0.1" value="1" class="form-control">
                <small class="form-text text-muted">Ratio : nombre entre 0 et 1</small>
            </div>
            <br>
        <?php } ?>

        <h4>Autres données</h4>

        <div class="form-group">
            <label for="precocite">Code précocité</label>

            <select name="precocite" class="form-select" name="plantes" class="form-select" required>
                <?php foreach ($codesPreco as $codePreco) { ?>
                    <option value="<?php echo $codePreco['précocité'] ?>"><?php echo $codePreco['précocité'] ?></option>
                <?php } ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="plantation">Plantation</label>
            <input name="plantation" type="text" class="form-control" value="Planter sous terre retournée" placeholder="Planter sous terre retournée">
        </div>
        <br>

        <div class="form-group">
            <label for="entretien">Entretien</label>
            <input name="entretien" type="text" class="form-control" value="Arroser modérément toutes les semaines" placeholder="Arroser modérément toutes les semaines">
        </div>
        <br>

        <div class="form-group">
            <label for="recolte">Récolte</label>
            <input name="recolte" type="text" class="form-control" value="Récolter lorsque la peau est rouge vive" placeholder="Récolter lorsque la peau est rouge vif">
        </div>
        <br>

        <div class="form-group">
            <label for="joursLevee">Jours levée</label>
            <input name="joursLevee" type="number" min="0" max="30" step="1" value="0" class="form-control" required>
        </div>
        <br>

        <div class="form-group">
            <label for="perPlant">Période plantation</label>

            <select class="form-select" name="perPlant" class="form-control">
                <option value="Printemps">Printemps</option>
                <option value="Été">Été</option>
                <option value="Automne">Automne</option>
                <option value="Hiver">Hiver</option>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="perRec">Période récolte</label>

            <select class="form-select" name="perRec" class="form-control">
                <option value="Printemps">Printemps</option>
                <option value="Été">Été</option>
                <option value="Automne">Automne</option>
                <option value="Hiver">Hiver</option>
            </select>
        </div>
        <br>

        <button type="submit" name="boutonValider" value="Ajouter" class="btn btn-primary">Soumettre</button>
    </form>