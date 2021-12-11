<?php

if (isset($_GET['lat']) && isset($_GET['long'])) {
    $lat = $_GET['lat'];
    $long = $_GET['long'];

    $title = 'Rangs de ' . $lat . " ; " . $long;
    $rangs = getRangs($connexion, $lat, $long);
}

if (isset($_GET['delete'])) {
    deleteSpecificRang($connexion, $_GET['latD'], $_GET['longD']);
    $rangs = getRangs($connexion, $lat, $long);
}