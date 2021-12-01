<h1>Les variétés :</h1>

<div class="table-responsive">
    <table class="table table-bordered" id="varietes-tab">
        <thead>
            <tr>
                <th scope="col">Nom latin</th>
                <th scope="col">Plante</th>
                <th scope="col">Semencier</th>
                <th scope="col">Argileux</th>
                <th scope="col">Limoneux</th>
                <th scope="col">Sableux</th>
                <th scope="col">Année</th>
                <th scope="col">Précocité</th>
                <th scope="col">Descriptions pour le semis</th>
                <th scope="col">Plantation</th>
                <th scope="col">Entretien</th>
                <th scope="col">Récolte</th>
                <th scope="col">Jours de levée</th>
                <th scope="col">Période plantation</th>
                <th scope="col">Période récolte</th>
                <th scope="col">Commentaire général</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($varietes as $variete) { ?>
                <tr>
                    <th scope="row"><?php echo $variete['nomLatin'] ?></th>
                    <td>TODO</td>
                    <td>TODO</td>
                    <td>TODO</td>
                    <td>TODO</td>
                    <td>TODO</td>
                    <td><?php echo $variete['annéeV'] ?></td>
                    <td><?php echo $variete['précocité'] ?></td>
                    <td>TODO</td>
                    <td><?php echo $variete['plantation'] ?></td>
                    <td><?php echo $variete['entretien'] ?></td>
                    <td><?php echo $variete['récolte'] ?></td>
                    <td><?php echo $variete['joursLevée'] ?></td>
                    <td><?php echo $variete['périodePlantation'] ?></td>
                    <td><?php echo $variete['périodeRécolte'] ?></td>
                    <td><?php echo $variete['commentaireGen'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php echo '<script>$(document).ready(function() {$(\' #varietes-tab\').DataTable( {language: {url: \'https://cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json\'}} );} );</script>'
?>