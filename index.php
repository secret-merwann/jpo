<?php 
require_once ('inc/header.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
	<meta name="description" content="Inscription à la JPO du Lycée Aristide Bergès, 2019">
  	<meta name="keywords" content="HTML,CSS,XML,JavaScript">
  	<meta name="author" content="Merwann Ayed">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
    <title>JPO 2019 - Lycée Arisitide Bergès</title>
   </head>

   <body>
   	<div id="menuHaut">
   		<div class="elementMenuHaut"></div>
   		<div class="elementMenuHaut"><a id="menustyle" href="index.php">Accueil</a></div>
		<div class="elementMenuHaut"><a id="menustyle" href="form.php">Formulaire d'inscription</a></div>
    <div class="elementMenuHaut"><a id="menustyle" href="bts.html">Le BTS</a></div>
   	</div>

   	 <?php if(isset($_SESSION['flash'])): ?>

    <div class="form-error">
        <span class="form-error-title">Erreur dans le formulaire</span><br />
<ul>
    <?php foreach ($_SESSION['flash'] as $type => $message): ?>
       <li>- <?= $message; ?></li>
       <a href="/ad">Cliquez ici pour réessayer</a>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
</ul>
</div>
<?php endif; ?>

      <h1>Journée portes ouvertes du Lycée Aristide Bergès</h1>
	
      <h2>Bienvenue</h2>

      Vous êtes sur la <strong>page d'accueil</strong> !<br /><br />

      Sur ce site vous pouvez :

	  <ul>
      	<li>Découvrir le BTS MCO au sein du Lycée Aristide Bergès.</li>
      	<li><a href="form.php">Vous inscrire</a> en tant que participant à la JPO (Journée Portes Ouvertes) dans la section BTS MCO.</li>
      </ul>

      <h3>Pourquoi m'inscrire ?</h3>

        <a href="https://www.parcoursup.fr/" target="_blank"><img src="img/parcoursup.png" width="20%" height="20%"></a><br />

		<p>Comme vous le savez, cette année, chaque élève s'inscrivant dans un établissement public est soumis à l'algorithme Parcoursup.<br />
		En vous inscrivant, vous attestez d'avoir porté un intérêt particulier envers le Lycée Aristide Bergès ce qui vous permettra de <strong>renforcer votre dossier</strong> et par conséquent <strong>vous faire gagner des places dans le classement de sélection Parcoursup pour votre vœu au Lycée Aristide Bergès.</strong></p>

      	<a href="form.php">Accéder au formulaire</a>

   </body>

</html>