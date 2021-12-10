<?php
$title = "Gérer son jardin";

$jardins = getJardinsAndTypes($connexion);
$typesJ = getInstances($connexion, "TypesJardins");

if (isset($_GET['delete'])) {
    deleteJardin($connexion, $_GET['delete']);
    $jardins = getJardinsAndTypes($connexion);
}

if (isset($_POST['boutonValiderModifier'])) {
    $nom = mysqli_real_escape_string($connexion, $_POST['jardin-name']); // recuperation de la valeur saisie
    $surface = mysqli_real_escape_string($connexion, $_POST['jardin-surface']);
    $id = mysqli_real_escape_string($connexion, $_POST['boutonValiderModifier']);
    $type = mysqli_real_escape_string($connexion, $_POST['jardin-type']);

    if ($id == -1) { // ajout d'un jardin
        addJardin($connexion, $nom, $surface, $type);
    } else { // modification du jardin
        $jardin = getDetailsJardin($connexion, $id);

        if ($nom != $jardin[0]['nomJ'] || $surface != $jardin[0]['surface'] || $type != $jardin[0]['idTJ']) {
            modifJardin($connexion, $id, $nom, $surface, $type);
        }
    }
    $jardins = getJardinsAndTypes($connexion);
}