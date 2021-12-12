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
    return $res;
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
    $requete = "SELECT * FROM Dictionnaire WHERE codeVariété LIKE '" . $nomVariete . "'";
    $res = mysqli_query($connexion, $requete);
    $variétés = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $variétés;
}

// insère une nouvelle variété nommée $nomVariete
function insertVariete($connexion, $data_form)
{
    $id_V = sha1($data_form["nomVariete"] . $data_form["plante"]);

    $query_dic = "INSERT INTO Dictionnaire VALUES ('" . $id_V . "','" .
        $data_form["nomVariete"] . "','" . $data_form["plante"] . "')";

    $query_var = "INSERT INTO Variétés VALUES ('" . $id_V . "'," . $data_form["année"] .
        ",'" . $data_form["precocite"] .
        "','" . $data_form["labelPrecocite"] .
        "','" . $data_form["plantation"] .
        "','" . $data_form["entretien"] .
        "','" . $data_form["recolte"] .
        "'," . $data_form["joursLevee"] .
        ",'" . $data_form["perPlant"] .
        "','" . $data_form["perRec"] .
        "','" . $data_form["commentaire"] .
        "')";
    $query_prod = "INSERT INTO Produire VALUES ('" . $data_form["semencier"] . "','" . $id_V . "','" . $data_form["version"] . "')";

    $res_dic = mysqli_query($connexion, $query_dic);
    $res_var = mysqli_query($connexion, $query_var);
    $res_prod = mysqli_query($connexion, $query_prod);

    $res_desc = 1;
    foreach ($data_form["descriptions"] as $des) {
        $query_desc = "INSERT INTO Descriptions VALUES ('" . $des . "','" . $id_V . "')";
        $res_desc = $res_desc && mysqli_query($connexion, $query_desc);
    }
    return ($res_dic && $res_var && $res_prod && $res_desc);
}

function genCoords()
{
    return rand(0, 180) . "°," . rand(0, 60) . "\\'" . rand(0, 60) . "\\\"";
}

function checkExists($connexion, $nomVariete, $nomPlante)
{
    $requete = "SELECT * FROM Dictionnaire WHERE id LIKE '" . sha1($nomVariete . $nomPlante) . "'";
    $res = mysqli_query($connexion, $requete);
    if ($res->num_rows > 0) {
        return true;
    }
    return false;
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

    $coords['lat'] = $lat;
    $coords['long'] = $long;
    return $coords;
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

function GetJardinNameWithID($connexion, $idJ)
{
    $requete = "SELECT nomJ FROM Jardins WHERE idJ = '$idJ'";
    $res = mysqli_query($connexion, $requete);
    $instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $instances;
}

function addRang($connexion, $numero, $latR, $longR, $etat, $latP, $longP)
{
    $requete = "INSERT INTO Rangs(numéro, latitudeR, longitudeR, état, latitudeP, longitudeP) VALUES ('$numero', '$latR', '$longR', '$etat', '$latP', '$longP')";
    $res = mysqli_query($connexion, $requete);
    return $res;
}

function addPlanteSauvageOnRang($connexion, $latR, $longR, $nomPS, $dateDebut, $dateFin = "NULL")
{
    $requete = "INSERT INTO Couvrir(latitudeR, longitudeR, nomPS, dateDebut, dateFin) VALUES ('$latR', '$longR', '$nomPS', '$dateDebut', $dateFin)";
    $res = mysqli_query($connexion, $requete);
    return $res;
}

function addPlanteOnRang($connexion, $idV, $latR, $longR, $typeO)
{
    $requete = "INSERT INTO Occuper(idV, latitudeR, longitudeR, typeO) VALUES ('$idV', '$latR', '$longR', '$typeO')";
    echo $requete . '<br>';
    $res = mysqli_query($connexion, $requete);
    return $res;
}

function executerequest($query, $link)
{
    if ($link->query($query) === false) {
        print("error");
        print($link->error);
    }
}

function set_lat_long($x, $length = 49)
{
    $set = array(array());
    for ($i = 0; $i < $length; $i++) {
        for ($j = $x; $j < $x + 2; $j++) {
            $set[$i][$j] = genCoords();
        }
    }
    return $set;
}

function genRequestLoad($table, $fields_fill, $data)
{
    global $result, $num_etu;
    $query = "INSERT INTO " . $num_etu . "." . $table . " (";
    for ($i = 0; $i < count($fields_fill); $i++) {
        $query = $query . "`" . $fields_fill[$i] . "`";
        if ($i < count($fields_fill) - 1)
            $query = $query . ",";
    }
    $query = $query . ") VALUES ";
    for ($i = 0; $i < count($data); $i++) {
        $query .= "(";
        for ($j = 0; $j < count($fields_fill); $j++) {
            if (
                strpbrk($data[$i][$j], "1234567890") !== false and
                strpbrk($data[$i][$j], "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz °") === false
            ) {
                $query .= $data[$i][$j];
            } else {
                if (count($fields_fill) === 1) {
                    $query .= "\"" . $data[$i] . "\"";
                } else {
                    $query .= "\"" . $data[$i][$j] . "\"";
                }
            }
            if ($j < count($fields_fill) - 1)
                $query .= ",";
        }
        $query .= "),";
    }
    $query = substr($query, 0, -1);
    $query .= ";";
    return ($query);
}