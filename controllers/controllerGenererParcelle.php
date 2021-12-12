<?php
$title = 'Générer une parcelle';
$jardins = getInstances($connexion, "Jardins");
$formTraite = FALSE;

if (isset($_POST['boutonValider'])) { // formulaire soumis
    $minR = mysqli_real_escape_string($connexion, $_POST['minR']);
    $maxR = mysqli_real_escape_string($connexion, $_POST['maxR']);
    $hautP = mysqli_real_escape_string($connexion, $_POST['hauteurP']);
    $largP = mysqli_real_escape_string($connexion, $_POST['largeurP']);
    $pourcCult = mysqli_real_escape_string($connexion, $_POST['pourcVar']);
    $pourcSauv = mysqli_real_escape_string($connexion, $_POST['pourcSauv']);
    $idJ = mysqli_real_escape_string($connexion, $_POST['jardin']);
    $nomJ = GetJardinNameWithID($connexion, $idJ)[0]['nomJ'];
    if ($minR > $maxR) {
        $errorMessage = "Le nombre de rangs maximum doit être supérieur ou égale au nombre minimum.";
    } else if (($pourcSauv + $pourcCult) > 100) {
        $errorMessage = "La somme des pourcentages doit être inférieure à 100%.";
    } else { //si tous les tests sont passés :
        $nbRangs = rand($minR, $maxR); //renvoie un nombre en $minR et $maxR, si ils = N, renvoie N
        $nbRangsCult = floor($nbRangs * ($pourcCult / 100));
        $nbRangsSauv = floor($nbRangs * ($pourcSauv / 100));

        $rangsCult = array();
        $rangsSauv = array();
        $rangsLibres = array_fill(0, ($nbRangs - ($nbRangsCult + $nbRangsSauv)), "Libre");

        $possibleType = array("Semis", "Plant", "Greffe");
        $nbType = count($possibleType);
        for ($i = 0; $i < $nbRangsCult; $i++) {
            for ($j = 0; $j < rand(1, 3); $j++) {
                $rangsCult[$i][$j]['Plante'] = getRandomVariete($connexion);
                $rangsCult[$i][$j]['Type'] = $possibleType[rand(0, ($nbType) - 1)];
            }
        }

        for ($i = 0; $i < $nbRangsSauv; $i++) {
            $rangsSauv[$i] = getRandomSauvage($connexion);
        }

        $parcelle = array_merge($rangsCult, $rangsSauv, $rangsLibres);
        $coordsRangs = array();

        for ($i = 0; $i < count($parcelle); $i++) {
            $coordsRangs[$i]['lat'] = rand(0, 180) . "°," . rand(0, 60) . "\\'" . rand(0, 60) . "\\\"";
            $coordsRangs[$i]['long'] = rand(0, 180) . "°," . rand(0, 60) . "\\'" . rand(0, 60) . "\\\"";
        }


        shuffle($parcelle);

        $coordsP = addParcelle($connexion, $hautP, $largP, $idJ);
        foreach ($parcelle as $index => $rang) {
            if ($rang == "Libre") {
                $etat = "Libre";
            } elseif (array_key_exists('nomPS', $rang[0])) {
                $etat = "Envahi";
            } else {
                $etat = "Cultivé";
            }

            addRang($connexion, $index, $coordsRangs[$index]['lat'], $coordsRangs[$index]['long'], $etat, $coordsP['lat'], $coordsP['long']);

            if ($etat == "Cultivé") {
                foreach ($rang as $plante) {
                    addPlanteOnRang($connexion, $plante["Plante"][0]["id"], $coordsRangs[$index]['lat'], $coordsRangs[$index]['long'], $plante["Type"]);
                }
            } elseif ($etat == "Envahi") {
                addPlanteSauvageOnRang($connexion, $coordsRangs[$index]['lat'], $coordsRangs[$index]['long'], $rang[0]["nomPS"], date("Y-m-d H:m:s", time()));
            }
        }



        $formTraite = TRUE;
    }
}