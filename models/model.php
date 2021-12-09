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
    $requete = "SELECT CodeVariété, id, nomEspèce FROM `Dictionnaire` ORDER BY RAND() LIMIT 1";
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
    $requete = "SELECT * FROM FairePartieDe NATURAL JOIN TypeJardin NATURAL JOIN Jardins WHERE idJ ='$id'";
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

function ajoutJardin($connexion, $nom, $surface, $type)
{
    $requete = "INSERT INTO Jardins(nomJ, surface) VALUES ('$nom', '$surface')";
    $res[0] = mysqli_query($connexion, $requete);

    $requete = "INSERT INTO FairePartieDe(idJ, idTJ) VALUES((SELECT idJ FROM Jardins ORDER BY `Jardins`.`idJ` DESC LIMIT 1), $type)";
    $res[1] = mysqli_query($connexion, $requete);

    return $res;
}

function deleteJardin($connexion, $id)
{
    //TODO : supprimer les rangs et parcelles associées

    $requete = "DELETE FROM FairePartieDe WHERE idJ = '$id'";
    $res[0] = mysqli_query($connexion, $requete);

    $requete = "DELETE FROM Jardins WHERE idJ = '$id'";
    $res[1] = mysqli_query($connexion, $requete);
    return $res;
}

function getJardinsAndTypes($connexion)
{
    $requete = "SELECT * FROM FairePartieDe NATURAL JOIN TypeJardin NATURAL JOIN Jardins ORDER BY `FairePartieDe`.`idJ` ASC";
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
