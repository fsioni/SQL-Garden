
<?php

//Variété           :: nomEspeceLatin, annéeV, codePrécocité, 
//		       commentaire 
//
//Subir             :: nomEspèceLatin 						=> (2)
//Produire          :: nomEspece 						=> (1)
//plantesSauvages   :: nomEspece, nomEspeceLatin, type, sousType 		=> (1,2,7,8)
//occuper           :: (codeVariété,nomEspece) 					=> ((0,1))
//etreSourceDe      :: nomEspeceLatin 						=> (2)
//etreAdapté        :: (codevariété, nomEspece), type 				=> ((0,1),7)
//description       :: (codeVariété, nomEspece) 				=>



// numéro etudiant ::
$num_etu = "p1804157";

// provides a query as a string, based on the fiields to fill in the table and the
// fields to fetch from the result set, and also calculates the sha1 of the indexed
// table $table
//
// function fillIndexer
// @param: table, fields_fill, fields_fetch
// @return: string(query)

function fillIndexer($table,$fields_fill,$fields_fetch){
    global $result,$num_etu;
    $query = "INSERT INTO ".$num_etu.".".$table." (";
    for($i = 0; $i < count($fields_fill); $i++){
	$query = $query."`".$fields_fill[$i]."`";
	if($i < count($fields_fill)-1)
	   $query = $query.",";
    }
    $query = $query.") VALUES ";
   while($row = $result->fetch_array(MYSQLI_BOTH)){
    $query = $query."(";
    for($i = 0; $i < count($fields_fetch); $i++){
	if($i === 0){
	   $query = $query."\"".sha1($row[0].$row[1])."\",";
 	}
	if($row[$fields_fetch[$i]] === ""){
	    $query = $query."DEFAULT";
	}elseif(strpbrk($row[$fields_fetch[$i]],"1234567890") !== false and
		strpbrk($row[$fields_fetch[$i]],"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ") === false){
	    $query = $query.$row[$fields_fetch[$i]];
	}else{
	    $query = $query."\"".$row[$fields_fetch[$i]]."\"";
	}
		if($i < count($fields_fetch)-1)
	   $query = $query.",";
    }
    $query = $query."),";
   }
    $query = substr($query,0,-1);
    // TODO fix this value so ^ that it wont mess up the final query !!
    $query = $query.";";
    
    return($query);
}

// provides a query as a string, based on the fiields to fill in the table and the
// fields to fetch from the result set
//
// function genRequest
// @param: table, fields_fill, fields_fetch
// @return: string(query)

function genRequest($table,$fields_fill,$fields_fetch){
    global $result,$num_etu;
    $query = "INSERT INTO ".$num_etu.".".$table." (";
    for($i = 0; $i < count($fields_fill); $i++){
	$query = $query."`".$fields_fill[$i]."`";
	if($i < count($fields_fill)-1)
	   $query = $query.",";
    }
    $query .=") VALUES ";
   while($row = $result->fetch_array(MYSQLI_BOTH)){
    $query .="(";
    for($i = 0; $i < count($fields_fetch); $i++){
	if($row[$fields_fetch[$i]] === ""){
	    $query .= "DEFAULT";
	}else{
	    $query .="\"".$row[$fields_fetch[$i]]."\"";
	}
		if($i < count($fields_fetch)-1)
		   $query .= ",";
    }
    $query .="),";
   }
    $query = substr($query,0,-1);
    // TODO fix this value so ^ that it wont mess up the final query !!
    $query = $query.";";
    
    return($query);
}

function executeRequest($query,$link){
    if($link->query($query) === false){
	 print("error");
	 print($link->error);
    }
}


if(!$link = mysqli_connect("localhost","p1804157","Causal83Petite","dataset") ){
	print("<h3> Cannot connect to the database, error :: ".$link->error);
	exit(1);
}
// Dictionnary filling with fields 0,1,2 from result Set into 
// $fields_fill table's fields

$table = "Dictionnaire";
$fields_fill = array("id","codeVariété","nomEspèce","nomEspèceLatin");
$fields_fetch = array(0,1,2);

$result = $link->query("SELECT codeVariété, nomEspèce, nomEspèceLatin FROM DonneesFournies ");
print("<h3> Found  ".$result->num_rows." tuples corresponding to your query</h3>");
executeRequest(fillIndexer($table,$fields_fill,$fields_fetch),$link);
$result->close();


// Plantes filling with fields 0,1,2,3 from result set into 
// $fields_fill table's fields

$table = "Plantes";
$fields_fill = array("nomP","nomLatinP","typeP","sousType");
$fields_fetch = array(0,1,2,3);

$result = $link->query("SELECT nomEspèce, nomEspèceLatin, type, sousType FROM DonneesFournies GROUP BY(nomEspèce)");
print("<h3> Found  ".$result->num_rows." tuples corresponding to your query</h3>");
executeRequest(genRequest($table,$fields_fill,$fields_fetch),$link);
$result->close();

// Varitétés filling with fields 6,4,3,2 from result set into 
// $fields_fill table's fields

$table = "Variétés";
$fields_fill = array("idV","annéeV","précocité","labelPrécocité","commentaireGen");
$fields_fetch = array(6,4,5,3);

$result = $link->query("SELECT *  FROM DonneesFournies");
print("<h3> Found  ".$result->num_rows." tuples corresponding to your query</h3>");
executeRequest(fillIndexer($table,$fields_fill,$fields_fetch),$link);
$result->close();
?>
