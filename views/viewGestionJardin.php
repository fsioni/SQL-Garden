<h1>Gérer son jardin</h1>
<br>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsJardinModal"
    data-bs-id="-1" data-bs-name="Jardin" data-bs-surface="0">Ajouter un jardin</button>
<br>
<br>
<br>

<?php if (empty($jardins)) { ?>
<h2>Aucun jardin</h2>
<?php } else { ?>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="varietes-tab">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom jardin</th>
                <th scope="col">Surface</th>
                <th scope="col">Type</th>
                <th scope="col">Nombre de parcelles</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jardins as $jardin) { ?>
            <tr>
                <th><?php echo $jardin["idJ"] ?></th>
                <td><?php echo $jardin["nomJ"] ?></td>
                <td><?php echo $jardin["surface"] ?></td>
                <td><?php echo $jardin["nomType"] ?></td>
                <td><?php
                            $nbParc = getNumberOfParcelles($connexion, $jardin["idJ"])[0]["nb"];
                            echo $nbParc ?></td>
                <td>
                    <ul class="list-inline m-0">
                        <li class="list-inline-item">
                            <a class="btn btn-danger"
                                href='index.php?page=gestion-jardin&delete=<?php echo $jardin["idJ"] ?>'>Supprimer</a>
                        </li>
                        <li class="list-inline-item">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#detailsJardinModal" data-bs-id="<?php echo $jardin["idJ"] ?>"
                                data-bs-name="<?php echo $jardin["nomJ"] ?>"
                                data-bs-type="<?php echo $jardin["idTJ"] ?>"
                                data-bs-surface="<?php echo $jardin["surface"] ?>">Modifier</button>
                        </li>
                        <?php if ($nbParc != 0) { ?>
                        <li class="list-inline-item">
                            <a type="button" class="btn btn-info"
                                href='index.php?page=afficher-parcelles&idJ=<?php echo $jardin["idJ"] ?>'>Afficher les
                                parcelles</a>
                        </li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } ?>


<div class="modal fade" id="detailsJardinModal" tabindex="-1" aria-labelledby="detailsJardinModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsJardinModalLabel">Modification du jardin </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="#">
                    <div class="mb-3">
                        <label for="jardin-name" class="col-form-label">Nom :</label>
                        <input type="text" name="jardin-name" class="form-control" id="jardin-name">
                    </div>
                    <div class="mb-3">
                        <label for="jardin-surface" class="col-form-label">Surface :</label>
                        <input name="jardin-surface" id="jardin-surface" type="number" min="0" max="5000" step="1"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jardin-type" class="col-form-label">Type :</label>
                        <select name="jardin-type" id="jardin-type" class="form-select">
                            <?php foreach ($typesJ as $type) { ?>
                            <option value="<?php echo $type['idTJ'] ?>"><?php echo $type['nomType'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" id="boutonValiderModifier" name="boutonValiderModifier" value="id"
                    class="btn btn-success">Modifier le jardin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $(' [data-toggle="tooltip" ]').tooltip();
});
var jardinModal = document.getElementById('detailsJardinModal')
jardinModal.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget
    var name = button.getAttribute('data-bs-name')
    var surface = button.getAttribute('data-bs-surface')
    var id = button.getAttribute('data-bs-id')
    var type = button.getAttribute('data-bs-type')
    var modalTitle = jardinModal.querySelector('.modal-title')
    var modalJardinName = jardinModal.querySelector('#jardin-name')
    var modalJardinSurface = jardinModal.querySelector('#jardin-surface')
    var modalModifButton = jardinModal.querySelector('#boutonValiderModifier')
    var modalSelect = jardinModal.querySelector('#jardin-type')
    if (id == -1) {
        modalTitle.textContent = "Ajouter un jardin"
        modalSelect.value = 1
        modalModifButton.textContent = "Ajouter le jardin"
    } else {
        modalTitle.textContent = 'Modification du jardin '
        modalSelect.value = type
        modalModifButton.textContent = "Modifier le jardin"
    }
    modalJardinName.value = name
    modalJardinSurface.value = surface
    modalModifButton.value = id
})
</script>