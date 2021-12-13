<?php
$title = 'Afficher les variétés';

$varietes = getFromRequest($connexion, "SELECT * FROM Variétés NATURAL JOIN 
					EtreAdapté NATURAL JOIN 
					Descriptions NATURAL JOIN
					Produire as P JOIN Dictionnaire as D on D.id = P.idV JOIN
					Plantes as Pl on D.PlanteAssociée = Pl.nomP");

$types = getFromRequest($connexion, "SELECT DISTINCT typeP FROM Plantes");

$plantes = getFromRequest($connexion, "SELECT *  from Plantes");