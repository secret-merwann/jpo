<?php
require_once 'inc/req.php';
require_once 'inc/functions.php';

if(empty(!$_POST)){

    $errors = array();
    $valid = array();

    if(empty($_POST['prenom']) || !preg_match('/^[a-zA-Z-\s]+$/', $_POST['prenom']) || strlen($_POST['prenom']) > 30) {
        $errors['prenom'] = "Le prénom saisi n'est pas valide. (Pas de caractères spéciaux (é, à, ù...), pas de numéros, espaces et tirets autorisés)";
    }

    if(empty($_POST['nomdefamille']) || !preg_match('/^[a-zA-Z-\s]+$/', $_POST['nomdefamille']) || strlen($_POST['nomdefamille']) > 30) {
        $errors['nomdefamille'] = "Le nom de famille saisi n'est pas valide. (Pas de caractères spéciaux (é, à, ù...), pas de numéros, espaces et tirets autorisés)";
    }

    if(empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) || strlen($_POST['mail']) > 100){
        $errors['mail'] = "L'adresse e-mail saisie n'est pas valide.";
    } else {
        $req = $pdo->prepare('SELECT visNo FROM visiteur WHERE visCourrier = ? AND visSection = 2');
        $req->execute([$_POST['mail']]);
        $mail = $req->fetch();
        if($mail){
            $errors['mail'] = "Cette adresse mail est déjà utilisée.";
        }
    }

    if(empty($_POST['sexe'])){
        $errors['sexe'] = "Veuillez saisir votre sexe.";
    }

    if(empty($_POST['adressepostale']) || strlen($_POST['adressepostale']) > 256){
        $errors['adressepostale'] = "L'adresse postale saisie n'est pas valide. ";
    } else {
        $req = $pdo->prepare('SELECT visNo FROM visiteur WHERE visAdresse = ? AND visSection = 2');
        $req->execute([$_POST['adressepostale']]);
        $adressefound = $req->fetch();
        if($adressefound){
            $errors['adressepostale'] = "Cette adresse postale existe déjà.";
        }
    }

    if(empty($_POST['codepostal']) || !preg_match('/^[0-9]+$/', $_POST['codepostal']) || strlen($_POST['codepostal']) != 5) {
        $errors['codepostal'] = "Le code postal saisi n'est pas valide.";
    }

    if (!preg_match('/^[0-9]+$/', $_POST['numportable']) || strlen($_POST['numportable']) != 10) {
        $errors['numportable'] = "Le numéro de portable saisi n'est pas valide.";
    }else{
    	$req = $pdo->prepare('SELECT visNo FROM visiteur WHERE visTelephone = ? AND visSection = 2');
        $req->execute([$_POST['numportable']]);
        $telephone = $req->fetch();
        if($telephone){
            $errors['numportable'] = "Ce numéro de téléphone est déjà utilisé.";
        }
    }

    if(empty($_POST['ville']) || strlen($_POST['ville']) > 30){
        $errors['ville'] = "La ville saisie n'est pas valide. ";
    }

    if(empty($_POST['datenaissance']) || validateDate($_POST['datenaissance'], 'Y-m-d') !== TRUE || strlen($_POST['datenaissance']) != 10){
        $errors['datenaissance'] = "Veuillez saisir une date de naissance valide.";
    }

    if(empty($_POST['sectionactu']) || strlen($_POST['sectionactu']) > 100){
        $errors['sectionactu'] = "Veuillez saisir votre section actuelle.";
    }

    if(strlen($_POST['etablissementactu']) > 30){
        $errors['etablissementactu'] = "La taille du champ \"établissement actuel\" ne peut excéder 30 caractères.";
    }


    if (empty($errors)){
        $req = $pdo->prepare("INSERT INTO visiteur SET visPrenom = ?, visNom = ?, visCourrier = ?, visSexeM = ?, visAdresse = ?, visCodePostal = ?, visVille = ?, visTelephone = ?, visDateNais = ?, visSectionActuelle = ?, visEtablissementActuel = ?, visBinome = ?, visIP = ?, visDateHeure = NOW(), visSection = ?");


        if($_POST['sexe'] == "homme"){
        	$sexe = 0;
        }else if($_POST['sexe'] == "femme"){
        	$sexe = 1;
        }else if($_POST['sexe'] == "autre"){
        	$sexe = 2;
        }

        $req->execute([ucfirst($_POST['prenom']), strtoupper($_POST['nomdefamille']), $_POST['mail'], $sexe, $_POST['adressepostale'], $_POST['codepostal'], $_POST['ville'], $_POST['numportable'], $_POST['datenaissance'], $_POST['sectionactu'], $_POST['etablissementactu'], "Matteo & Merwann", $_SERVER['REMOTE_ADDR'], "2"]);

        // Pour dire que l'inscription s'est bien passée
        $valid['yes'] = "Votre inscription a bien été prise en compte, merci de votre participation.";

        // Une fois validé, on vide le contenu du formulaire
        unset($_POST);

    
    }
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
	<link rel="stylesheet" href="style.css">
	<title>JPO 2019 Aristide Bergès - Inscription</title>
