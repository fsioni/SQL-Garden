<?php
$title = 'Générer une parcelle';
$jardins = getInstances($connexion, "Jardins");
$formTraite = FALSE;

if (isset($_POST['boutonValider'])) { // formulaire soumis
    $data_keys = array("minR","maxR","pourcCult","pourcSauv","jardin");
    $data_formulaire = array();
    foreach( $data_keys as $key ){
	    $data_formulaire[$key] = mysqli_real_escape_string($connexion, $_POST[$key]);
    }

    if ($data_formulaire["minR"] > $data_formulaire["maxR"]) {
        $errorMessage = "Le nombre de rangs maximum doit être supérieur ou égale au nombre minimum.";
    } else if (($data_formulaire["pourcSauv"] + $data_formulaire["pourcCult"]) > 100) {
        $errorMessage = "La somme des pourcentages doit être inférieure à 100%.";
    } else { //si tous les tests sont passés :

	//nombre de rangs par tableau
        $nbRangs = rand($data_formulaire["minR"], $data_formulaire["maxR"]); //renvoie un nombre en $minR et $maxR, si ils = N, renvoie N
        $nbRangsCult = floor($nbRangs * ($data_formulaire["pourcCult"] / 100));
        $nbRangsSauv = floor($nbRangs * ($data_formulaire["pourcSauv"] / 100));

	//date de debut d'occupation
        $dateDébut = date("Y-m-d H:m:s",time());

	// Gestion de la requete d'ajout de la parcelle 
	$coords_par = array( "latitudeP" => genCoords(),
			     "longitudeP" => genCoords());
	$query_parcelle = "INSERT INTO Parcelles VALUES ('".$coords_par["latitudeP"].
		"','".$coords_par["longitudeP"].
		"',".rand(1,100).
		",".(explode("_",$data_formulaire["jardin"])[1]+1).
		",".rand(1,250).")";

	executerequest($query_parcelle,$connexion);

	// Gestion de l'ajout des rangs das la base 
	$table = "Rangs";
	$fields_fill = array("numéro","latitudeR","longitudeR","état","latitudeP","longitudeP");
	$data_X = 

		// Creation des tableaux 
	$rangsCult = set_lat_long(1,$nbRangsCult);
        $rangsSauv = set_lat_long(1,$nbRangsSauv);
        $rangsLibres =set_lat_long(1, ($nbRangs - ($nbRangsCult + $nbRangsSauv)));
	$nb = 0;
	do{

		for($i = 0; $i < $nbRangsCult ; $i++){
			$rangsCult[$i][0] = rand(1,5);
			$rangsCult[$i][3] = "Cultivé";
			$rangsCult[$i][4] = $coords_par["latitudeP"];
			$rangsCult[$i][5] = $coords_par["longitudeP"];
		}
		$nb += $nbRangsCult;

		for($i = 0; $i < $nbRangsSauv ; $i++){
			$rangsSauv[$i][0] = rand(1,5);
			$rangsSauv[$i][3] = "Envahi";
			$rangsSauv[$i][4] = $coords_par["latitudeP"];
			$rangsSauv[$i][5] = $coords_par["longitudeP"];
		}
		$nb += $nbRangsCult;

		for($i = 0; $i < ($nbRangs - ($nbRangsCult + $nbRangsSauv)) ; $i++){
			$rangsLibres[$i][0] = rand(1,5);
			$rangsLibres[$i][3] = "Libre";
			$rangsLibres[$i][4] = $coords_par["latitudeP"];
			$rangsLibres[$i][5] = $coords_par["longitudeP"];
		}
		$nb += $nbRangs - ($nbRangsCult + $nbRangsSauv);

	}while ($nb < $nbRangs);
	
        $parcelle = array_merge($rangsCult, $rangsSauv, $rangsLibres);
	//print(genRequestLoad("Rangs",$fields_fill,$parcelle));
	executerequest(genRequestLoad("Rangs",$fields_fill,$parcelle),$connexion);

	//Gestion de l'ajout des rangs dans les tables secondaires  
	//table Occuper pour le tableau $rangsCult
	//
	$res = mysqli_query($connexion, "SELECT idV FROM Variétés ORDER by RAND() LIMIT ".$nbRangsCult);
	if($res != false){
		$data_rangsCult = mysqli_fetch_all($res);
	}else{
		$errorMessage = "Un probleme est survenu lors de l'attribution des Variétés";
	}

	$table = "Occuper";
	$typeO = array("Semis","Plant","Greffe");
	$fields_fill = array("idV","latitudeR","longitudeR","typeO");

	for($i = 0; $i < $nbRangsCult ; $i++){
	    	$data_rangsCult[$i][1] = $rangsCult[$i][1];
	    	$data_rangsCult[$i][2] = $rangsCult[$i][2];
	    	$data_rangsCult[$i][3] = $typeO[rand(0,2)];
	}

	//print(genRequestLoad("Occuper",$fields_fill,$data_rangsCult));
	executerequest(genRequestLoad("Occuper",$fields_fill,$data_rangsCult),$connexion);


	// Gestion de l'ajout des $rangsSauv a la table Couvir
	//
	//
	$res = mysqli_query($connexion, "SELECT nomPS from PlantesSauvages");
	if($res != false ){
		$plantes_Sauv = mysqli_fetch_all($res);
	}else{
		$errorMessage = "Un probleme est survenu lors de l'attribution des Plantes Sauvages";
	}

	$data_rangsSauv = array();
	$fields_fill = array("latitudeR","longitudeR","nomPS","dateDebut");
	for($i = 0; $i < $nbRangsSauv; $i++){
		$ran = rand(0,212);
		$data_rangsSauv[$i][0]= $rangsSauv[$i][1];
		$data_rangsSauv[$i][1]= $rangsSauv[$i][2];
		$data_rangsSauv[$i][2]= $plantes_Sauv[rand(0,10)][0];
		$data_rangsSauv[$i][3]=	$dateDébut;
	}

	//print(genRequestLoad("Couvrir",$fields_fill,$data_rangsSauv));
	executerequest(genRequestLoad("Couvrir",$fields_fill,$data_rangsSauv),$connexion);
	

        $formTraite = TRUE;
    }
}
