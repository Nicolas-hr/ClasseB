<?php
if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
}

try{
        $bdd = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_nicoquentin', 'tetrismardi');
    }catch(PDOException $e){
        echo 'Connexion échoué';
    }
 
 
 // Trouver les niveaux du créateur
if(isset($_POST['idMembre'])){ 
    
    $niveau = $bdd->query('SELECT nomNiveau, niveau FROM laby_niveaux WHERE idCreateur = ' . $_SESSION['userinfo']['id'] . ' ORDER BY nomNiveau ASC;');
    $niveau = $niveau->fetchAll();
    $reponse = "";	
        
    for($i = 0; $i<count($niveau); $i++){
        
        $reponse .= $niveau[$i]["nomNiveau"] . ";" . $niveau[$i]["niveau"] . "|";
    }
    echo $reponse;
}


// Sauvegarder les niveaux
if(isset($_POST['idCreateur']) AND isset($_POST['nomNiveau']) AND isset($_POST['categorie']) AND isset($_POST['niveau']) AND isset($_POST['newLvL'])){
	echo $_POST['newLvL'] . " work";
    if($_POST['newLvL'] === "true"){
       
	   $bdd->query('INSERT INTO laby_niveaux(NomNiveau, Categorie, niveau, idCreateur) VALUES ("' . $_POST['nomNiveau'] .'", "' . $_POST['categorie'] . '", "' . $_POST['niveau'] . '", ' . $_SESSION['userinfo']['id'] . ')');
    }else{
        $bdd->query('UPDATE laby_niveaux SET Categorie = "' . $_POST['categorie'] . '", niveau = "' . $_POST['niveau']  . '" WHERE idCreateur = ' . $_SESSION['userinfo']['id'] . ' AND NomNiveau = "' . $_POST['nomNiveau'] . '"');
    }
}

// Liste de niveaux
if(isset($_POST['ordre']) AND isset($_POST['nomNiveau']) AND isset($_POST['nomCreateur']) AND isset($_POST['difficulte'])){
    
    
    $niveau = $bdd->query('SELECT laby_niveaux.nomNiveau, membres.pseudo_user, laby_niveaux.Categorie, laby_niveaux.note, laby_niveaux.idNiveau FROM laby_niveaux JOIN membres ON membres.id_user = laby_niveaux.idCreateur WHERE membres.pseudo_user LIKE "%' . $_POST['nomCreateur'] . '%" AND laby_niveaux.nomNiveau LIKE "%' . $_POST['nomNiveau'] . '%" AND ' . $_POST['difficulte'] . ' ORDER BY laby_niveaux.note ' . $_POST['ordre'] .', laby_niveaux.nomNiveau ASC;');
    /*$niveau = $bdd->query('SELECT laby_niveaux.nomNiveau, membres.pseudo_user, laby_niveaux.Categorie, laby_niveaux.note, laby_niveaux.idNiveau, (SELECT COUNT(*) as fini FROM laby_niveaux_finis idJoueur = ' . $_SESSION['userinfo']['id'] . ') as fait FROM laby_niveaux JOIN membres ON membres.id_user = laby_niveaux.idCreateur WHERE membres.pseudo_user LIKE "%' . $_POST['nomCreateur'] . '%" AND laby_niveaux.nomNiveau LIKE "%' . $_POST['nomNiveau'] . '%" AND ' . $_POST['difficulte'] . ' ORDER BY laby_niveaux.note ' . $_POST['ordre'] .', laby_niveaux.nomNiveau ASC;');*/
    
    
    
    $niveau = $niveau->fetchAll();
	
    
    
    $reponse ="";
    
    for($i = 0; $i<count($niveau); $i++){
        $ask = $bdd->query('SELECT COUNT(*) as fini FROM laby_niveaux_finis WHERE idNiveau = ' . $niveau[$i]["idNiveau"] . ' AND idJoueur = ' . $_SESSION['userinfo']['id'] . ';');
        $ask = $ask->fetch();
        if($ask['fini'] == 0){
        $reponse .= $niveau[$i]["nomNiveau"] . ";" . $niveau[$i]["pseudo_user"] . ";" . $niveau[$i]["Categorie"] . ";" . $niveau[$i]["note"] . ";" . $niveau[$i]["idNiveau"] . ";false|";
        }else{
            $reponse .= $niveau[$i]["nomNiveau"] . ";" . $niveau[$i]["pseudo_user"] . ";" . $niveau[$i]["Categorie"] . ";" . $niveau[$i]["note"] . ";" . $niveau[$i]["idNiveau"] . ";true|";
        }
    }
    
    echo $reponse;
    
}

// Envoie grille de jeu

if(isset($_POST['idNiveau'])){
    $grille = $bdd->query('SELECT niveau FROM laby_niveaux WHERE idNiveau = ' . $_POST['idNiveau'] .';');
    
    $grille = $grille->fetchAll();
    

    
    echo $grille[0]['niveau'];
}

// Insert laby fini

if(isset($_POST['idNiveauFini'])){
	$ask = $bdd->query('SELECT COUNT(*) as fini FROM laby_niveaux_finis WHERE idNiveau = ' . $_POST['idNiveauFini'] . ' AND idJoueur = ' . $_SESSION['userinfo']['id'] . ';');
	
	$ask = $ask->fetch();
	
	if($ask['fini'] == 0){
		$bdd->query('INSERT INTO laby_niveaux_finis(idNiveau, idJoueur) VALUES ('. $_POST['idNiveauFini'] . ', ' . $_SESSION['userinfo']['id'] .')');
	}
}



// Check si fini

if(isset($_POST['idNiveauATrouver'])){
	$ask = $bdd->query('SELECT COUNT(*) as fini FROM laby_niveaux_finis WHERE idNiveau = ' . $_POST['idNiveauATrouver'] . ' AND idJoueur = ' . $_SESSION['userinfo']['id'] . ';');
	
	$ask = $ask->fetch();
	if($ask['fini'] == 0){
		echo false;
	}else{
		echo true;
	}
}





?>
