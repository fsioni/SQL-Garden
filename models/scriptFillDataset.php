<?php
require_once("connectDb.php");
$num_etu = "p1804157";

function fillIndexer($table, $fields_fill, $fields_fetch)
{
	global $result, $num_etu;
	$query = "INSERT INTO " . $num_etu . "." . $table . " (";
	for ($i = 0; $i < count($fields_fill); $i++) {
		$query = $query . "`" . $fields_fill[$i] . "`";
		if ($i < count($fields_fill) - 1)
			$query = $query . ",";
	}
	$query = $query . ") VALUES ";
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$query = $query . "(";
		for ($i = 0; $i < count($fields_fetch); $i++) {
			if ($i === 0) {
				$query = $query . "\"" . sha1($row[0] . $row[1]) . "\",";
			}
			if ($row[$fields_fetch[$i]] === "") {
				$query = $query . "DEFAULT";
			} elseif (
				strpbrk($row[$fields_fetch[$i]], "1234567890") !== false and
				strpbrk($row[$fields_fetch[$i]], "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ") === false
			) {
				$query = $query . $row[$fields_fetch[$i]];
			} else {
				$query = $query . "\"" . $row[$fields_fetch[$i]] . "\"";
			}
			if ($i < count($fields_fetch) - 1)
				$query = $query . ",";
		}
		$query = $query . "),";
	}
	$query = substr($query, 0, -1);
	$query = $query . ";";
	return ($query);
}

// provides a query as a string, based on the fiields to fill in the table and the
// fieldy to fetch from the result set
//
// function genrequest
// @param: table, fields_fill, fields_fetch
// @return: string(query)

function genrequest($table, $fields_fill, $fields_fetch)
{
	global $result, $num_etu;
	$query = "insert into " . $num_etu . "." . $table . " (";
	for ($i = 0; $i < count($fields_fill); $i++) {
		$query = $query . "`" . $fields_fill[$i] . "`";
		if ($i < count($fields_fill) - 1)
			$query = $query . ",";
	}
	$query .= ") values ";
	while ($row = $result->fetch_array(MYSQLI_BOTH)) {
		$query .= "(";
		for ($i = 0; $i < count($fields_fetch); $i++) {
			if ($row[$fields_fetch[$i]] === "") {
				$query .= "default";
			} else {
				$query .= "\"" . $row[$fields_fetch[$i]] . "\"";
			}
			if ($i < count($fields_fetch) - 1)
				$query .= ",";
		}
		$query .= "),";
	}
	$query = substr($query, 0, -1);
	// todo fix this value so ^ that it wont mess up the final query !!
	$query = $query . ";";

	return ($query);
}

function executerequest($query, $link)
{
	if ($link->query($query) === false) {
		print("error");
		print($link->error);
	}
}

// Plantes filling with fields 0,1,2,3 from result set into 
// $fields_fill table's fields

$table = "Plantes";
$fields_fill = array("nomP", "nomLatinP", "typeP", "sousType");
$fields_fetch = array(0, 1, 2, 3);

$result = $link->query("SELECT nomEspèce, nomEspèceLatin, type, sousType FROM DonneesFournies GROUP BY(nomEspèce)");
print("<h3> Found  " . $result->num_rows . " tuples corresponding to your query</h3>");
executeRequest(genRequest($table, $fields_fill, $fields_fetch), $link);
$result->close();


// dictionnary filling with fields 0,1,2 from result set into 
// $fields_fill table's fields

$table = "Dictionnaire";
$fields_fill = array("id", "codeVariété", "PlanteAssociée");
$fields_fetch = array(0, 1);

$result = $link->query("select codevariété, nomespèce, nomespècelatin from DonneesFournies ");
print("<h3> found  " . $result->num_rows . " tuples corresponding to your query</h3>");
executeRequest(fillIndexer($table, $fields_fill, $fields_fetch), $link);
$result->close();



// Varitétés filling with fields 6,4,3,2 from result set into 
// $fields_fill table's fields

$table = "Variétés";
$fields_fill = array("idV", "annéeV", "précocité", "labelPrécocité", "commentaireGen");
$fields_fetch = array(6, 4, 5, 3);

$result = $link->query("SELECT *  FROM DonneesFournies");
print("<h3> Found  " . $result->num_rows . " tuples corresponding to your query</h3>");
executeRequest(fillIndexer($table, $fields_fill, $fields_fetch), $link);
$result->close();
$link->close();