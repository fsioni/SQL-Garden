<?php
$title = 'Ajouter une variété';

// recupération des données
$sols = getInstances($connexion, "TypesSol");
$plantes = selectDistinctColFromTable($connexion, "nomP", "Plantes");
$semenciers = selectDistinctColFromTable($connexion, "nomSem", "Semenciers");
$codesPreco = selectDistinctColFromTable($connexion, "précocité", "Variétés");
