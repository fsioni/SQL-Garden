<?php
$title = 'Générer une parcelle';
$jardins = getInstances($connexion, "Jardins");
$formTraite = FALSE;

if (isset($_POST['boutonValider'])) { // formulaire soumis
    $minR = mysqli_real_escape_string($connexion, $_POST['minR']);
    $maxR = mysqli_real_escape_string($connexion, $_POST['maxR']);
    $pourcCult = mysqli_real_escape_string($connexion, $_POST['pourcVar']);
    $pourcSauv = mysqli_real_escape_string($connexion, $_POST['pourcSauv']);
    $jardin = mysqli_real_escape_string($connexion, $_POST['jardin']);

    if ($minR > $maxR) {
        $errorMessage = "Le nombre de rangs maximum doit être supérieur ou égale au nombre minimum.";
    } else if (($pourcSauv + $pourcCult) > 100) {
        $errorMessage = "La somme des pourcentages doit être inférieure à 100%.";
    } else { //si tous les tests sont passés :
        $nbRangs = rand($minR, $maxR); //renvoie un nombre en $minR et $maxR, si ils = N, renvoie N
        $nbRangsCult = floor($nbRangs * ($pourcCult / 100));
        $nbRangsSauv = floor($nbRangs * ($pourcSauv / 100));
        $dateDébut = time();

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
        shuffle($parcelle);


        $formTraite = TRUE;
    }
}
