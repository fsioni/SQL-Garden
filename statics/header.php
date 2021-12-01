<?php
session_start(); // démarre ou reprend une session

ini_set('display_errors', 1); // affiche les erreurs (au cas où)
ini_set('display_startup_errors', 1); // affiche les erreurs (au cas où)

require_once('models/model.php'); // inclut le fichier model
require_once('includes/includes.php'); // inclut des constantes et fonctions du site (nom, slogan)
require_once('includes/routes.php'); // fichiers de routes

require('includes/config-db.php'); // inclus la config de la bdd

$controller = 'controllerAccueil'; // contrôleur par défaut
$view = 'viewAccueil'; // vue par défaut

$connexion = getConnexionDB(); // connexion à la BD

if (isset($_GET['page'])) {
    $nomPage = $_GET['page'];
    if (isset($routes[$nomPage])) {
        $controller = $routes[$nomPage]['controller'];
        $view = $routes[$nomPage]['view'];
    }
}
include('controllers/' . $controller . '.php');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="data/css/styles.css">
    <link rel="icon" href="data/img/icon.ico">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>


    <title><?php echo $title . ' - ' . $siteName; ?></title>
</head>

<body class="bg-light">
    <!-- Page Wrapper -->
    <header>
        <div style="background: url(data/img/header.jpeg)" class="jumbotron text-white">
            <div class="container py-5 text-center">
                <a href="index.php">
                    <img class="img-fluid" src="data/img/banner.jpeg" alt="Logo <?php echo $siteName ?>">
                </a>
                <p class="font-italic mb-0" style="margin: 2%;">
                    <?php echo $siteDesc ?>
                </p>
            </div>
        </div>

    </header>