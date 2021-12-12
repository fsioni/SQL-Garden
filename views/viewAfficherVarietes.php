<h1>Les variétés :</h1>
<br>
<form method="post" action="#">
        <div class="form-group">
            <label for="type">Nom de la variété</label>
            <select type="text" name="type" class="form-control" placeholder="Variétés" value="Variétés" required>
			<option value = "Variétés"> Variétés </option>
			<option value = "Types"> Types </option>
			<option value = "Plantes"> Plantes </option>
		</select>
        </div>
    <button type="submit" name="typeAffichage" value="true" class="btn btn-primary">Soumettre</button>
</form>
<br>

<?php
if(isset($_POST["typeAffichage"])){
	switch($_POST["type"]){
	case "Variétés":
		print("Variétés");
		break;
	case "Plantes":
		print("plantes");
		break;
	case "Type":
		print("types");
		break;
	}
	print("wouioisdofui");
}else{

}

?>
<div class="table-responsive">
    <table class="table table-bordered" id="varietes-tab">
        <thead>
            <tr>
                <th scope="col">idVariété</th>
                <th scope="col">Nom Plante (latin)</th>
                <th scope="col">Nom Variété</th>
                <th scope="col">Semenciers</th>
                <th scope="col">Adaptation aux Argileux</th>
                <th scope="col">Adaptation aux Limoneux</th>
                <th scope="col">Adaptation aux Sableux</th>
                <th scope="col">Année</th>
                <th scope="col">Précocité</th>
                <th scope="col">Descriptions pour le semis</th>
                <th scope="col">Version de prod</th>
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
            <?php while($row = $varietes->fetch_array(MYSQLI_ASSOC))
 { ?>
                <tr>
                    <th><?php echo $row['idV'] ?></th>
                    <th><?php echo $row['nomP']." (" . $row['nomLatinP'] . ")" ?></th>
                    <th><?php echo $row['codeVariété'] ?></th>
                    <th><?php echo $row['nomSem'] ?></th>
                    <th><?php echo $row['Argileux'] ?></th>
                    <th><?php echo $row['Limoneux'] ?></th>
                    <th><?php echo $row['Sableux'] ?></th>
                    <td><?php echo $row['annéeV'] ?></td>
                    <td><?php echo $row['précocité'] ?></td>
                    <td><?php echo $row['contenu'] ?></td>
                    <td><?php echo $row['version'] ?></td>
                    <td><?php echo $row['plantation'] ?></td>
                    <td><?php echo $row['entretien'] ?></td>
                    <td><?php echo $row['récolte'] ?></td>
                    <td><?php echo $row['joursLevée'] ?></td>
                    <td><?php echo $row['périodePlantation'] ?></td>
                    <td><?php echo $row['périodeRécolte'] ?></td>
                    <td><?php echo $row['commentaireGen'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php echo '<script>$(document).ready(function() {$(\' #varietes-tab\').DataTable( {language: {url: \'https://cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json\'}} );} );</script>'
?>
