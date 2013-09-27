<?php 

  	header('Content-type: text/html; charset=UTF-8', true);

  	require("class/Session.class.php");
  	include_once("class/BD.class.php");
  	include_once("class/Employe.class.php");
	include_once("class/Vehicule.class.php");
	include_once("class/DemandePriseEnCompte.class.php");
	include_once("class/Intervention.class.php");
	include_once("class/Prestation.class.php");
	
  	$Session = new Session();
  	$bd = new BD(true);
  	$employe = new Employe($bd);
  	$vehicule = new Vehicule($bd);
  	$demande = new DemandePriseEnCompte($bd);
  	$intervention = new Intervention($bd);
  	$prestation = new Prestation($bd);

	if(isset($_POST['rdv']))
  	{
  		if($_POST['equipe']!='')
  		{
  			if($_POST['demande'])
  			{
  				$pers=$demande->demandepersonne($_POST['demande']);
  				if($intervention->testJourneeIntervention($_POST['vehicule']))
  					$journeeIntervention=$intervention->addJourneeIntervention($_POST['vehicule']);
  				else
  					$journeeIntervention=$intervention->idJourneeIntervention($_POST['vehicule']);
  		
  				$date = date("Y-m-d");
  				$inter=$intervention->addIntervention($date,$_POST['heure'],$_POST['lieu'],$pers,$_POST['demande'],$journeeIntervention);
  		
  				$employe->interventionEmploye($_POST['equipe'],$inter);
	
  				$Session->setFlash('Vous avez fixé un rendez-vous.','success');
  			}
  			else
  				$Session->setFlash('Vous devez selectionné une demande d\'intervention.','error');
  		}
  		else
  			$Session->setFlash('Vous devez selectionné une équipe de rue.','error');
  	}
  
  	if(isset($_POST['faireEquipe']))
  	{
		if(($_POST['employe1']!="") && ($_POST['employe2']!="") && ($_POST['employe1']!=$_POST['employe2']))
		{
			if($_POST['employe3']!="")
				$employe->addEquipe3($_POST['employe1'],$_POST['employe2'],$_POST['employe3']);
			else
				$employe->addEquipe2($_POST['employe1'],$_POST['employe2']);
		
			$Session->setFlash('Vous avez créée une équipe.','success');
		}
		else
			$Session->setFlash('Il faut minimum 2 employés.','error');	
  	}
  	
  	if(isset($_POST['rencontre']))
  	{
  		$intervention->updateIntervention($_POST['idIntervention'],$_POST['dureeIntervention'],$_POST['absence']);
  		
  		if($_POST['suivi']==1)
  		{
  			$sql = "SELECT * FROM intervention WHERE idIntervention=".$_POST['idIntervention'];
  			$ressql = $bd->query($sql);
			$current = mysql_fetch_assoc($ressql);
  			
  			header("location:usager.php?ecrire=".$current['personne_idPersonne']);
  		}
  		
  		$Session->setFlash('Vous avez mis à jour la rencontre équipe de rue.','success');
  	}
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  	<head>
    	<title>Equipe de rue</title>
  
    	<meta http-equiv="content-type" content="text/html" />
    	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<meta name="description" content="Equipe de rue" />
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
    	<script type="text/javascript">
    	function em(valeur)
      	{
    		if(valeur=="1")
        	{
          		targetElement = document.getElementById('em3');
          
          		if(targetElement.style.display == "none")
          		{
            		targetElement.style.display = "" ;
          		} 
          		else
          		{
            		targetElement.style.display = "none" ;
          		}
        	}
        	else
        		targetElement.style.display = "none" ;
      	}
      	
      	function presta(valeur)
		{	
			targetElement = document.getElementById('typePrestation');
    		
    		if(valeur=="1")
    		{
				targetElement.style.display = "" ;
    		}
    		else
    		{
    			targetElement.style.display = "none" ;
    		}
		}
		
		function absent(valeur)
		{
			targetElement = document.getElementById('dureeIntervention');
			
			if(valeur=="1")
			{
				$('#dureeIntervention').attr('disabled','disabled');
			}
			else
			{
				$('#dureeIntervention').removeAttr('disabled');
			}
		}
      	</script>
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
                			<li><a href="appel115.php">Appel 115</a></li>
                			<li class="active"><a href="equipe.php">Equipe de rue</a></li>
                			<li><a href="usager.php">Usagers et Situations</a></li>
                			<li><a href="stats.php">Statistiques</a></li>
                			<li><a href="administration.php">Administration</a></li>
                			<li><a href="deconnexion.php">Déconnexion</a></li>
              			</ul>
            		</div>
          		</div>
        	</div>
		</div>

      	<div class="container">
        	<h1>Equipe de rue</h1>
        	<br />
        
        	<!-- Sous-menu Equipe de rue -->
        	<ul id="myTab" class="nav nav-tabs">
            	<li class="active"><a href="#planning" data-toggle="tab">Planning équipe de rue</a></li>
            	<li><a href="#rencontre" data-toggle="tab">Rencontre équipe de rue</a></li>
            	<li><a href="#equipe" data-toggle="tab">Organiser les équipes de rue pour la journée</a></li>
        	</ul>
        
        	<?php
          		$Session->flash();
        	?>
        	
        	<?php
            		if(isset($_GET['choix']))
            		{
            	?>
            		<form action="equipe.php" method="POST" class="well form-horizontal">
              			<fieldset>
              				<legend>Rencontre</legend>
              				<br />
              					<?php
              						echo "<input type='hidden' name='idIntervention' value='".$_GET['inter']."' />";
              					?>
              					
              					<div class="control-group">
                        			<label class="control-label"><b>Absent</b></label>
                        			<div class="controls">
                        				<label class="radio inline">
                          					<input onchange="absent(this.value)" type="radio" name="absence" value="1" required />Oui
                        				</label>
                        				<label class="radio inline">
                          					<input onchange="absent(this.value)" type="radio" name="absence" value="0" required checked/>Non
                        				</label>
                      				</div>
                      			</div>
                      			
                      			<div class="control-group">
                        			<label class="control-label"><b>Durée Intervention</b></label>
                        			<div class="controls">
                          				<input type="text" id="dureeIntervention" name="dureeIntervention" placeholder="hh:mm" required />
                        			</div>
                      			</div>
                      			
                      			<div class="control-group">
                        			<label class="control-label"><b>Ecrire situation/suivi ?</b></label>
                        			<div class="controls">
                        				<label class="radio inline">
                          					<input type="radio" name="suivi" id="suivi" value="1" required />Oui
                        				</label>
                        				<label class="radio inline">
                          					<input type="radio" name="suivi" id="suivi" value="0" required />Non
                        				</label>
                      				</div>
                      			</div>
                      			
                      			<center><input type="submit" name="rencontre" value="Enregistrer la rencontre" class="btn btn-primary" /></center>
              			</fieldset>
              		</form>
            	<?php
            		}
            		else
            		{
            	?>
       
        	<!-- Accès au sous-menu -->
        	<div id="myTabContent" class="tab-content">

          		<!-- Sous-menu planning -->
          		<div class="tab-pane fade in active" id="planning">
            		<form action="equipe.php" method="POST" class="well form-horizontal">
              			<fieldset>
              			<legend>Planning</legend>
              			<br />
            			<?php
                			$intervention->listeIntervention();
            			?>
            
                		<legend>Intervention</legend>
                  		<div class="row show-grid">
            				<div class="span7">
                    			<b>Appelants 115</b>
                      			<div class="control-group">
                        			<div class="controls">
                          			<?php
                        				$demande->liste();
                          			?>
                        			</div>
                      			</div>
                    		</div>

                    		<div class="span4">
                      			<b>Rendez-vous</b>
                      			<div class="control-group">
                        			<label class="control-label"><b>Heure</b></label>
                        			<div class="controls">
                          				<input type="text" name="heure" placeholder="hh:mm" required />
                        			</div>
                      			</div>

                      			<div class="control-group">
                        			<label class="control-label"><b>Lieu</b></label>
                        			<div class="controls">
                          				<input type="text" name="lieu" required />
                        			</div>
                      			</div>

                      			<div class="control-group">
                        			<label class="control-label"><b>Equipe</b></label>
                        			<div class="controls">
                          				<select name="equipe">
                            			<?php
                            				$employe->listeEquipeDuJour();
                            			?>	
                          				</select>
                        			</div>
                      			</div>
                      
                      			<div class="control-group">
                        			<label class="control-label"><b>Véhicule</b></label>
                        			<div class="controls">
                          				<select name="vehicule">
                            			<?php
                            				$vehicule->liste();
                            			?>
                          				</select>
                        			</div>
                      			</div>
                      		<center><input type="submit" name="rdv" value="Fixer un rendez-vous" class="btn btn-primary" /></center>
						</div>
                  	</div>
                	</fieldset>
				</form>        
			</div>

          	<!-- Sous-menu rencontre -->
          	<div class="tab-pane fade" id="rencontre">
            	<form action="equipe.php" method="GET" class="well form-horizontal">
              		<fieldset>
              			<legend>Rencontre</legend>
              			<div class="row show-grid">
            				<div class="span7">
            					<br />
              					<div class="control-group">
                        			<div class="controls">
                          			<?php
                        				$intervention->listeRencontre();
                          			?>
                        			</div>
                      			</div>
                      			
                      			<center><input type="submit" name="choix" value="Choisir la rencontre" class="btn btn-primary" /></center>		
            				</div>
            				<div class="span4">
            					<br />
            					<a class='btn btn-small' href='appel115.php?polluant=0&commentaires=&checkpolluantappel=Envoyer'><i class='icon-user'></i> Nouvelle personne ou famille</a>
            				</div>
            			</div>
            		</fieldset>
              	</form>		
          	</div>
          
          <!-- Sous-menu équipe -->
		<div class="tab-pane fade" id="equipe">
			<form action="equipe.php" method="POST" class="well form-horizontal">
				<fieldset>
                	<div class="span5">
                		<legend>Faire équipe de rue du jour</legend>
                	
                		<p><b>Minimum 2 personnes par équipe</b></p>
            			<div class="control-group">
                        	<label class="control-label"><b>Employé(e) 1</b></label>
                        	<div class="controls">
                          		<select name="employe1">
                            	<?php
                            		$employe->liste();
                            	?>
                          		</select>
                        	</div>
                    	</div>
                    
                    	<div class="control-group">
                        	<label class="control-label"><b>Employé(e) 2</b></label>
                        	<div class="controls">
                          		<select name="employe2">
                            	<?php
                            		$employe->liste();
                            	?>
                          		</select>
                        	</div>
                    	</div>
                    
                    	<div class="control-group">
                      		<label class="control-label"><b>Un 3ème employé dans l'équipe</b></label>
                      		<div class="controls">
                        		<label class="radio inline">
                          			<input type="radio" onchange="em(this.value)" name="employe" id="employe" value="0" required />Non
                        		</label>
                        		<label class="radio inline">
                         			<input type="radio" onchange="em(this.value)" name="employe" id="employe" value="1" required />Oui
                        		</label>
                      		</div>
                  		</div>
                    
                    	<div id="em3" class="control-group" style="display:none;">
                        	<label class="control-label"><b>Employé(e) 3</b></label>
                        	<div class="controls">
                          		<select name="employe3">
                            	<?php
                            		$employe->liste();
                            	?>
                          		</select>
                        	</div>
                    	</div>
                    
                    	<center><input type="submit" name="faireEquipe" value="Faire une équipe" class="btn btn-primary" /></center>
                		</div>
                		<div class="span1"></div>
            	<div class="span5">
            	
                <legend>Equipe de rue du jour</legend>
                <?php
                	$employe->equipeDuJour();
                ?>
            	</div>
					</fieldset>
            	</form>
            </div>
        </div>
        
        <?php
        }
        ?>

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