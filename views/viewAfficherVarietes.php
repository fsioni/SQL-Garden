<form method="post" action="#">
    <div class="form-group">
        <label for="type"></label>
        <select type="text" name="type" class="form-control" placeholder="Variétés" value="Variétés" required>
            <option
                <?php if (isset($_POST["typeAffichage"]) && $_POST["typeAffichage"] == "Variétés") echo "selected" ?>
                value="Variétés"> Variétés
            </option>
            <option <?php if (isset($_POST["typeAffichage"]) && $_POST["typeAffichage"] == "Types") echo "selected" ?>
                value="Types"> Types </option>
            <option <?php if (isset($_POST["typeAffichage"]) && $_POST["typeAffichage"] == "Plantes") echo "selected" ?>
                value="Plantes"> Plantes
            </option>
        </select>
    </div>
    <button type="submit" name="typeAffichage" value="true" class="btn btn-primary">Soumettre</button>
</form>
<br>

<?php
if (isset($_POST["typeAffichage"])) {
	switch ($_POST["type"]) {
		case "Variétés":
			print("<h1>Les variétés</h1>");
			print("<div class=\"table-responsive\">
    <table class=\"table table-bordered table-striped\" id=\"varietes-tab\">
        <thead class=\"thead-dark\">
            <tr>
                <th scope=\"col\">idVariété</th>
                <th scope=\"col\">Nom Plante (latin)</th>
                <th scope=\"col\">Nom Variété</th>
                <th scope=\"col\">Semenciers</th>
                <th scope=\"col\">Adaptation aux Argileux</th>
                <th scope=\"col\">Adaptation aux Limoneux</th>
                <th scope=\"col\">Adaptation aux Sableux</th>
                <th scope=\"col\">Année</th>
                <th scope=\"col\">Précocité</th>
                <th scope=\"col\">Descriptions pour le semis</th>
                <th scope=\"col\">Version de prod</th>
                <th scope=\"col\">Plantation</th>
                <th scope=\"col\">Entretien</th>
                <th scope=\"col\">Récolte</th>
                <th scope=\"col\">Jours de levée</th>
                <th scope=\"col\">Période plantation</th>
                <th scope=\"col\">Période récolte</th>
                <th scope=\"col\">Commentaire général</th>
            </tr>
        </thead>
        <tbody>");

			while ($row = $varietes->fetch_array(MYSQLI_ASSOC)) {
				print("<tr>");
				print("    <th>" . $row['idV'] . "</th>");
				print("    <th>" . $row['nomP'] . " (" . $row['nomLatinP'] . ") </th>");
				print("<th>" . $row['codeVariété'] . "</th>");
				print("<td>" . $row['nomSem'] . "</td>");
				print("<td>" . $row['Argileux'] . "</td>");
				print("<td>" . $row['Limoneux'] . "</td>");
				print("<td>" . $row['Sableux'] . "</td>");
				print("<td>" . $row['annéeV'] . "</td>");
				print("<td>" . $row['précocité'] . "</td>");
				print("<td>" . $row['contenu'] . "</td>");
				print("<td>" . $row['version'] . "</td>");
				print("<td>" . $row['plantation'] . "</td>");
				print("<td>" . $row['entretien'] . "</td>");
				print("<td>" . $row['récolte'] . "</td>");
				print("<td>" . $row['joursLevée'] . "</td>");
				print("<td>" . $row['périodePlantation'] . "</td>");
				print("<td>" . $row['périodeRécolte'] . "</td>");
				print("<td>" . $row['commentaireGen'] . "</td>");
			}
			echo "</tr>";
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
			break;
		case "Plantes":
			print("<h1>Les plantes</h1>");
			print("<div class=\"table-responsive\">
    <table class=\"table table-bordered table-striped\" id=\"varietes-tab\">
        <thead class=\"thead-dark\">
            <tr>
                <th scope=\"col\">Nom</th>
                <th scope=\"col\">Nom latin</th>
                <th scope=\"col\">Catégorie</th>
                <th scope=\"col\">Type</th>
                <th scope=\"col\">Sous-type</th>
            </tr>
        </thead>
        <tbody>");
			while ($row = $plantes->fetch_array(MYSQLI_ASSOC)) {
				print("<tr>");
				print("    <th>" . $row['nomP'] . "</th>");
				print("    <th>" . $row['nomLatinP'] . " (" . $row['nomLatinP'] . ") </th>");
				print("<td>" . $row['catégorie'] . "</td>");
				print("<td>" . $row['typeP'] . "</td>");
				print("<td>" . $row['sousType'] . "</td>");
			}
			echo "</tr>";
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
			break;
		case "Types":
			print("<h1>Les types</h1>");
			print("<div class=\"table-responsive\">
    <table class=\"table table-bordered table-striped\" id=\"varietes-tab\">
        <thead class=\"thead-dark\">
            <tr>
                <th scope=\"col\">Type</th>
            </tr>
        </thead>
        <tbody>");
			while ($row = $types->fetch_array(MYSQLI_ASSOC)) {
				print("<tr>");
				print("    <th>" . $row['typeP'] . "</th>");
			}
			echo "</tr>";
			echo "</tbody>";
			echo "</table>";
			echo "</div>";

			break;
	}
} else {
	print("<p> Veuillez selectionner un affichage </p>");
}

?>

<?php echo '<script>$(document).ready(function() {$(\' #varietes-tab\').DataTable( {language: {url: \'https://cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json\'}} );} );</script>'
?>