<?php
require 'log-db.php';
require 'log-my-db.php';

	$nRows = $pdo->query('SELECT COUNT(*) FROM visiteur WHERE visSection = 2')->fetchColumn();

	$req = $pdomydb->prepare('SELECT * FROM villes_france_free WHERE ville_departement IN ("01", "73", "03", "63", "15", "43", "42", "69", "74", "38", "26", "07")');

    $req->execute();

    $villes = $req->fetchAll();

if(empty($villes)){
    die("Pas de données dans la DB");
}

$req = $pdomydb->prepare('SELECT DISTINCT LEFT(ville_code_postal, 5) AS codepostal FROM villes_france_free WHERE ville_departement IN ("01", "73", "03", "63", "15", "43", "42", "69", "74", "38", "26", "07")');

    $req->execute();

    $cps = $req->fetchAll();

if(empty($cps)){
    die("Pas de données dans la DB");
}
