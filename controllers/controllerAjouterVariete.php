<?php
$title = 'Ajouter une variété';

// recupération des données
$sols = getInstances($connexion, "TypesSols");
$plantes = selectDistinctColFromTable($connexion, "nomP", "Plantes");
$semenciers = selectDistinctColFromTable($connexion, "nomSem", "Semenciers");
$codesPreco = selectDistinctColsFromTable($connexion, "précocité","labelPrécocité", "Variétés");

if (isset($_POST['boutonValider'])) { // formulaire soumis

    $data_keys = array("nomVariete","plante","semencier","version","descriptions","commentaire","année",
		"adaptArgileux","adaptLimoneux","adaptSableux","precocite","plantation","entretien",
		"recolte","joursLevee","perPlant","perRec");
    $data_formulaire = array();
    foreach($data_keys as $key){
	    if($key == "descriptions"){
		    $data_formulaire[$key] = explode(";",mysqli_real_escape_string($connexion, $_POST[$key]));
	    }else if($key == "precocite"){
		    $v = explode(";",mysqli_real_escape_string($connexion, $_POST[$key]));
		    $data_formulaire[$key] = $v[0];
		    $data_formulaire["labelPrecocite"] = $v[1];
	    }else{
		$data_formulaire[$key] = mysqli_real_escape_string($connexion, $_POST[$key]);
	    }
    }


    $verification = checkExists($connexion, $data_formulaire["nomVariete"],$data_formulaire["plante"]);

    if ($verification == false) { // pas de variété avec ce nom, insertion
        $insertion = insertVariete($connexion,$data_formulaire);
        if ($insertion == 1) {
            $successMessage = "La variété ".$data_formulaire["nomVariete"]."a bien été ajoutée !";
        } else {
            $errorMessage = "Erreur lors de l'insertion de la variété".$data_formulaire["nomVariete"];
        }
    } else {
        $errorMessage = "Une variété existe déjà avec le nom ".$data_formulaire["nomVariete"];
    }
}
