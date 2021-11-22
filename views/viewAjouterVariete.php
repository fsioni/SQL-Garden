    <h1>Ajouter une variété</h1>
    <br>

    <!------------------------------------
        TODO mettre des valeurs par défaut
    ------------------------------------>
    <h4>Informations générales</h4>

    <form>
        <div class="form-group">
            <label for="nomVariete">Nom de la variété</label>
            <input type="text" class="form-control" placeholder="Fraisier des bois" required>
        </div>
        <br>


        <div class="form-group">
            <label for="pet-select">Plante associée</label>

            <select class="form-select" name="plantes" id="plante-select" class="form-select" required>
                <option value="">--Choisissez une option--</option>
                <?php foreach ($plantes as $plante) { ?>
                    <div class="form-group">
                        <option value="<?php echo $plante['nomP'] ?>"><?php echo $plante['nomP'] ?></option>
                    <?php } ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="pet-select">Semencier</label>

            <select class="form-select" name="semenciers" id="semencier-select" class="form-control" required>
                <option value="">--Choisissez une option--</option>
                <?php foreach ($semenciers as $semencier) { ?>
                    <div class="form-group">
                        <option value="<?php echo $semencier['nomSem'] ?>"><?php echo $semencier['nomSem'] ?></option>
                    <?php } ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="nomVariete">Descriptions pour le semis</label> <br>
            <input type="text" class="form-control" placeholder="S1">
            <small class="form-text text-muted">Séparez les descriptions par des points virgules.</small>
        </div>
        <br>

        <div class="form-group">
            <label for="nomVariete">Commentaire général</label>
            <input type="text" class="form-control" placeholder="S1">
        </div>
        <br>

        <div class="form-group">
            <label for="nomVariete">Année d'enregistrement</label>
            <input type="number" min="1900" max="2022" step="1" value="2021" class="form-control" required>
        </div>
        <br>

        <!------------------------------------
        TODO afficher la selection du nom de la plante en donnant comme choix toutes les plantes existantes

        TODO afficher la selection du semencier en donnant comme choix tous les semenciers existants 
        ------------------------------------>
        <h4>Adapation aux sols</h4>

        <?php foreach ($sols as $sol) { ?>
            <div class="form-group">
                <label for="adapt<?php echo $sol['nomTS'] ?>">Adaptation aux sols <?php echo $sol['nomTS'] ?></label>
                <input type="number" min="0" max="1" step="0.1" value="1" class="form-control">
                <small class="form-text text-muted">Ratio : nombre entre 0 et 1</small>
            </div>
            <br>
        <?php } ?>

        <h4>Autres données</h4>

        <div class="form-group">
            <label for="pet-select">Code précocité</label>

            <select class="form-select" name="plantes" id="plante-select" class="form-select" required>
                <option value="">--Choisissez une option--</option>
                <?php foreach ($codesPreco as $codePreco) { ?>
                    <div class="form-group">
                        <option value="<?php echo $codePreco['précocité'] ?>"><?php echo $codePreco['précocité'] ?></option>
                    <?php } ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="nomVariete">Plantation</label>
            <input type="text" class="form-control" placeholder="S1">
        </div>
        <br>

        <div class="form-group">
            <label for="nomVariete">Entretien</label>
            <input type="text" class="form-control" placeholder="S1">
        </div>
        <br>

        <div class="form-group">
            <label for="nomVariete">Récolte</label>
            <input type="text" class="form-control" placeholder="S1">
        </div>
        <br>

        <div class="form-group">
            <label for="joursLevee">Jours levée</label>
            <input type="number" min="0" max="30" step="1" value="0" class="form-control" required>
        </div>
        <br>

        <div class="form-group">
            <label for="perPlant-select">Période plantation</label>

            <select class="form-select" name="perPlant" id="perPlant-select" class="form-control">
                <option selected>--Choisissez une option--</option>
                <option value="1">Printemps</option>
                <option value="2">Été</option>
                <option value="3">Automne</option>
                <option value="3">Hiver</option>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label for="perRec-select">Période récolte</label>

            <select class="form-select" name="perRec" id="perRec-select" class="form-control">
                <option selected>--Choisissez une option--</option>
                <option value="1">Printemps</option>
                <option value="2">Été</option>
                <option value="3">Automne</option>
                <option value="3">Hiver</option>
            </select>
        </div>
        <br>

        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>