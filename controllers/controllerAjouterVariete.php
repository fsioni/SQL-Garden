<?php
$title = 'Ajouter une variété';

// recupération des données
$sols = getInstances($connexion, "TypesSol");
$plantes = selectDistinctColFromTable($connexion, "nomP", "Plantes");
$semenciers = selectDistinctColFromTable($connexion, "nomSem", "Semenciers");
$codesPreco = selectDistinctColsFromTable($connexion, "précocité", "labelPrécocité", "Variétés");

if (isset($_POST['boutonValider'])) { // formulaire soumis

    $nomVariete = mysqli_real_escape_string($connexion, $_POST['nomVariete']); // recuperation de la valeur saisie
    $plante = mysqli_real_escape_string($connexion, $_POST['plante']);
    $semencier = mysqli_real_escape_string($connexion, $_POST['semencier']);
    $version = mysqli_real_escape_string($connexion, $_POST['version']);
    //TODO : gérer les ';' pour les descriptions
    $descriptions = mysqli_real_escape_string($connexion, $_POST['descriptions']);
    $commentaire = mysqli_real_escape_string($connexion, $_POST['commentaire']);
    $annee = mysqli_real_escape_string($connexion, $_POST['année']);

    $adaptArgileux = mysqli_real_escape_string($connexion, $_POST['adaptArgileux']);
    $adaptLimoneux = mysqli_real_escape_string($connexion, $_POST['adaptLimoneux']);
    $adaptSableux = mysqli_real_escape_string($connexion, $_POST['adaptSableux']);

    $precocite = mysqli_real_escape_string($connexion, $_POST['precocite']);

    $plantation = mysqli_real_escape_string($connexion, $_POST['plantation']);
    $entretien = mysqli_real_escape_string($connexion, $_POST['entretien']);
    $recolte = mysqli_real_escape_string($connexion, $_POST['recolte']);
    $joursLevee = mysqli_real_escape_string($connexion, $_POST['joursLevee']);
    $perPlant = mysqli_real_escape_string($connexion, $_POST['perPlant']);
    $perRec = mysqli_real_escape_string($connexion, $_POST['perRec']);


    $verification = getVarietesByName($connexion, $nomVariete);

    if ($verification == FALSE || count($verification) == 0) { // pas de variété avec ce nom, insertion
        //$insertion = insertVariete($connexion, $nomVariete, $plante, $semencier, $version, $descriptions, $commentaire, $annee, $adaptArgileux, $adaptLimoneux, $adaptSableux, $precocite, $plantation, $entretien, $recolte, $joursLevee, $perPlant, $perRec);
        if (/*$insertion == */TRUE) {
            $successMessage = "La variété $nomVariete a bien été ajoutée !";
        } else {
            $errorMessage = "Erreur lors de l'insertion de la variété $nomVariete.";
        }
    } else {
        $errorMessage = "Une variété existe déjà avec le nom $nomVariete.";
    }
}
