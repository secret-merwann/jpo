<?php
require_once ('../inc/header.php');
require_once ('../inc/functions.php');
require_once ('../inc/log-db.php');

logged_only();

$req = $pdo->prepare('SELECT * FROM visiteur LEFT JOIN section ON visiteur.visSection = section.secId ORDER BY visSection, visNom');

$nSIO = $pdo->query('SELECT COUNT(*) FROM visiteur WHERE visSection = 1')->fetchColumn();
$nMUC = $pdo->query('SELECT COUNT(*) FROM visiteur WHERE visSection = 2')->fetchColumn();
$nCOM = $pdo->query('SELECT COUNT(*) FROM visiteur WHERE visSection = 3')->fetchColumn();
$nCG = $pdo->query('SELECT COUNT(*) FROM visiteur WHERE visSection = 4')->fetchColumn();


$req->execute();

$inscrits = $req->fetchAll();

if(empty($inscrits)){
	echo ("Pas de données dans la DB");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="table.css">
	<title>JPO 2019</title>
</head>
<body>

<h1>Liste des personnes participantes à la JPO 2019</h1>

<strong><?= $nSIO; ?></strong> inscrits en SIO<br />
<strong><?= $nMUC; ?></strong> inscrits en MCO<br />
<strong><?= $nCOM; ?></strong> inscrits en COM<br />
<strong><?= $nCG; ?></strong> inscrits en CG<br />
<br />
<table>
	<tr>
		<th>Numéro de l'inscrit</th>
		<th>Nom</th>
		<th>Prénom</th>
		<th>Numéro de téléphone</th>
		<th>Adresse e-mail</th>
		<th>Sexe</th>
		<th>Adresse postale</th>
		<th>Code postal</th>
		<th>Ville</th>
		<th>Date de naissance</th>
		<th>Section actuelle</th>
		<th>Établissement actuel</th>
		<th>Date et heure de l'inscription</th>
		<th>Binome</th>
		<th>Section</th>
	</tr>

<?php foreach ($inscrits as $inscrit): ?>
<tr>
	<td><?= $inscrit->visNo ?></td>
	<td><?= $inscrit->visNom ?></td>
	<td><?= $inscrit->visPrenom ?></td>
	<td><?= $inscrit->visTelephone ?></td>
	<td><?= $inscrit->visCourrier ?></td>
	<td><?= $inscrit->visSexeM ?></td>
	<td><?= $inscrit->visAdresse ?></td>
	<td><?= $inscrit->visCodePostal ?></td>
	<td><?= $inscrit->visVille ?></td>
	<td><?= $inscrit->visDateNais ?></td>
	<td><?= $inscrit->visSectionActuelle ?></td>
	<td><?= $inscrit->visEtablissementActuel ?></td>
	<td><?= $inscrit->visDateHeure ?></td>
	<td><?= $inscrit->visBinome ?></td>
	<td><?= $inscrit->secNom ?></td>
</tr>
<?php endforeach; ?>
</table><br />

<a href="logout.php">Déconnexion</a>
</body>
</html>