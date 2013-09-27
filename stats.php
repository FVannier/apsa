<?php 

	header('Content-type: text/html; charset=UTF-8', true);

  	require("class/Session.class.php");
  	include_once("class/BD.class.php");
  	include_once("class/Appel.class.php");

  	$Session = new Session();
  	$bd = new BD(true);
  	$appel = new Appel($bd);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
    	<title>Statistiques</title>
  
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
			                <li class="active"><a href="stats.php">Statistiques</a></li>
			                <li><a href="administration.php">Administration</a></li>
			                <li><a href="deconnexion.php">Déconnexion</a></li>
	            		</ul>
	          		</div><!--/.nav-collapse -->
	        	</div>
	      	</div>
	    </div>

	    <div class="container">
	    	<br />
	      	<h1>Statistiques</h1>

	    	<ul id="myTab" class="nav nav-tabs">
            	<li class="active"><a href="#appel" data-toggle="tab">Stats Appel 115</a></li>
            	<!--<li><a href="#inter" data-toggle="tab">Stats Intervention équipe de rue</a></li>-->
            </ul>

	        <?php 
				$Session->flash();
			?>

			<div id="myTabContent" class="tab-content">

				<div class="tab-pane fade in active" id="appel">
	            	<?php
	            		$appel->nbAppel();
	            	?>
	            </div>
	            <!--
	            <div class="tab-pane fade" id="inter">
	            	
	            </div>-->
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



