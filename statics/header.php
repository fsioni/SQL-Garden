<?php
session_start(); // démarre ou reprend une session

ini_set('display_errors', 1); // affiche les erreurs (au cas où)
ini_set('display_startup_errors', 1); // affiche les erreurs (au cas où)

require('includes/config-db.php'); // inclu laconfig de la bdd
require('models/model.php'); // inclut le fichier modele
require('includes/includes.php'); // inclut des constantes et fonctions du site
require('includes/routes.php'); // fichiers de routes

$connexion = getConnexionDB(); // connexion à la BD
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $siteName . ' - ' . $title; ?></title>
</head>

<body>

    <header>

    </header>