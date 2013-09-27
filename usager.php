<?php 

  	header('Content-type: text/html; charset=UTF-8', true);

  	require("class/Session.class.php");
  	include_once("class/BD.class.php");
  	include_once("class/Personne.class.php");
  	include_once("class/Situation.class.php");
  	include_once("class/Formulaire.class.php");
  
  	$Session = new Session();
  	$bd = new BD(true);
  	$personne = new Personne($bd);
  	$situation = new Situation($bd);
  	$formulaire = new Formulaire();
  	
  	if(isset($_POST['enregistrer']))
  	{
  		if(!empty($_POST['daterappel']))
  		{
  			$daterappel = explode('/',$_POST['daterappel']);
  			$daterappel2 = $daterappel[2]."-".$daterappel[1]."-".$daterappel[0];
  			$idSituation=$situation->add(date('Y-m-d'),$_POST['situation'],$daterappel2);
  		}
  		else
  			$idSituation=$situation->add2(date('Y-m-d'),$_POST['situation']);
  			
  		$situation->addSituationPersonne($idSituation,$_POST['id']);
  		
  		$Session->setFlash('Vous avez ajouté une situation.','success');
  	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  	<head>
    	<title>Usagers</title>
  
    	<meta http-equiv="content-type" content="text/html" />
    	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<meta name="description" content="Usagers" />
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
    	<script type="text/javascript" src="js/usager.js"></script>
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
                			<li><a href="equipe.php">Equipe de rue</a></li>
                			<li class="active"><a href="usager.php">Usagers et Situations</a></li>
                			<li><a href="stats.php">Statistiques</a></li>
                			<li><a href="administration.php">Administration</a></li>
                			<li><a href="deconnexion.php">Déconnexion</a></li>
              			</ul>
            		</div>
          		</div>
        	</div>
      	</div>

      	<div class="container">
        	<h1>Usagers et Situations</h1>
        	<br />
        
        	<!-- Sous-menu Equipe de rue -->
        	<ul id="myTab" class="nav nav-tabs">
            	<li class="active"><a href="#listeUsager" data-toggle="tab">Liste des usagers</a></li>
            	<li><a href="#consulterSituation" data-toggle="tab">Consulter les situations</a></li>
        	</ul>
        
        <?php
        	$Session->flash();
        ?>
       
        	<!-- Accès au sous-menu -->
        	<div id="myTabContent" class="tab-content">
				<?php
				if(!isset($_GET['voir']))
				{
					if(!isset($_GET['ecrire']))
					{
						if(!isset($_GET['date']))
						{
				?>
          		<!-- Sous-menu liste usager -->
        		<div class="tab-pane fade in active" id="listeUsager">
        		<?php
        			$formulaire->voirUsager();
        		?>	
        		</div>
        		
        		<!-- Sous-menu liste usager -->
        		<div class="tab-pane fade" id="consulterSituation">
        			<form action="usager.php" method="GET" class="well form-horizontal">
              		<fieldset>
              			<legend>Consulter les situations</legend>
              	
              			<div class="control-group" style="margin-left:28%;">
              				<label class="control-label"><b>Date</b></label>
                			<div class="controls">
                        		<input class="input-small" text="text" name="date" placeholder="jj/mm/aaaa" />
                        		<input type="submit" name="consulter" value="Consulter" class="btn btn-primary" />
                    		</div>
                		</div>

                		<div class="span11">
                			<div class="navbar">
                				<div class="navbar-inner">
                					<ul class="pager">
                						<li class="previous">
                							<?php
                								$mindate = strtotime($situation->returnDate());
                								$hier = mktime(0, 0, 0, date("m",$mindate),date("d",$mindate)-1,date("Y",$mindate));
                								$timestamp = date("d/m/Y",$hier);
                								echo "<a href='usager.php?date=$timestamp'>&larr;</a>";
                							?>
                							
                						</li>
                						<li><?php $maxdate=explode("-",$situation->returnDate()); 
                							if(empty($maxdate))
                								echo $maxdate[2]."/".$maxdate[1]."/".$maxdate[0];
                						?></li>
                						
                						<li class="next disabled">
                							<a href="">&rarr;</a>
                						</li>
                					</ul>
                				</div>
                			</div>
                		</div>
                		<table id="table" class="table table-striped table-bordered">
              			<thead>
                			<tr>
                  				<th style="text-align:center;background-color:#d9edf7;">Usager(s)</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Situation(s)</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Date rappel</th>
                			</tr>
              			</thead>
              			<tbody>
                		<?php
    
                			$situation->afficherSituation($situation->returnDate());
                		?>
              			</tbody>
          			</table>
                		
              		</fieldset>
            	</form>   
        		</div>
        		<?php
        				}
        			}
        		}
        		if(isset($_GET['date']))
                {
                	echo "<a class='btn btn-small' href='usager.php'><i class='icon-arrow-left'></i> Revenir à la liste des usagers</a><br /><br />";
        			
        			?>
        			<form action="usager.php" method="GET" class="well form-horizontal">
              		<fieldset>
              		<br />
        			<div class="control-group" style="margin-left:28%;">
              				<label class="control-label"><b>Date</b></label>
                			<div class="controls">
                        		<input class="input-small" text="text" name="date" placeholder="jj/mm/aaaa" />
                        		<input type="submit" name="consulter" value="Consulter" class="btn btn-primary" />
                    		</div>
                		</div>
        			<div class="span11">
                			<div class="navbar">
                				<div class="navbar-inner">
                					<ul class="pager">
                						<li class="previous">
                							<?php
                								$dateSituation2 = explode("/",$_GET['date']);
                								$dateSituation22 = $dateSituation2[2]."-".$dateSituation2[1]."-".$dateSituation2[0];
                								$mindate2 = strtotime($dateSituation22);
                								$hier2 = mktime(0, 0, 0, date("m",$mindate2),date("d",$mindate2)-1,date("Y",$mindate2));
                								$timestamp2 = date("d/m/Y",$hier2);
                								echo "<a href='usager.php?date=$timestamp2'>&larr;</a>";
                							?>
                							
                						</li>
                						<li><?php echo $_GET['date'];
                						?></li>
                						
                						<li class="next">
                							<?php
                								$dateSituation3 = explode("/",$_GET['date']);
                								$dateSituation33 = $dateSituation3[2]."-".$dateSituation3[1]."-".$dateSituation3[0];
                								$mindate3 = strtotime($dateSituation33);
                								$hier3 = mktime(0, 0, 0, date("m",$mindate3),date("d",$mindate3)+1,date("Y",$mindate3));
                								$timestamp3 = date("d/m/Y",$hier3);
                								echo "<a href='usager.php?date=$timestamp3'>&rarr;</a>";
                							?>
                						</li>
                					</ul>
                				</div>
                			</div>
                		</div>
        			<?php
        			echo "<legend>Situation du ".$_GET['date']."</legend>";
        			?>
        				<table id="table" class="table table-striped table-bordered">
              			<thead>
                			<tr>
                  				<th style="text-align:center;background-color:#d9edf7;">Usager(s)</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Situation(s)</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Date rappel</th>
                			</tr>
              			</thead>
              			<tbody>
                		<?php
    						$dateSituation = explode("/",$_GET['date']);
                			$dateSituation2 = $dateSituation[2]."-".$dateSituation[1]."-".$dateSituation[0];
                			$situation->afficherSituation($dateSituation2);
                		?>
              			</tbody>
          			</table>
          			</fieldset>
          			</form>
              		
                	<?php
                	
                }
        		if(isset($_GET['voir']))
        		{
        			echo "<a class='btn btn-small' href='usager.php'><i class='icon-arrow-left'></i> Revenir à la liste des usagers</a><br /><br />";
        			echo "<div class='well'>";
        				$personne->usager($_GET['voir']);
        			echo "</div>";
        		}
        		if(isset($_GET['ecrire']))
        		{
        			echo "<a class='btn btn-small' href='usager.php'><i class='icon-arrow-left'></i> Revenir à la liste des usagers</a><br /><br />";
        			echo "<div class='well'>";
        				$situation->ecrireSituation($_GET['ecrire']);
        			echo "</div>";
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