</head>
<body>

<div id="menuHaut">
      <div class="elementMenuHaut"></div>
      <div class="elementMenuHaut"><a id="menustyle" href="index.php">Accueil</a></div>
    <div class="elementMenuHaut"><a id="menustyle" href="form.php">Formulaire d'inscription</a></div>
    <div class="elementMenuHaut"><a id="menustyle" href="bts.html">Le BTS</a></div>
    </div>

<?php if (!empty($errors)): ?>

    <div class="form-error">
        <span class="form-error-title">Erreur dans le formulaire</span><br />
<ul>
    <?php foreach ($errors as $error): ?>
       <li>- <?= $error; ?></li>
    <?php endforeach; ?>
</ul>
</div>
<?php endif; ?>

<?php if (!empty($valid)): ?>

    <div class="form-valid">
        <span class="form-valid-title">Votre inscription a bien été prise en compte.</span><br />
<ul>
    <?php foreach ($valid as $valids): ?>
       <li>- <?= $valids; ?></li>
    <?php endforeach; ?>
</ul>
</div>
<?php endif; ?>


<div id="sectionTitre"><span class="titreForm">Attestation de participation à la JPO du Lycée Aristide Bergès, 2019</span></div>

<div id="formulaire">
<form action="" method="POST">
	
    <div id="label0"><label for="nomdefamille"><span class="texte-form">Votre nom de famille :</span><span class="champ-obligatoire">*</span></label>
    <input type="text" class="center-block" name="nomdefamille" value="<?php if (isset($_POST['nomdefamille'])){echo $_POST['nomdefamille'];} ?>" placeholder="Nom de famille (Pas de caractères spéciaux)" maxlength="100" pattern="^[a-zA-Z-\s]+$" required /><br /><br /></div>

    <div id="label1"><label for="prenom"><span class="texte-form">Votre prénom :</span><span class="champ-obligatoire">*</span></label>
    <input type="text" class="center-block" name="prenom" value="<?php if (isset($_POST['prenom'])){echo $_POST['prenom'];} ?>" placeholder="Prénom (Pas de caractères spéciaux)" maxlength="30" pattern="^[a-zA-Z-\s]+$" required /><br /><br /></div>
	
	<div id="label0"><label for="email"><span class="texte-form">Votre adresse e-mail :</span><span class="champ-obligatoire">*</span></label>
    <input type="text" class="center-block" name="mail" placeholder="Adresse e-mail" value="<?php if (isset($_POST['mail'])){echo $_POST['mail'];} ?>" maxlength="100" required /><br /><br /></div>

    <div id="label1"><label for="adresse"><span class="texte-form">Votre adresse postale: </span><span class="champ-obligatoire">*</span></label>
    <input type="text" class="center-block" name="adressepostale" value="<?php if (isset($_POST['adressepostale'])){echo $_POST['adressepostale'];} ?>" placeholder="Adresse postale" maxlength="256" required /><br /><br /></div>

	<div id="label0"><label for="ville"><span class="texte-form">Votre ville :</span><span class="champ-obligatoire">*</span></label>
    <input list="ville" name="ville" placeholder="Votre ville" value="<?php if (isset($_POST['ville'])){echo $_POST['ville'];} ?>">
  <datalist id="ville" name="ville">
    <?php foreach ($villes as $ville): ?>
    <option value="<?= $ville->ville_nom_reel ?>"><br />
    <?php endforeach; ?>
  </datalist><br /><br /></div>

    <div id="label1"><label for="codepostal"><span class="texte-form">Votre code postal :</span><span class="champ-obligatoire">*</span></label>
    <input list="codepostal"name="codepostal" placeholder="Votre code postal" pattern="[0-9]{5}" maxlength="5" value="<?php if (isset($_POST['codepostal'])){echo $_POST['codepostal'];} ?>">
  <datalist id="codepostal" name="codepostal" id="codepostal">
    <?php foreach ($cps as $cp): ?>
    <option value="<?= $cp->codepostal ?>"><br />
    <?php endforeach; ?>
  </datalist><br /><br /></div>

     <div id="label0"><label for="telephone"><span class="texte-form">Votre numéro de téléphone : </span><span class="champ-obligatoire">*</span></label>
	 <input type="tel" class="center-block" pattern="[0-9]{10}" name="numportable" value="<?php if (isset($_POST['numportable'])){echo $_POST['numportable'];} ?>" placeholder="Numéro de téléphone (exemple : 06XXXXXXXX)" maxlength="10" required /><br /><br /></div>

    <div id="label1"><label for="datenaissance"><span class="texte-form">Votre date de naissance :</span><span class="champ-obligatoire">*</span></label>
    <input type="date" class="center-block" name="datenaissance" value="<?php if (isset($_POST['datenaissance'])){echo $_POST['datenaissance'];} ?>" maxlength="10" required/><br /><br /></div>

    <div id="label0"><label for="sexe"><span class="texte-form">Vous êtes : </span><span class="champ-obligatoire">*</span></label>
	<select name="sexe" size="1">
		   <option value="">Choisir</option>
           <option value="homme">Un homme</option>
           <option value="femme">Une femme</option>
           <option value="autre">Autre</option>
    </select><br /><br /></div>
	
	<div id="label1"><label for="sectionactu"><span class="texte-form">Votre section actuelle :</span><span class="champ-obligatoire">*</span></label>
	<select name="sectionactu" size="1">
		   <option value="">Choisir</option>
           <optgroup label="Terminale générale">
           		<option value="Terminale L">Terminale L</option>
           		<option value="Terminale S">Terminale S</option>
           		<option value="Terminale ES">Terminale ES</option>
           </optgroup>

			<optgroup label="Terminale professionnelle">
           	 	<option value="Terminale professionnelle">Terminale professionnelle</option>
           </optgroup>

           <optgroup label ="Terminale STMG">
           		<option value="Terminale STMG GF">Terminale STMG option Gestion et Finance</option>
		   		<option value="Terminale STMG SIG">Terminale STMG option Systèmes d'Information et de Gestion</option>
		   		<option value="Terminale STMG RHC">Terminale STMG option Ressources humaines et communication</option>
		   		<option value="Terminale STMG Mercatique">Terminale STMG option Mercatique</option>
           </optgroup>
           <optgroup label="Terminale STI2D">
           		<option value="Terminale STI2D AC">Terminale STI2D option Architecture et Construction</option>
		    	<option value="Terminale STI2D SIN">Terminale STI2D option Systèmes d'Information et Numérique</option>
		    	<option value="Terminale STI2D EE">Terminale STI2D option Énergies et Environnement</option>
           </optgroup>
           <optgroup label="Terminale STL">
		   		<option value="Terminale STL Biotechnologies">Terminale STL option Biotechnologies</option>
		   		<option value="Terminale STL SPCL">Terminale STL option Sciences Physiques et Chimiques en Laboratoire</option>
		   </optgroup>

		   <optgroup label="Terminale STD2A">
		   		<option value="Terminale STD2A ATC">Terminale STD2A option Arts, Techniques et Civilisations</option>
		   		<option value="Terminale STD2A DC">Terminale STD2A option Démarche créative</option>
		   		<option value="Terminale STD2A PAV">Terminale STD2A option Pratiques en Arts Visuels</option>
		   		<option value="Terminale STD2A Technologies">Terminale STD2A option Technologies</option>
		   </optgroup>
		   <optgroup label="Terminale ST2S">
				<option value="Terminale ST2S">Terminale ST2S</option>
		   </optgroup>
		   <optgroup label="Terminale STAV">
		   	<option value="Terminale STAV">Terminale STAV</option>
		   </optgroup>
		   <optgroup label="Terminale TMD">
		   	<option value="Terminale TMD Danse">Terminale TMD option Danse</option>
		   	<option value="Terminale TMD Instrument">Terminale TMD option Instrument</option>
		   </optgroup>
		   <optgroup label="Terminale STHR">
		   	<option value="Terminale STHR">Terminale STHR</option>
		   </optgroup>
           <optgroup label="Réorientation">
            <option value="Réorientation BTS">Je suis actuellement en BTS mais je souhaite me réorienter</option>
            <option value="Réorientation DUT">Je suis actuellement en DUT mais je souhaite me réorienter</option>
            <option value="Réorientation (autre cas : 1ère année de prépa, école privée...)">Autre cas de réorientation (1ère année de prépa, école privée...)</option>
           </optgroup>
		   <optgroup label="Autre cas">
		    <option value="Année de césure">Année de césure</option>
		    <option value="Je travaille et souhaite reprendre mes études">Je travaille et souhaite reprendre mes études</option>
		    <option value="Déscolarisé ou autre">Déscolarisé ou autre</option>
		   </optgroup>

    </select></div><br />

	<label for="etablissementactu"><span class="texte-form">Votre établissement actuel (facultatif) :</span></label>
    <input type="text" class="center-block" name="etablissementactu" value="<?php if (isset($_POST['etablissementactu'])){echo $_POST['etablissementactu'];} ?>" placeholder="Établissement actuel" maxlength="30" /><br />


    <br /><button class="button-submit" type="submit"><span>Envoyer </span></button><br />
    <span class="champ-obligatoire-tip">* : Champs obligatoires</span><br />

    <strong><?= $nRows; ?></strong> personne(s) inscrite(s) pour le BTS MCO !

</form>
</div>
</html>