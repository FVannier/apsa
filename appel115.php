<?php 

  	header('Content-type: text/html; charset=UTF-8', true);

  	require("class/Session.class.php");
  	include_once("class/BD.class.php");
  	include_once("class/Formulaire.class.php");
  	include_once("class/Appel.class.php");
  	include_once("class/Origine.class.php");
  	include_once("class/Initiativedemande.class.php");
  	include_once("class/Motif.class.php");
  	include_once("class/Rupture.class.php");
  	include_once("class/Ressource.class.php");
  	include_once("class/Orientation.class.php");
  	include_once("class/Typologie.class.php");
  	include_once("class/Prestation.class.php");
  	include_once("class/CategorieAge.class.php");
  	include_once("class/Personne.class.php");
  	include_once("class/DemandePriseEnCompte.class.php");

  	$Session = new Session();
  	$bd = new BD(true);
  	$formulaire = new Formulaire();
  	$appel = new Appel($bd);
  	$origine = new Origine($bd);
  	$initiativedemande = new Initiativedemande($bd);
  	$motif = new Motif($bd);
  	$rupture = new Rupture($bd);
  	$ressource = new Ressource($bd);
  	$orientation = new Orientation($bd);
  	$typologie = new Typologie($bd);
  	$prestation = new Prestation($bd);
  	$categorieAge = new CategorieAge($bd);
  	$personne = new Personne($bd);
  	$demande = new DemandePriseEnCompte($bd);

	// Enregistre les appels polluants direct
  	if(isset($_GET['checkpolluantappel']))
  	{
  		$trueAppel=$appel->enregistreAppelPolluant($_GET['polluant'],$_GET['commentaires']);
  		if($trueAppel)
			$Session->setFlash('Appel polluant enregistré.','success');
	}

	// Enregistre les appels du répondeur
  	if(isset($_POST['checkpolluantrepondeur']))
  	{
  		$appel->enregistreAppelRepondeur($_POST['dateAppel'],$_POST['heureAppel'],$_POST['polluant2'],$_POST['commentaires']);
    	$Session->setFlash('Appel répondeur enregistré.','success');
  	}

  	if(isset($_POST['appel']))
  	{
  		$usager=$_POST['usager'];
  		/* 
  		 * Enregistrement Personne 1
  		 *
  		 */
  		
  		$dateNaissancePersonne1 = explode('/',$_POST['datenaissance1']);
  		$dateNaissancePersonne12 = $dateNaissancePersonne1[2]."-".$dateNaissancePersonne1[1]."-".$dateNaissancePersonne1[0];
  	
  		/* Requête pour checker si la personne est dans la BD */
    	$sqlCheckPersonne1 = "SELECT * FROM personne WHERE nom='".$_POST['nom1']."' AND prenom='".$_POST['prenom1']."' AND dateNaissance='".$dateNaissancePersonne12."'";
    	$ressqlCheckPersonne1 = $bd->query($sqlCheckPersonne1);
    	$currentCheckPersonne1 = mysql_fetch_assoc($ressqlCheckPersonne1);

		$categorieagePersonne1=$categorieAge->age($dateNaissancePersonne12);

    	/* Si la personne n'existe pas dans la BD, création de celle-ci */
    	if($currentCheckPersonne1=='')
    	{
      		/* Création de la personne */
      		$personne->add($_POST['nom1'],$_POST['prenom1'],$_POST['sexe1'],$dateNaissancePersonne12,$_POST['tel1'],$_POST['notes'],$categorieagePersonne1,$_POST['origine'],$_POST['typo'],'','');
    	}
    	else
    	{
      		/* Verification que la personne enregistré n'a pas changé de catégorie d'âge */
      		if($currentCheckPersonne1['CategorieAge_categorieAge']!=$categorieagePersonne1)
        		$personne->updateCategorieAge($currentCheckPersonne1['idPersonne'],$categorieagePersonne1);

			/* Verification de la typologie de l'usager */
			$personne->checkTypo($currentCheckPersonne1['idPersonne'],$_POST['typo'],$usager);
		}
		
		/* Récupérer ID de la personne */ 
		$idPersonne1=$personne->id($_POST['nom1'],$_POST['prenom1'],$dateNaissancePersonne12);
		
		/* Requête pour checker si la premiere personne a déjà ses ressources */
    	$sqlressourcepersonne1 = "SELECT * FROM personne_has_ressource WHERE Personne_idPersonne=".$idPersonne1;
    	$ressqlressourcepersonne1 = $bd->query($sqlressourcepersonne1);
    	$currentressourcepersonne1 = mysql_fetch_assoc($ressqlressourcepersonne1);

    	/* Création des ressources concernant la premiere personne */
    	$valueRessourcepersonne1=$_POST['ressource_1_'];
    	$i=0;
    	while($i<sizeof($valueRessourcepersonne1))
    	{
      		if($currentressourcepersonne1['Ressource_idRessource']!=$valueRessourcepersonne1[$i])
      		{
        		if($valueRessourcepersonne1[$i]=="1")
        		{
          			$ressource->addRessourcePersonne($idPersonne1,$valueRessourcepersonne1[$i],' ');
        		}
        		else
        		{
          			if($valueRessourcepersonne1[$i]=="2")
          			{
            			$ressource->addRessourcePersonne($idPersonne1,$valueRessourcepersonne1[$i],0);
          			}
          			else
          			{
            			$valueMontantpersonne1=$_POST['montant_1_'];
            			$j=0;
            			while($j<sizeof($valueMontantpersonne1))
            			{
              				if($valueRessourcepersonne1[$i]==($j+3))
              				{
                				$ressource->addRessourcePersonne($idPersonne1,$valueRessourcepersonne1[$i],$valueMontantpersonne1[$j]);
              				}
              				$j++;
            			}
          			}
        		}
      		}
      		$i++;
    	}
    	
    	if($usager=="couple")
    	{
    		/* 
  		 	* Enregistrement Personne 2
  		 	*
  		 	*/
  		
  			$dateNaissancePersonne2 = explode('/',$_POST['datenaissance2']);
  			$dateNaissancePersonne22 = $dateNaissancePersonne2[2]."-".$dateNaissancePersonne2[1]."-".$dateNaissancePersonne2[0];
  	
  			/* Requête pour checker si la personne est dans la BD */
    		$sqlCheckPersonne2 = "SELECT * FROM personne WHERE nom='".$_POST['nom2']."' AND prenom='".$_POST['prenom2']."' AND dateNaissance='".$dateNaissancePersonne22."'";
    		$ressqlCheckPersonne2 = $bd->query($sqlCheckPersonne2);
    		$currentCheckPersonne2 = mysql_fetch_assoc($ressqlCheckPersonne2);

			$categorieagePersonne2=$categorieAge->age($dateNaissancePersonne22);

    		/* Si la personne n'existe pas dans la BD, création de celle-ci */
    		if($currentCheckPersonne2=='')
    		{
      			/* Création de la personne */
      			$personne->add($_POST['nom2'],$_POST['prenom2'],$_POST['sexe2'],$dateNaissancePersonne22,$_POST['tel2'],$_POST['notes'],$categorieagePersonne2,$_POST['origine'],$_POST['typo'],'','');
    		}
    		else
    		{
      			/* Verification que la personne enregistré n'a pas changé de catégorie d'âge */
      			if($currentCheckPersonne2['CategorieAge_categorieAge']!=$categorieagePersonne2)
        			$personne->updateCategorieAge($currentCheckPersonne2['idPersonne'],$categorieagePersonne2);

				/* Verification de la typologie de l'usager */
				$personne->checkTypo($currentCheckPersonne2['idPersonne'],$_POST['typo'],$usager);
			}
		
			/* Récupérer ID de la personne */ 
			$idPersonne2=$personne->id($_POST['nom2'],$_POST['prenom2'],$dateNaissancePersonne22);
			
			$personne->conjoint($idPersonne1,$idPersonne2);
		
			/* Requête pour checker si la premiere personne a déjà ses ressources */
    		$sqlressourcepersonne2 = "SELECT * FROM personne_has_ressource WHERE Personne_idPersonne=".$idPersonne2;
    		$ressqlressourcepersonne2 = $bd->query($sqlressourcepersonne2);
    		$currentressourcepersonne2 = mysql_fetch_assoc($ressqlressourcepersonne2);

    		/* Création des ressources concernant la premiere personne */
    		$valueRessourcepersonne2=$_POST['ressource_2_'];
    		$i=0;
    		while($i<sizeof($valueRessourcepersonne2))
    		{
      			if($currentressourcepersonne2['Ressource_idRessource']!=$valueRessourcepersonne2[$i])
      			{
        			if($valueRessourcepersonne2[$i]=="1")
        			{
          				$ressource->addRessourcePersonne($idPersonne2,$valueRessourcepersonne2[$i],' ');
        			}
        			else
        			{
          				if($valueRessourcepersonne2[$i]=="2")
          				{
            				$ressource->addRessourcePersonne($idPersonne2,$valueRessourcepersonne2[$i],0);
          				}
          				else
          				{
            				$valueMontantpersonne2=$_POST['montant_2_'];
            				$j=0;
            				while($j<sizeof($valueMontantpersonne2))
            				{
              					if($valueRessourcepersonne2[$i]==($j+3))
              					{
                					$ressource->addRessourcePersonne($idPersonne2,$valueRessourcepersonne2[$i],$valueMontantpersonne2[$j]);
              					}
              					$j++;
            				}
          				}
        			}
      			}
      			$i++;
    		}
    	}

		if(isset($_POST['enfant']))
		{
			/* Création des enfants */
    		for($i=1;$i<=$_POST['enfant'];$i++)
    		{
    			$dateNaissanceEnfant = explode('/',$_POST['datenaissance_enfant_'.$i]);
  				$dateNaissanceEnfant2 = $dateNaissanceEnfant[2]."-".$dateNaissanceEnfant[1]."-".$dateNaissanceEnfant[0];
  			
  				$sqlenfant = "SELECT * FROM personne WHERE nom='".$_POST['nom_enfant_'.$i]."' AND prenom='".$_POST['prenom_enfant_'.$i]."' AND dateNaissance='".$dateNaissanceEnfant2."'";
      			$ressqlenfant = $bd->query($sqlenfant);
      			$currentenfant = mysql_fetch_assoc($ressqlenfant);
      		
      			$categorieageEnfant=$categorieAge->age($dateNaissanceEnfant2);

      			if($currentenfant=='')
      			{             
      				if($usager!="couple")           
      				{ 
        				if($_POST['responsable1_enfant_'.$i]=="1")
          					$personne->add($_POST['nom_enfant_'.$i],$_POST['prenom_enfant_'.$i],'',$dateNaissanceEnfant2,'',$_POST['notes'],$categorieageEnfant,$_POST['origine'],'',$idPersonne1,'');
        				else
          					$personne->add($_POST['nom_enfant_'.$i],$_POST['prenom_enfant_'.$i],'',$dateNaissanceEnfant2,'',$_POST['notes'],$categorieageEnfant,$_POST['origine'],'','','');
      				}
      				else
      				{
      					if(($_POST['responsable1_enfant_'.$i]=="1") && ($_POST['responsable2_enfant_'.$i]=="1"))
      						$personne->add($_POST['nom_enfant_'.$i],$_POST['prenom_enfant_'.$i],'',$dateNaissanceEnfant2,'',$_POST['notes'],$categorieageEnfant,$_POST['origine'],'',$idPersonne1,$idPersonne2);
      					else
      					{
      						if($_POST['responsable1_enfant_'.$i]=="1")
          						$personne->add($_POST['nom_enfant_'.$i],$_POST['prenom_enfant_'.$i],'',$dateNaissanceEnfant2,'',$_POST['notes'],$categorieageEnfant,$_POST['origine'],'',$idPersonne1,'');
        					else
          						$personne->add($_POST['nom_enfant_'.$i],$_POST['prenom_enfant_'.$i],'',$dateNaissanceEnfant2,'',$_POST['notes'],$categorieageEnfant,$_POST['origine'],'',$idPersonne2,'');
      					}
      				}
      			}
      		}
    	}

		$interafaire=false;
		
		foreach ($_POST['orientation'] as $valueOrientation)
    	{
    		if($valueOrientation=="1")
    		{
      			$interafaire=true;
      		}
      	}
      	
      	if($interafaire==true)
      		$idDemande=$demande->add(1,date("Y-m-d"),$_POST['initiative'],$idPersonne1);
      	else
      		$idDemande=$demande->add(0,date("Y-m-d"),$_POST['initiative'],$idPersonne1);
      		
      	foreach($_POST['orientation'] as $valueOrientation)
    	{
      		$orientation->addOrientationDemande($valueOrientation,$idDemande);
      	}
		
    
    	/* Création de la rupture */
    	$dateRupture = explode('/',$_POST['dateRupture']);
  		$dateRupture2 = $dateRupture[2]."-".$dateRupture[1]."-".$dateRupture[0];
    	$rupture->addRupture($_POST['rupture'],$idDemande,$dateRupture2);
    	
    	/* Création de l'appel relier à la demande donc à la personne */ 
    	$appel->addAppelDemande($_POST['idappel'],$idDemande);
			
    	/* Création du motif de la demande */
    	foreach ($_POST['motif'] as $valueMotif)
    	{
      		$motif->addMotifDemande($valueMotif,$idDemande);
      	}

    	/* Création des prestations de la demande */
    	if(isset($_POST['prestation']))
    	{
      		foreach($_POST['prestation'] as $valuePrestation)
      		{
        		$prestation->addPrestationDemande($valuePrestation,$idDemande);
        	}
    	}
	
		$Session->setFlash('Demande enregistrée.','success');
  	}
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
    	<title>Appel 115</title>
  
    	<meta http-equiv="content-type" content="text/html" />
    	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<meta name="description" content="Appel 115" />
    	<meta name="Author" content="Maxence Lucas" />
    	<meta name="Language" content="fr" />

    	<!--[if lt IE 9]>
      		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    	<![endif]-->

    	<style>
      		body {
        		padding-top: 60px;
      		}
    	</style>

    	<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css" />
    	<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-responsive.css" />

    	<script type="text/javascript" src="js/jquery.js"></script>
    	<script type="text/javascript" src="js/bootstrap.js"></script>
    	<script type="text/javascript" src="js/main.js"></script>
    	<script type="text/javascript" src="js/appel115.js"></script>  
    </head>
	<body>
    <?php
    if(isset($_SESSION['idEmploye']))
    {
    ?>
		<!-- Menu Général -->
		<div class="navbar navbar-inverse navbar-fixed-top">
        	<div class="navbar-inner">
          		<div class="container">
            		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              			<span class="icon-bar"></span>
              			<span class="icon-bar"></span>
              			<span class="icon-bar"></span>
            		</button>
            		<a class="brand" href="index.php">OSIRUS - S.I.A.O. de Lens</a>
            		<div class="nav-collapse collapse">
              			<ul class="nav">
                			<li><a href="index.php">Accueil</a></li>
                			<li class="active"><a href="appel115.php">Appel 115</a></li>
                			<li><a href="equipe.php">Equipe de rue</a></li>
                			<li><a href="usager.php">Usagers et Situations</a></li>
                			<li><a href="stats.php">Statistiques</a></li>
                			<li><a href="administration.php">Administration</a></li>
                			<li><a href="deconnexion.php">Déconnexion</a></li>
              			</ul>
            		</div>
          		</div>
        	</div>
      	</div>

		<!-- Container -->
      	<div class="container">
        	<h1>Appel 115</h1><br />
        	<p>1 enregistrement par véritable appel.</p><br />

			<!-- Sous-menu Appel115 -->
        	<ul id="myTab" class="nav nav-tabs">
            	<li class="active"><a href="#appel" data-toggle="tab">Appel 115</a></li>
            	<li><a href="#repondeur" data-toggle="tab">Répondeur 115</a></li>
            	<li><a href="#listeAppelRepondeur" data-toggle="tab">Liste des appels non polluant sur le répondeur</a></li>
        	</ul>
        
        	<?php
          		$Session->flash();
        	?>
        	
        	<!-- Accès au sous-menu -->
        	<div id="myTabContent" class="tab-content">
				
          		<!-- Sous-menu polluant appel115 -->
          		<div class="tab-pane fade in active" id="appel">

            	<?php
            		/* Formulaire polluant appel115 */
            		if( (!isset($_GET['polluant']) || ($_GET['polluant']=='1')) && (!isset($_GET['typo'])) )
            		{
            			$formulaire->appelPolluant();
            		}

					/* Formulaire typologie de l'appelant */
            		if(isset($_GET['polluant']) && ($_GET['polluant']=='0'))
            		{
              			$formulaire->choixTypologie();
            		}

					/* Création de la typologie */
            		if(isset($_GET['typo']))
            		{
              			$intituleTypologie = '';

              			$intituleTypologie = $intituleTypologie.$_GET['usager'];
              			$usager = $_GET['usager'];

              			if(isset($_GET['autre_enfant']))
              			{
                			$intituleTypologie = $intituleTypologie.'-'.$_GET['autre_enfant'];
                			$autre_enfant = $_GET['autre_enfant'];
              			}
              			else
              			{
                			$intituleTypologie = $intituleTypologie.'-'.$_GET['nb_enfant'];
                			$nb_enfant = $_GET['nb_enfant'];
              			}

              			if(isset($_GET['autre_animal']))
                			$intituleTypologie = $intituleTypologie.'-'.$_GET['autre_animal'];
            			
             			$typo=$typologie->search($intituleTypologie);
             			
             			if(isset($autre_enfant))
                    		$res = $autre_enfant;
						else
                    		$res = $nb_enfant;
                    		
                    	/* Création de l'appel */
    					$idappel=$appel->add(date("Y-m-d"),date("H:i"),0,0,'');
                    
             			/* Formulaire appel115 */
             			$formulaire->appel115($usager,$res,$typo,$idappel);
             		}
             	?>
             	</div>
                   
				<!-- Sous-menu répondeur appel115 -->
          		<div class="tab-pane fade" id="repondeur">
          		<?php
            		$formulaire->appelRepondeur();
            	?>
          		</div>
          		
          		<!-- Sous-menu liste des appels 115 non polluant sur le répondeur -->
        		<div class="tab-pane fade" id="listeAppelRepondeur">
        		<?php
        			$appel->appelRepondeurNonPolluant();
        		?>
				</div>
			</div>
		</div>
	<?php
    }
    else
    {
    	echo "<div class='span8' style='margin-left:23%'><center>";
      	$Session->setFlash('Vous devez être connecté pour accéder au système d\'information. <a href=index.php>Page d\'accueil</a>','error');
      	$Session->flash();
      	echo "</center></div>";
    }
    ?>
  	</body>
</html>