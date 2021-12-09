<h1>Parcelles de <?php echo $jardin[0]["nomJ"] ?></h1>
<br>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsParcelleModal" data-bs-long="-1" data-bs-lat="-1" data-bs-hauteur="0" data-bs-largeur="0">Ajouter une parcelle</button>
<br>
<br>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="varietes-tab">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Latitude</th>
                <th scope="col">Longitude</th>
                <th scope="col">Hauteur</th>
                <th scope="col">Largeur</th>
                <th scope="col">Nombre de rangs</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parcelles as $parcelle) { ?>
                <tr>
                    <th><?php echo $parcelle["latitudeP"] ?></th>
                    <th><?php echo $parcelle["longitudeP"] ?></th>
                    <td><?php echo $parcelle["hauteur"] ?></td>
                    <td><?php echo $parcelle["largeur"] ?></td>
                    <td><?php
                        $nbR = getNumberOfRangs($connexion, $parcelle["latitudeP"], $parcelle["longitudeP"])[0]["nb"];
                        echo $nbR ?></td>
                    <td>
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">
                                <a class="btn btn-danger" href=''>Supprimer</a>
                            </li>
                            <li class="list-inline-item">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsParcelleModal" data-bs-long="<?php echo $parcelle["longitudeP"] ?>" data-bs-lat="<?php echo $parcelle["latitudeP"] ?>" data-bs-hauteur="<?php echo $parcelle["hauteur"] ?>" data-bs-largeur="<?php echo "0" //$parcelle["largeur"] 
                                                                                                                                                                                                                                                                                                                            ?>">Modifier</button>
                            </li>
                            <?php if ($nbR != 0) { ?>
                                <li class=" list-inline-item">
                                    <a type="button" class="btn btn-info" href='index.php?page=afficher-rangs'>Afficher les rangs</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="detailsParcelleModal" tabindex="-1" aria-labelledby="detailsParcelleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsParcelleModalLabel">Modification d'une parcelle </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="#">
                    <div class="mb-3">
                        <label for="parcelle-hauteur" class="col-form-label">Hauteur :</label>
                        <input type="text" name="parcelle-hauteur" class="form-control" id="parcelle-hauteur">
                    </div>
                    <div class="mb-3">
                        <label for="parcelle-largeur" class="col-form-label">Largeur :</label>
                        <input name="parcelle-largeur" id="parcelle-largeur" type="number" min="0" max="5000" step="1" class="form-control" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" id="boutonValiderModifier" name="boutonValiderModifier" value="id" class="btn btn-success">Modifier la parcelle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $(' [data-toggle="tooltip" ]').tooltip();
    });
    var parcelleModal = document.getElementById('detailsParcelleModal')

    parcelleModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var long = button.getAttribute('data-bs-long')
        var lat = button.getAttribute('data-bs-lat')

        var haut = button.getAttribute('data-bs-hauteur')
        var larg = button.getAttribute('data-bs-largeur')

        var modalTitle = parcelleModal.querySelector('.modal-title')
        var modalparcelleHauteur = parcelleModal.querySelector('#parcelle-hauteur')
        var modalparcelleLargeur = parcelleModal.querySelector('#parcelle-largeur')

        var modalModifButton = parcelleModal.querySelector('#boutonValiderModifier')

        if (long == -1 && lat == -1) {
            modalTitle.textContent = "Ajouter une parcelle"
            modalModifButton.textContent = "Ajouter la parcelle"
        } else {
            modalTitle.textContent = 'Modification de la parcelle '
            modalModifButton.textContent = "Modifier la parcelle"
        }
        modalparcelleHauteur.value = haut
        modalparcelleLargeur.value = larg


        modalModifButton.value = lat+"/"+long
    })
</script>