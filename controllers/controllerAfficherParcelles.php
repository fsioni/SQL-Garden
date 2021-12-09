<?php

if (isset($_GET['idJ'])) {
    $id = $_GET['idJ'];
    $jardin = getDetailsJardin($connexion, $id);
    $title = 'Parcelles de ' . $jardin[0]["nomJ"];
    $parcelles = getParcellesOfJardin($connexion, $id);
}
