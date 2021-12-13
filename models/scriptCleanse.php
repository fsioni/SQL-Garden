<?php

$connection = mysqli_connect("localhost", "p1804157", "Causal83Petite", "p1804157");
$connection->query('SET foreign_key_checks = 0');
if ($result = $connection->query("SHOW TABLES")) {
   while ($row = $result->fetch_array(MYSQLI_NUM)) {
      $connection->query('DROP TABLE IF EXISTS ' . $row[0]);
   }
}

$connection->query('SET foreign_key_checks = 1');
$connection->close();