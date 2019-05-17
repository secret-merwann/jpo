<?php 
require_once ('../inc/header.php');
require_once ('../inc/functions.php');
require_once ('../inc/log-my-db.php');

$errors = array();


if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){

	$req = $pdomydb->prepare('SELECT * FROM visiteur WHERE (visLoginAdmin = :username) ');
	$req->execute(['username' => $_POST['username']]);

	$user = $req->fetch();

	if(password_verify($_POST['password'], $user->visPasswordAdmin)) {

		session_start();
		$_SESSION['auth'] = $user;
		header("Refresh: 0; url=index.php");
		exit();

	} else {
		$_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect';
		header('Location: ../index.php');

	}
}
if(isset($_SESSION['auth'])) {
		header("Location: rg.php");
		exit();

		}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Inscription à la JPO du Lycée Aristide Bergès, 2019">
  	<meta name="keywords" content="HTML,CSS,XML,JavaScript">
  	<meta name="author" content="Merwann Ayed">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../style.css">
	<title>JPO 2019 Aristide Bergès - Inscription</title>
</head>
<body>

<div id="menuHaut">
      <div class="elementMenuHaut"></div>
      <div class="elementMenuHaut"><a id="menustyle" href="../index.php">Accueil</a></div>
    <div class="elementMenuHaut"><a id="menustyle" href="../form.php">Formulaire d'inscription</a></div>
    <div class="elementMenuHaut"><a id="menustyle" href="../bts.html">Le BTS</a></div>
    </div>

   

<div id="sectionTitre"><span class="titreForm">Connexion à l'interface d'administration</span></div>
<div id="formulaire">
<form action="" method="POST">
	
    <div id="label0">
    <label for="username">Nom d'utilisateur :<span class="champ-obligatoire">*</span> : </label>
    <input type="text" name="username" placeholder="Nom d'utilisateur" maxlength="100" required /><br /><br />
	</div>

	<div id="label1">
    <label for="mdp">Mot de passe :<span class="champ-obligatoire">*</span> : </label>
    <input type="password" name="password" placeholder="Mot de passe" maxlength="256" required/><br /><br />
	</div>

    <br /><button class="button-submit" type="submit"><span>Connexion</span></button><br /><br />
    <span class="champ-obligatoire-tip">* : Champs obligatoires</span>
</form>
</div>
</body>
</html>