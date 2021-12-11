<h1>Récoltes de <?php echo str_replace("\\", "", $lat) . " ; " . str_replace("\\", "", $long) ?> </h1>
<br>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsRecolteModal"
    data-bs-id="-1" data-bs-qual="5" data-bs-quant="5000" data-bs-desc="Bonne crue" data-bs-date="2021-12-13">Ajouter
    une récoltes</button>
<br>
<br>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="varietes-tab">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Qualité/10</th>
                <th scope="col">Quantité/10000</th>
                <th scope="col">Commentaire</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recoltes as $recolte) {
            ?>
            <tr>
                <th><?php echo $recolte["idRec"] ?></th>
                <td><?php echo $recolte["qualité"] ?></td>
                <td><?php echo $recolte["quantité"] ?></td>
                <td><?php echo $recolte["commentaireRec"] ?></td>
                <td><?php echo $recolte["dateRec"] ?></td>
                <td>
                    <ul class="list-inline m-0">
                        <li class="list-inline-item">
                            <a class="btn btn-danger"
                                href=' index.php?page=afficher-recoltes&lat=<?php echo htmlspecialchars($lat, ENT_QUOTES, 'UTF-8') . "&long=" . htmlspecialchars($long, ENT_QUOTES, 'UTF-8') . "&delete=" . $recolte["idRec"] ?>'>Supprimer</a>
                        </li>
                        <li class="list-inline-item">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#detailsRecolteModal"
                                <?php echo 'data-bs-id="' . $recolte["idRec"] . '"' . 'data-bs-qual="' . $recolte["qualité"] . '"' . 'data-bs-quant="' . $recolte["quantité"] . '"' . 'data-bs-desc="' . $recolte["commentaireRec"] . '"' . 'data-bs-date="' . $recolte["dateRec"] . '"' ?>>Modifier</button>
                        </li>
                    </ul>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="detailsRecolteModal" tabindex="-1" aria-labelledby="detailsRecolteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsRecolteModalLabel">Modification d'une récolte </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="#">
                    <div class="mb-3">
                        <label for="rec-qual" class="col-form-label">Qualité :</label>
                        <input name="rec-qual" id="rec-qual" type="number" min="0" max="10" step="1" value="5"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rec-quant" class="col-form-label">Quantité :</label>
                        <input name="rec-quant" id="rec-quant" type="number" min="0" max="10000" step="1" value="5000"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rec-date" class="col-form-label">Date :</label>
                        <input type="date" name="rec-date" class="form-control" id="rec-date" value="2021-12-13"
                            min="1900-01-01" max="2022-12-31">
                    </div>
                    <div class="mb-3">
                        <label for="rec-desc" class="col-form-label">Commentaire :</label>
                        <input type="text" name="rec-desc" id="rec-desc" class="form-control" placeholder="Bonne crue"
                            value="Bonne crue">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" id="boutonValiderModifier" name="boutonValiderModifier" value="id"
                    class="btn btn-success">Modifier la récolte</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $(' [data-toggle="tooltip" ]').tooltip();
});
var recolteModal = document.getElementById('detailsRecolteModal')

recolteModal.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget
    var idRec = button.getAttribute('data-bs-id')
    var qual = button.getAttribute('data-bs-qual')
    var quant = button.getAttribute('data-bs-quant')
    var date = button.getAttribute('data-bs-date')
    var desc = button.getAttribute('data-bs-desc')

    var modalTitle = recolteModal.querySelector('.modal-title')

    var modalRecQual = recolteModal.querySelector('#rec-qual')
    var modalRecQuant = recolteModal.querySelector('#rec-quant')
    var modalRecDate = recolteModal.querySelector('#rec-date')
    var modalRecDesc = recolteModal.querySelector('#rec-desc')

    var modalModifButton = recolteModal.querySelector('#boutonValiderModifier')

    if (idRec == -1) {
        modalTitle.textContent = "Ajouter une récolte"
        modalModifButton.textContent = "Ajouter la récolte"
    } else {
        modalTitle.textContent = 'Modification de la récolte '
        modalModifButton.textContent = "Modifier la récolte"
    }
    modalRecQual.value = qual
    modalRecQuant.value = quant
    modalRecDate.value = date
    modalRecDesc.value = desc

    <?php
        if (!strpos($lat, "\\")) {
            $lat = addcslashes($lat, "'\"");
            $long = addcslashes($long, "'\"");
        }
        ?>

    modalModifButton.value = idRec + "/" + <?php echo '"' . $lat . '"'; ?> + ";" +
        <?php echo '"' . $long . '"'; ?>
})
</script>