<?php

// connexion à la BD, retourne un lien de connexion
function getConnexionDB()
{
    $connexion = mysqli_connect(SERVER, USER, PASSWORD, DB);
    if (mysqli_connect_errno()) {
        printf("Échec de la connexion : %s\n", mysqli_connect_error());
        exit();
    }
    return $connexion;
}

// déconnexion de la BD
function disconnectDB($connexion)
{
    mysqli_close($connexion);
}

// nombre d'instances d'une table $nomTable
function countInstances($connexion, $nomTable)
{
    $requete = "SELECT COUNT(*) AS nb FROM $nomTable";
    $res = mysqli_query($connexion, $requete);
    if ($res != FALSE) {
        $row = mysqli_fetch_assoc($res);
        return $row['nb'];
    }
    return -1;  // valeur négative si erreur de requête (ex, $nomTable contient une valeur qui n'est pas une table)
}

// retourne les instances d'une table $nomTable
function getInstances($connexion, $nomTable)
{
    $requete = "SELECT * FROM $nomTable";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

// retourne les instances d'une requête $requete
function getFromRequest($connexion, $requete)
{
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

// retourne la colonne $col des instances d'une table $table
function selectDistinctColFromTable($connexion, $col, $table)
{
    $requete = "SELECT DISTINCT $col FROM $table ORDER BY $col ASC";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

// retourne les 2 colonnes $col des instances d'une table $table
function selectDistinctColsFromTable($connexion, $col, $col2, $table)
{
    $requete = "SELECT DISTINCT $col, $col2 FROM $table";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

function getVarietesByName($connexion, $nomVariete)
{
    $nomSerie = mysqli_real_escape_string($connexion, $nomVariete); // au cas où $nomVariete provient d'un formulaire
    $requete = "SELECT * FROM Dictionnaire WHERE codeVariété = '" . $nomVariete . "'";
    $res = mysqli_query($connexion, $requete);
    $variétés = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $variétés;
}

// insère une nouvelle variété nommée $nomVariete
function insertVariete($connexion, $nomVariete, $plante, $semencier, $descriptions, $commentaire, $annee, $adaptArgileux, $adaptLimoneux, $adaptSableux, $precocite, $plantation, $entretien, $recolte, $joursLevee, $perPlant, $perRec)
{
    //TODO
    //$requete = "INSERT INTO Variétés VALUES ('" . $nomVariete, $plante,$semencier, $descriptions, $commentaire, $annee, $adaptArgileux, $adaptLimoneux, $adaptSableux, $precocite, $plantation, $entretien, $recolte, $joursLevee, $perPlant, $perRec . "')";
    //$res = mysqli_query($connexion, $requete);
    //return $res;
}

function getRandomVariete($connexion)
{
    $requete = "SELECT CodeVariété, id, PlanteAssociée FROM `Dictionnaire` ORDER BY RAND() LIMIT 1";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function getRandomSauvage($connexion)
{
    $requete = "SELECT nomPS FROM `PlantesSauvages` ORDER BY RAND() LIMIT 1";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function getVarietesEtPlantes($connexion)
{
    $requete = "SELECT * FROM `Dictionnaire` d JOIN Variétés v ON d.id = v.idV";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function getNomVariete($connexion, $id)
{
    $requete = "SELECT * FROM `Dictionnaire` d JOIN Variétés v ON d.id = v.idV WHERE d.id = '$id'";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function getDetailsJardin($connexion, $id)
{
    $requete = "SELECT * FROM FairePartieDe NATURAL JOIN TypesJardins NATURAL JOIN Jardins WHERE idJ ='$id'";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function modifJardin($connexion, $id, $nom, $surface, $type)
{
    $requete = "UPDATE Jardins SET nomJ = '$nom', surface = '$surface' WHERE idJ = '$id'";
    $res[0] = mysqli_query($connexion, $requete);

    $requete = "UPDATE FairePartieDe SET idTJ = '$type' WHERE idJ = '$id'";
    $res[1] = mysqli_query($connexion, $requete);

    return $res;
}

function addJardin($connexion, $nom, $surface, $type)
{
    $requete = "INSERT INTO Jardins(nomJ, surface) VALUES ('$nom', '$surface')";
    $res[0] = mysqli_query($connexion, $requete);

    $requete = "INSERT INTO FairePartieDe(idJ, idTJ) VALUES((SELECT idJ FROM Jardins ORDER BY `Jardins`.`idJ` DESC LIMIT 1), $type)";
    $res[1] = mysqli_query($connexion, $requete);

    return $res;
}

function deleteJardin($connexion, $id)
{
    $requete = "DELETE FROM FairePartieDe WHERE idJ = '$id'";
    $res[0] = mysqli_query($connexion, $requete);

    $requete = "DELETE FROM Jardins WHERE idJ = '$id'";
    $res[1] = mysqli_query($connexion, $requete);
    return $res;
}

function getJardinsAndTypes($connexion)
{
    $requete = "SELECT * FROM FairePartieDe NATURAL JOIN TypesJardins NATURAL JOIN Jardins ORDER BY `FairePartieDe`.`idJ` ASC";
    $res = mysqli_query($connexion, $requete);
    return $res;
}

function getParcellesOfJardin($connexion, $id)
{
    $requete = "SELECT * FROM `Parcelles` WHERE idJ = '$id'";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function getNumberOfParcelles($connexion, $id)
{
    $requete = "SELECT COUNT(*) as nb FROM `Parcelles` WHERE idJ = '$id'";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function getNumberOfRangs($connexion, $latitudeP, $longitudeP)
{
    $latitudeP = addcslashes($latitudeP, "'\"");
    $longitudeP = addcslashes($longitudeP, "'\"");
    $requete = "SELECT COUNT(*) as nb FROM `Rangs` WHERE latitudeP = \"$latitudeP\" && longitudeP = \"$longitudeP\"";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function getNumberOfRecoltes($connexion, $latitudeP, $longitudeP)
{
    $latitudeP = addcslashes($latitudeP, "'\"");
    $longitudeP = addcslashes($longitudeP, "'\"");
    $requete = "SELECT COUNT(*) as nb FROM `Récoltes` WHERE latitudeP = \"$latitudeP\" && longitudeP = \"$longitudeP\"";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function getRecoltes($connexion, $latitudeP, $longitudeP)
{
    $latitudeP = addcslashes($latitudeP, "'\"");
    $longitudeP = addcslashes($longitudeP, "'\"");
    $requete = "SELECT * FROM `Récoltes` WHERE latitudeP = \"$latitudeP\" && longitudeP = \"$longitudeP\"";
    $res = mysqli_query($connexion, $requete);
    $instance = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instance;
}

function deleteRecolte($connexion, $id)
{
    $requete = "DELETE FROM Récoltes WHERE idRec = '$id'";
    $res[0] = mysqli_query($connexion, $requete);
    return $res;
}

function addRecolte($connexion, $qual, $quant, $comm, $date, $lat, $long)
{
    $requete = "INSERT INTO Récoltes(qualité, quantité, commentaireRec, dateRec, latitudeP, longitudeP) VALUE('$qual', '$quant','$comm', '$date', '$lat', '$long')";
    $res = mysqli_query($connexion, $requete);
    return $res;
}

function modifRecolte($connexion, $id, $qual, $quant, $comm, $date)
{
    $requete = "UPDATE Récoltes SET qualité = '$qual', quantité = '$quant', commentaireRec = '$comm', dateRec = '$date' WHERE idRec = '$id'";

    $res = mysqli_query($connexion, $requete);

    return $res;
}

function deleteParcelle($connexion, $lat, $long)
{
    deleteRangsOfParcelle($connexion, $lat, $long);
    $lat = addcslashes($lat, "'\"");
    $long = addcslashes($long, "'\"");

    $requete = "DELETE FROM Récoltes WHERE latitudeP = '$lat' && longitudeP = '$long'";
    $res[0] = mysqli_query($connexion, $requete);

    $requete = "DELETE FROM Parcelles WHERE latitudeP = '$lat' && longitudeP = '$long'";
    $res[1] = mysqli_query($connexion, $requete);

    return $res;
}

function deleteRangsOfParcelle($connexion, $lat, $long)
{
    $lat = addcslashes($lat, "'\"");
    $long = addcslashes($long, "'\"");

    $requete = "DELETE FROM Couvrir WHERE latitudeR IN (SELECT latitudeR FROM Rangs WHERE latitudeP = '$lat' && longitudeP = '$long') && longitudeR IN (SELECT longitudeR FROM Rangs WHERE latitudeP = '$lat' && longitudeP = '$long')";
    $res[0] = mysqli_query($connexion, $requete);

    $requete = "DELETE FROM Occuper WHERE latitudeR IN (SELECT latitudeR FROM Rangs WHERE latitudeP = '$lat' && longitudeP = '$long') && longitudeR IN (SELECT longitudeR FROM Rangs WHERE latitudeP = '$lat' && longitudeP = '$long')";
    $res[1] = mysqli_query($connexion, $requete);

    $requete = "DELETE FROM Rangs WHERE latitudeR IN (SELECT latitudeR FROM Rangs WHERE latitudeP = '$lat' && longitudeP = '$long') && longitudeR IN (SELECT longitudeR FROM Rangs WHERE latitudeP = '$lat' && longitudeP = '$long')";
    $res[2] = mysqli_query($connexion, $requete);

    return $res;
}

function modifParcelle($connexion, $lat, $long, $haut, $lar)
{
    $lat .= '\\"';
    $long .= '\\"';

    $requete = "UPDATE Parcelles SET hauteur = '$haut', largeur = '$lar' WHERE latitudeP = '$lat' && longitudeP = '$long'";

    $res = mysqli_query($connexion, $requete);

    return $res;
}

function addParcelle($connexion, $haut, $larg, $idJ)
{
    $lat = rand(0, 180) . "°," . rand(0, 60) . "\\'" . rand(0, 60) . "\\\"";
    $long = rand(0, 180) . "°," . rand(0, 60) . "\\'" . rand(0, 60) . "\\\"";

    $requete = "INSERT INTO Parcelles(latitudeP, longitudeP, hauteur, largeur, idJ) VALUES ('$lat', '$long', '$haut', '$larg', '$idJ')";

    $res = mysqli_query($connexion, $requete);

    return $res;
}

function getRangs($connexion, $lat, $long)
{
    $lat = addcslashes($lat, "'\"");
    $long = addcslashes($long, "'\"");
    $requete = "SELECT * FROM Rangs WHERE latitudeP = '$lat' && longitudeP = '$long' ORDER BY `Rangs`.`numéro` ASC";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

function getVarietesOnRang($connexion, $lat, $long)
{
    $lat = addcslashes($lat, "'\"");
    $long = addcslashes($long, "'\"");
    $requete = "SELECT codeVariété, typeO FROM `Dictionnaire` d JOIN Occuper v ON d.id = v.idV WHERE latitudeR = '$lat' && longitudeR = '$long'";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

function getPlantesSauvagesOnRang($connexion, $lat, $long)
{
    $lat = addcslashes($lat, "'\"");
    $long = addcslashes($long, "'\"");
    $requete = "SELECT nomPS, dateDebut, dateFin FROM Couvrir WHERE latitudeR = '$lat' && longitudeR = '$long'";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

function deleteSpecificRang($connexion, $lat, $long)
{
    $lat = addcslashes($lat, "'\"");
    $long = addcslashes($long, "'\"");

    $requete = "DELETE FROM Couvrir WHERE latitudeR = $lat && longitudeP = $long";
    $res[0] = mysqli_query($connexion, $requete);

    $requete = "DELETE FROM Occuper WHERE latitudeR = '$lat' && longitudeR = '$long'";
    $res[1] = mysqli_query($connexion, $requete);

    $requete = "DELETE FROM Rangs WHERE latitudeR = '$lat' && longitudeR = '$long'";
    $res[2] = mysqli_query($connexion, $requete);

    return $res;
}

function getStatsTypeOcc($connexion)
{
    $requete = "SELECT typeO, COUNT(*) as nb FROM Occuper GROUP BY typeO ORDER BY `nb`  DESC";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

function getStatsNbParcelles($connexion)
{
    $requete = "SELECT idJ, nomJ, COUNT(*) as nb FROM Parcelles NATURAL JOIN Jardins GROUP BY idJ ORDER BY `nb`  DESC LIMIT 5";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

function getPlusVariétés($connexion)
{
    $requete = "SELECT PlanteAssociée, COUNT(*) as nb FROM Dictionnaire GROUP BY PlanteAssociée ORDER BY `nb`  DESC LIMIT 5";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}