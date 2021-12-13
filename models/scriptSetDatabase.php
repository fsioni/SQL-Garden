<?php

$connection = mysqli_connect("localhost", "p1804157", "Causal83Petite", "p1804157");
if (mysqli_connect_errno()) {
	printf("Échec de la connexion : %s\n", mysqli_connect_error());
	exit();
}

$sqlScript = file('../create.sql');
foreach ($sqlScript as $line) {

	$startWith = substr(trim($line), 0, 2);
	$endWith = substr(trim($line), -1, 1);

	if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
		continue;
	}

	$query = $query . $line;
	if ($endWith == ';') {
		mysqli_query($connection, $query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query . '</b></div>');
		$query = '';
	}
}