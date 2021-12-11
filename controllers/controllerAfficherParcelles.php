<?php

if (isset($_GET['idJ'])) {
    $id = $_GET['idJ'];
    $jardin = getDetailsJardin($connexion, $id);
    $title = 'Parcelles de ' . $jardin[0]["nomJ"];
    $parcelles = getParcellesOfJardin($connexion, $id);
}

if (isset($_GET['delete'])) {
    deleteParcelle($connexion, $_GET['lat'], $_GET['long']);
    $parcelles = getParcellesOfJardin($connexion, $id);
}

if (isset($_POST['boutonValiderModifier'])) {
    $hauteur = mysqli_real_escape_string($connexion, $_POST['parcelle-hauteur']); // recuperation de la valeur saisie
    $largeur = mysqli_real_escape_string($connexion, $_POST['parcelle-largeur']);

    $coords = mysqli_real_escape_string($connexion, $_POST['boutonValiderModifier']);
    $coords = explode("/", $coords);
    $lat = $coords[0];
    $long = $coords[1];


    if ($lat == -1 || $long == -1) { // ajout d'une parcelle
        addParcelle($connexion, $hauteur, $largeur, $id);
    } else { // modification de la parcelle
        modifParcelle($connexion, $lat, $long, $hauteur, $largeur);
    }

    $parcelles = getParcellesOfJardin($connexion, $id);
}