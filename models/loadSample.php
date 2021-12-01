<?php
require("scriptCleanse.php");
require("scriptSetDatabase.php");
require("scriptFillDataset.php");

if(!$link = mysqli_connect("localhost","p1804157","Causal83Petite","p1804157")){
	print("<h3> Cannot connect to the database an error occurred </h3>");
	exit(1);
}


function genRandomToken($length = 10){
	$char = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$res = "";
	for($i = 0; $i < $length; $i++){
		$res .= $char[rand(0,strlen($char)-1)];
	}
	return $res;
}

function genCoords(){
	return rand(0,180)."°,".rand(0,60)."\\'".rand(0,60)."\\\"";
}

function genRequestLoad($table,$fields_fill,$data){
    global $result,$num_etu;
    $query = "INSERT INTO ".$num_etu.".".$table." (";
    for($i = 0; $i < count($fields_fill); $i++){
	$query = $query."`".$fields_fill[$i]."`";
	if($i < count($fields_fill)-1)
	   $query = $query.",";
    }
    $query = $query.") VALUES ";
	for($i = 0; $i < count($data); $i++){
		$query .= "(";
		for($j = 0; $j < count($fields_fill); $j++){
				if(strpbrk($data[$i][$j],"1234567890") !== false and
		   		   strpbrk($data[$i][$j],"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz °") === false){
				$query .= $data[$i][$j];
		}else{
			if(count($fields_fill) === 1){
				$query .= "\"".$data[$i]."\"";
			}else{
				$query .= "\"".$data[$i][$j]."\"";
			}
		}
		if($j < count($fields_fill)-1)
			$query .= ",";
		}
		$query .= "),";
	}
    $query = substr($query,0,-1);
	$query .= ";";
    return($query);
}

function set_lat_long($length = 49){
	$set = array(array());
	for($i = 0; $i < $length; $i++){
		for($j = 0; $j < 2; $j++){
			$set[$i][$j] = genCoords();
		}
	}
	return $set;
}

$table = "Jardins";
$fields_fill = array("nomJ", "surface");
$data = array();

for($i = 0; $i < 49 ; $i++){
	$data[$i][0] = "jardin_".$i;
	$data[$i][1] = rand(0,1500);

}
print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data),$link);
 
$table = "Parcelles";
$fields_fill = array("latitudeP","longitudeP","hauteur","idJ");
$data = set_lat_long(213);

for($i = 0; $i < 213 ; $i++){
	$data[$i][2] = rand(0,300);
	$data[$i][3] = rand(1,49);

}

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data),$link);
$table = "Rangs";
$fields_fill = array("latitudeR","longitudeR","état","latitudeP","longitudeP");
$data_R = set_lat_long(1256);
$state = array("Saint","Malade","Polué","Colonisé","En défrichement","En semence","En récolte","Défriché","Semé","Récolté");
for($i = 0; $i < 1256 ; $i++){
		$ran = rand(0,212);
		$data_R[$i][2] = $state[rand(0,3)];
		$data_R[$i][3] = $data[$ran][0];
		$data_R[$i][4] = $data[$ran][1];
}
print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data_R),$link);

// Récoltes: 	idRec, qualité, quantité, commentaireRec, dateRec, dateRec, latitudeP, longitudeP
$table = "Récoltes";
$fields_fill = array("qualité","quantité","dateRec","latitudeP","longitudeP");
$data_R = array();
for($i = 0; $i < 357; $i++){
	$ran = rand(0,212);
	$data_R[$i][0] = rand(0,10);
	$data_R[$i][1] = rand(0,10000);
	$data_R[$i][2] = date("Y-m-d H:m:s",rand(1269055681,1563055789));
	$data_R[$i][3] = $data[$ran][0];
	$data_R[$i][4] = $data[$ran][1];
		
}
print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data_R),$link);

$table = "PlantesSauvages";
$fields_fill = array("nomPS");
$data_P = array("Ortie",
				"trefle",
				"plantin",
				"pissenlit",
				"pâquerettes",
				"ronces",
				"lierre terrestre",
				"noisette de terre",
				"gaillet grateron",
				"l'oiseille sauvage",
				"berce commune",
				"ail des ours",
				" violette",
				"mélisse citroné",
				"houblon",
				"sillène");

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data_P),$link);

$table = "Menaces";
$fields_fill = array("desciptionMen");
$data_R = array("Innondation",
				"Secheresse",
				"Incendie",
				"Maladie",
				"Stérilité");

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data_R),$link);

// Semenciers: 	nomSem, siteWeb
$table = "Semenciers";
$names = array("David Hanma",
			   "Marion Evangélie",
			   "Suzanne Bichon",
			   "Mark Borneau");
