<?php 

	header('Content-type: text/html; charset=UTF-8', true);

  	require("class/Session.class.php");
  	include_once("class/BD.class.php");
  	include_once("class/Employe.class.php");
  	include_once("class/Formulaire.class.php");
  	include_once("class/Vehicule.class.php");

  	$Session = new Session();
  	$bd = new BD(true);
  	$employe = new Employe($bd);
  	$formulaire = new Formulaire();
  	$vehicule = new Vehicule($bd);

  	if(isset($_POST['ajouter']))
  	{
  		$employe->add($_POST['login'],$_POST['mdp'],$_POST['nom'],$_POST['prenom'],$_POST['statut'],$_POST['permis'],$_POST['droits']);

  		$Session->setFlash('Vous avez ajouté un utilisateur.','success');
  	}
  	
  	if(isset($_POST['supprimer']))
  	{
  		$employe->delete($_POST['idEmploye']);
  		
  		$Session->setFlash('Vous avez supprimé un utilisateur.','success');
  	}
  	
  	if(isset($_POST['modifier']))
  	{
  		$idEmploye=$_POST['idEmploye'];
  		
  		$sql = "SELECT * FROM employe WHERE idEmploye=".$idEmploye;
  		$ressql = $bd->query($sql);
		$current = mysql_fetch_assoc($ressql);
  		
  		if($current['mdp']!=hash("sha512",$_POST['mdp']))
  		{
  			$mdp = hash("sha512",$_POST['mdp']);
  			$sql2 = "UPDATE employe SET mdp=".$mdp." WHERE idEmploye=".$idEmploye;
        	$bd->query($sql2);
  		}
  		
		if($current['statut']!=$_POST['statut'])
		{
			$sql3 = "UPDATE employe SET statut=".$_POST['statut']." WHERE idEmploye=".$idEmploye;
        	$bd->query($sql3);
		}
		
		if($current['permis']!=$_POST['permis'])
		{
			$sql4 = "UPDATE employe SET permis=".$_POST['permis']." WHERE idEmploye=".$idEmploye;
        	$bd->query($sql4);
		}
		
		if($current['droits']!=$_POST['droits'])
		{
			$sql4 = "UPDATE employe SET droits=".$_POST['droits']." WHERE idEmploye=".$idEmploye;
        	$bd->query($sql4);
		}
  	}
  	
  	if(isset($_POST['ajoutervehicule']))
  	{
  		$vehicule->add($_POST['intituleVehicule']);
  		
  		$Session->setFlash('Vous avez ajouté un véhicule.','success');
  	}
  	
  	if(isset($_POST['supprimervehicule']))
  	{
  		$vehicule->delete($_POST['idVehicule']);
  		
  		$Session->setFlash('Vous avez supprimé un véhicule.','success');
  	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
    	<title>Administration</title>
  
	    <meta http-equiv="content-type" content="text/html" />
	    <meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="SIAO - 115 - Equipe de rue" />
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

  	</head>

  	<body>
  		<?php
  		if(isset($_SESSION['idEmploye']))
      	{
      	?>
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
			                <li><a href="appel115.php">Appel 115</a></li>
			                <li><a href="equipe.php">Equipe de rue</a></li>
			                <li><a href="usager.php">Usagers et Situations</a></li>
			                <li><a href="stats.php">Statistiques</a></li>
			                <li class="active"><a href="administration.php">Administration</a></li>
			                <li><a href="deconnexion.php">Déconnexion</a></li>
	            		</ul>
	          		</div><!--/.nav-collapse -->
	        	</div>
	      	</div>
	    </div>

	    <div class="container">
	    	<br />
	      	<h1>Administration</h1>

	      	<?php
	  		if($_SESSION['droits']==1)
	      	{
	      	?>

	    	<ul id="myTab" class="nav nav-tabs">
	    		<li class="dropdown">
			    	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Utilisateur<b class="caret"></b></a>
			    	<ul class="dropdown-menu">
			      		<li><a href="#ajouter" data-toggle="tab">Ajouter utilisateur</a></li>
			            <li><a href="#modifier" data-toggle="tab">Modifier utilisateur</a></li>
			            <li><a href="#supprimer" data-toggle="tab">Supprimer utilisateur</a></li>
			    	</ul>
			  	</li>
			  	<li class="dropdown">
			    	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Véhicule<b class="caret"></b></a>
			    	<ul class="dropdown-menu">
			      		<li><a href="#ajouterVehicule" data-toggle="tab">Ajouter véhicule</a></li>
			      		<li><a href="#supprimerVehicule" data-toggle="tab">Supprimer véhicule</a></li>
			    	</ul>
			  	</li>
	        </ul>

	        <?php 
				$Session->flash();
			?>

			<div id="myTabContent" class="tab-content">

				<div class="tab-pane fade in active">
					<p>Ce module d'administration permet de gérer les utilisateurs du site mais aussi de rajouter des éléments comme des orientations, des motifs d'appel, etc ...</p>
				</div>

				<div class="tab-pane fade" id="ajouter">
	            	<div class="span6">
				    <?php
				    	$formulaire->ajouterUtilisateur();
				    ?>
				    </div>
	            </div>
	            
	            <div class="tab-pane fade" id="modifier">
	            	<div class="span6">
				    <?php
				    	$formulaire->modifierUtilisateur();
				    ?>
				    </div>
	            </div>
	            
	            <div class="tab-pane fade" id="supprimer">
	            	<div class="span6">
				    <?php
				    	$formulaire->supprimerUtilisateur();
				    ?> 
				    </div>
	            </div>
	            
	            <div class="tab-pane fade" id="ajouterVehicule">
	            	<div class="span5">
				    <?php
				    	$formulaire->ajouterVehicule();
				    ?>
				    </div>
				    <div class="span1">
				    </div>
				    <div class="span5 well">
				    <legend>Liste des véhicules enregistrés</legend>
				    <?php
						$vehicule->listeVehicule();
					?>
				    </div> 
	            </div>
	            
	            <div class="tab-pane fade" id="supprimerVehicule">
	            	<div class="span6">
				    <?php
				    	$formulaire->supprimerVehicule();
				    ?>
				    </div>
	            </div>
	            
	        </div>
	    </div>

	    <?php
		}
		else
		{
			$Session->setFlash('Vous devez être dministrateur pour avoir accès à cette partie.','error');
			$Session->flash();
		}

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



