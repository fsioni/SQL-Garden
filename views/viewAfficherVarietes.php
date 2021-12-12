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
		print("<div class=\"table-responsive\">
    <table class=\"table table-bordered\" id=\"varietes-tab\">
        <thead>
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

		while($row = $varietes->fetch_array(MYSQLI_ASSOC)){
			print("<tr>");
                	print("    <th>". $row['idV']."</th>");
                	print("    <th>". $row['nomP']." (" . $row['nomLatinP'] . ") </th>");
                	print("    <th>". $row['codeVariété'] ."</th>");
                	print("    <th>". $row['nomSem'] ."</th>");
                	print("    <th>". $row['Argileux'] ."</th>");
                	print("    <th>". $row['Limoneux'] ."</th>");
                	print("    <th>". $row['Sableux'] ."</th>");
                	print("    <td>". $row['annéeV'] ."</td>");
                	print("    <td>". $row['précocité'] ."</td>");
                	print("    <td>". $row['contenu'] ."</td>");
                	print("    <td>". $row['version'] ."</td>");
                	print("    <td>". $row['plantation'] ."</td>");
                	print("    <td>". $row['entretien'] ."</td>");
                	print("    <td>". $row['récolte'] ."</td>");
                	print("    <td>". $row['joursLevée'] ."</td>");
                	print("    <td>". $row['périodePlantation'] ."</td>");
                	print("    <td>". $row['périodeRécolte'] ."</td>");
			print("    <td>". $row['commentaireGen'] ."</td>");
		}
                echo "</tr>";
        	echo "</tbody>";
    		echo"</table>";
		echo"</div>";
		break;
	case "Plantes":
		print("plantes");
		break;
	case "Type":
		print("types");
		break;
	}
}else{
	print("<p> Selectionnez un  Affichage ! </p>");
}

?>
                
<?php echo '<script>$(document).ready(function() {$(\' #varietes-tab\').DataTable( {language: {url: \'https://cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json\'}} );} );</script>'
?>
