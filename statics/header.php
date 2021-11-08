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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="data/css/styles.css">
    <title><?php echo $siteName . ' - ' . $title; ?></title>
</head>

<body class="bg-light">

    <!-- Page Wrapper -->
    <header>
        <div style="background: url(data/img/header.jpeg)" class="jumbotron text-white">
            <div class="container py-5 text-center">
                <a href="index.php">
                    <img class="img-fluid" src="https://via.placeholder.com/350x150" alt="Logo <?php echo $siteName ?>">
                </a>
                <p class="font-italic mb-0" style="margin: 2%;">
                    <?php echo $siteDesc ?>
                </p>
            </div>
        </div>

    </header>