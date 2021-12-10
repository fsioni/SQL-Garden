<?php

if (isset($_GET['lat']) && isset($_GET['long'])) {
    $lat = $_GET['lat'];
    $long = $_GET['long'];

    $title = 'Récoltes de ' . $lat . " ; " . $long;
    $recoltes = getRecoltes($connexion, $lat, $long);
}

if (isset($_GET['delete'])) {
    deleteRecolte($connexion, $_GET['delete']);
    $recoltes = getRecoltes($connexion, $lat, $long);
}

if (isset($_POST['boutonValiderModifier'])) {

    $idAndCoords = mysqli_real_escape_string($connexion, $_POST['boutonValiderModifier']);
    $idAndCoords = explode("/", $idAndCoords);
    $id = $idAndCoords[0];
    if (isset($idAndCoords[1])) {
        $coords = explode(";", $idAndCoords[1]);
        $lat = $coords[0];
        $long = $coords[1];
    }

    $qual = mysqli_real_escape_string($connexion, $_POST['rec-qual']);
    $quant = mysqli_real_escape_string($connexion, $_POST['rec-quant']);
    $comm = mysqli_real_escape_string($connexion, $_POST['rec-desc']);
    $date = mysqli_real_escape_string($connexion, $_POST['rec-date']);

    if ($id == -1) { // ajout d'une récolte
        addRecolte($connexion, $qual, $quant, $comm, $date, $lat, $long);
    } else { // modification de la récolte
        modifRecolte($connexion, $id, $qual, $quant, $comm, $date);
    }
    $recoltes = getRecoltes($connexion, str_replace("\\", "", $lat), str_replace("\\", "", $long));
}