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