$fields_fill = array("nomSem","siteWeb");
$data_R = array();
for($i=0;$i < 4 ; $i ++){
		$data_R[$i][0] = $names[$i];
		$data_R[$i][1] = $names[$i].".com";
}

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data_R),$link);


// TypesSol: 	nomTS
$table = "TypesSol";
$fields_fill = array("nomTS");
$data_R = array("Limoneux",
				"Sableux",
				"Argileux");

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data_R),$link);

// TypeJardin:	idTJ, nomType, hauteurMax, nomTS

$table = "TypeJardin";
$fields_fill = array("nomType");
$types = array("Verger","Potager","Ornements");
$data_T = array();
print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$types),$link);

$table = "Solutions";
$fields_fill = array("nomS");
$nom = array();
for($i = 0; $i < 5; $i++){
	$nom[$i] = "solution_".$i;
}

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$nom),$link);
$id = range(0,1256);
shuffle($id);
$id_r = array_slice($id,0,325);

$table = "Couvrir";
$fields_fill = array("numero","latitudeP","longitudeP","nomPS","dateDebut","dateFin");
$data_T = array();
for($i = 0; $i < 325; $i++){
	$ran = rand(0,212);
	$data_T[$i][0]= $id_r[$i];
	$data_T[$i][1]= $data[$ran][0];
	$data_T[$i][2]= $data[$ran][1];
	$data_T[$i][3]= $data_P[rand(0,15)];
	$data_T[$i][4]= date("Y-m-d H:m:s",rand(1269055681,1563055789));
	$data_T[$i][5]= date("Y-m-d H:m:s",rand(1269055681,1563055789));
}

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data_T),$link);

$result = $link->query("SELECT idV FROM Variétés");

$table = "EtreAdapté";
$id_V = array();
$adaptation_ratio = array();
$i = 0;
$c = 0;
while($row = $result->fetch_array(MYSQLI_BOTH)){
	for($j = 0; $j < 3; $j++){
		$adaptation_ratio[$i][0] = $row[0];
		$adaptation_ratio[$i][1] = $data_R[$j];
		$adaptation_ratio[$i][2] = round(1/rand(1,9),2);
		$i++;
	}
	$id_V[$c][0] = $row[0];
	$c++;
}
$fields_fill = array("idV","nomTS","ratioAdaptation");

executeRequest(genRequestLoad($table,$fields_fill,$adaptation_ratio),$link);

$table = "Occuper";
$fields_fill = array("idV","numero","latitudeP","longitudeP");
for($i = 0; $i < 8806 ; $i++){
	$ran = rand(0,212);
    	$id_V[$i][1] = rand(1,1256);
    	$id_V[$i][2] = $data[$ran][0];
    	$id_V[$i][3] = $data[$ran][1];
}

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$id_V),$link);

$idj = range(1,49);
shuffle($idj);
$data_V = array();
for($i = 0; $i < 49 ; $i++){
	$data_V[$i][0] = $idj[$i];
	$data_V[$i][1] = rand(1,3);
}

$table = "FairePartieDe";
$fields_fill = array("idJ","idTJ");

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data_V),$link);


$id = 1;
$table = "Vergers";
$t = array_values(array_filter($data_V,function($item) use($id){
	return ($item[1] == $id);
}));
$fields_fill = array("idJ","hauteurMax");
$data__ = array();
for($i = 0; $i < count($t); $i++){
	$data__[$i][0] = $t[$i][0];
	$data__[$i][1] = rand(0,30);
}
print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data__),$link);

$id = 2;
$table = "Potagers";
$t = array_values(array_filter($data_V,function($item) use($id){
	return ($item[1] == $id);
}));
$fields_fill = array("idJ","typeSol");
$data__ = array();
for($i = 0; $i < count($t); $i++){
	$data__[$i][0] = $t[$i][0];
	$data__[$i][1] = $data_R[rand(0,2)];
}

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data__),$link);

$id = 3;
$table = "Ornements";
$t = array_values(array_filter($data_V,function($item) use($id){
	return ($item[1] == $id);
}));
$fields_fill = array("idJ");
$data__ = array();
for($i = 0; $i < count($t); $i++){
	$data__[$i][0] = $t[$i][0];
}

print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$data__),$link);
$table = "Produire";
$fields_fill = array("nomSem","idV","version");
$prod_d = array();
$versions = array("Biologique","Conventionelle");
for($i = 0; $i < 8806 ; $i++){
	$prod_d[$i][0] = $names[rand(0,3)];
	$prod_d[$i][1] = $id_V[$i][0];
	$prod_d[$i][2] = $versions[rand(0,1)];
}
print("executing request for ".$table."  <br>");
executeRequest(genRequestLoad($table,$fields_fill,$prod_d),$link);


