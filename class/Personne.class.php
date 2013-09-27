<?php

class Personne {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($nom,$prenom,$sexe,$dateNaissance,$telephone,$notes,$CategorieAge_categorieAge,$Origine_idOrigine,$Typologie_idTypologie,$aPourResponsable1,$aPourResponsable2) {
		$sql = "INSERT INTO personne VALUES (NULL,'$nom','$prenom','$sexe','$dateNaissance','$telephone','$notes','$CategorieAge_categorieAge','$Origine_idOrigine','$Typologie_idTypologie','$aPourResponsable1','$aPourResponsable2')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function liste()
	{
		$sql = "SELECT * FROM personne ORDER BY nom,prenom";
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			if($current['sexe']!='')
			{
			echo "<tr class='warning'>";
	            echo "<td>".$current['nom']."</td>";
	            echo "<td>".$current['prenom']."</td>";
	            echo "<td style='text-align:center;'>".$current['sexe']."</td>";
	            $date_de_naissance = $current['dateNaissance'];                            
			    $chiffre = explode('-',$date_de_naissance);
			    $time_naissance = mktime(0,0,0,$chiffre[2],$chiffre[1],$chiffre[0]);
			    $seconde_vecu = time() - $time_naissance;
			    $seconde_par_an = (1461*24*60*60)/4;
			    $age = floor(($seconde_vecu / $seconde_par_an));
	            echo "<td style='text-align:center;'>".$age."</td>";
	           	echo "<td style='text-align:center;'><a class='btn' href='usager.php?voir=".$current['idPersonne']."'><i class='icon-eye-open'></i></a></td>";
	           	echo "<td style='text-align:center;'><a class='btn' href='usager.php?ecrire=".$current['idPersonne']."'><i class='icon-pencil'></i></a></td>";
            echo "</tr>";
        	}
		}
	}
	
	public function appel115($idPersonne)
	{
		$sql = "SELECT COUNT(*) AS nb_appel FROM demandepriseencompte WHERE Personne_idPersonne=".$idPersonne;
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		
		return $current['nb_appel'];
	}
	
	public function intervention($idPersonne)
	{
		$sql = "SELECT COUNT(*) AS nb_inter FROM intervention WHERE absence=0 AND Personne_idPersonne=".$idPersonne;
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		
		return $current['nb_inter'];
	}
	
	public function interventionAbsent($idPersonne)
	{
		$sql = "SELECT COUNT(*) AS nb_inter FROM intervention WHERE absence=1 AND Personne_idPersonne=".$idPersonne;
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		
		return $current['nb_inter'];
	}

	public function origine($idPersonne)
	{
		$sql = "SELECT Origine_idOrigine FROM personne WHERE idPersonne=".$idPersonne;
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);

		$sql2 = "SELECT * FROM origine WHERE idOrigine=".$current['Origine_idOrigine'];
		$ressql2 = $this->db->query($sql2);
		$current2 = mysql_fetch_assoc($ressql2);

		return $current2['intituleOrigine'];
	}

	public function ressource($idPersonne)
	{
		$sql = "SELECT * FROM personne_has_ressource WHERE Personne_idPersonne=".$idPersonne;
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			$sql2 = "SELECT * FROM ressource WHERE idRessource=".$current['Ressource_idRessource'];
			$ressql2 = $this->db->query($sql2);
			$current2 = mysql_fetch_assoc($ressql2);
			echo "<ul>";
				echo "<li>".$current2['typeRessource'];
				if($current['montant']!=0)
				{
					echo " -> ".$current['montant']." € ";
				}
				echo "</li>";
			echo "</ul>";
		}
	}

	public function aconjoint($idPersonne)
	{
		$sql = "SELECT * FROM est_conjoint WHERE Personne_idPersonne1=".$idPersonne;
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);

		if($current!='')
			return $current['Personne_idPersonne2'];
	}

	public function conjoint($idPersonne1,$idPersonne2) {
		$sql = "INSERT INTO est_conjoint VALUES('$idPersonne1','$idPersonne2')";
		$this->db->query($sql);
		mysql_insert_id();

		$sql2 = "INSERT INTO est_conjoint VALUES('$idPersonne2','$idPersonne1')";
		$this->db->query($sql2);
		mysql_insert_id();
	}

	public function deleteConjoint($idPersonne) {
		$sql = "DELETE FROM est_conjoint WHERE Personne_idPersonne='$idPersonne'";
		$this->db->query($sql);
		mysql_affected_rows();

		$sql2 = "DELETE FROM est_conjoint WHERE Personne_idPersonne1='$idPersonne'";
		$this->db->query($sql2);
		mysql_affected_rows();
	}

	public function updateCategorieAge($idPersonne,$CategorieAge_categorieAge) {
		$sql = "UPDATE personne SET CategorieAge_categorieAge='$CategorieAge_categorieAge' WHERE idPersonne=$idPersonne";
        $this->db->query($sql);
	}
	
	public function updateTypologie($idPersonne,$Typologie_idTypologie) {
		$sql = "UPDATE personne SET Typologie_idTypologie='$Typologie_idTypologie' WHERE idPersonne=$idPersonne";
        $this->db->query($sql);
	}
	
	public function checkTypo($idPersonne,$idTypologie,$usager1) {
		$sql = "SELECT * FROM personne WHERE idPersonne=".$idPersonne;
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		
		if($current['Typologie_idTypologie']!=$idTypologie)
      	{
      		$sql2 = "SELECT * FROM typologie WHERE idTypologie=".$current['Typologie_idTypologie'];
      		$ressql2 = $this->db->query($sql2);
			$current2 = mysql_fetch_assoc($ressql2);

			$usager2 = explode('-',$current2['intituleTypologie']);
			if((($usager1=="homme") || ($usager1=="femme")) && ($usager2[0]=="couple"))
			{
				$this->updateTypologie($current['idPersonne'],$idTypologie);
				$this->deleteConjoint($current['idPersonne']);
			}
		}
	}

	public function id($nom,$prenom,$datenaissance) {
	    $sql = "SELECT * FROM personne WHERE nom='".$nom."' AND prenom='".$prenom."' AND dateNaissance='".$datenaissance."'";
    	$ressql = $this->db->query($sql);
    	$current = mysql_fetch_assoc($ressql);
    	return $current['idPersonne'];
	}
	
	public function nom($idPersonne) {
		$sql = "SELECT * FROM personne WHERE idPersonne='".$idPersonne."'";
    	$ressql = $this->db->query($sql);
    	$current = mysql_fetch_assoc($ressql);
    	echo $current['nom']." ".$current['prenom'];
	}
	
	public function nomReturn($idPersonne) {
		$sql = "SELECT * FROM personne WHERE idPersonne='".$idPersonne."'";
    	$ressql = $this->db->query($sql);
    	$current = mysql_fetch_assoc($ressql);
    	return $current['nom']." ".$current['prenom'];
	}
	
	public function usager($idPersonne) {
		include_once("Situation.class.php");
		include_once("DemandePriseEnCompte.class.php");
		
		$situation = new Situation($this->db);
		$demande = new DemandePriseEnCompte($this->db);
		$sql="SELECT * FROM personne WHERE idPersonne='".$idPersonne."'";
    	$ressql=$this->db->query($sql);
    	$conjoint=$this->aconjoint($idPersonne);
    	echo "<div class='row show-grid'>";
        	echo "<div class='span5'>";
    			while($current = mysql_fetch_assoc($ressql))
    			{
    				echo "<legend>Usager&nbsp;&nbsp;&nbsp;<a class='btn btn-small' href='usager.php?modifier=".$current['idPersonne']."'>
                <i class='icon-pencil'></i> Modifier</a></legend>";
                	echo "<b>Nom : </b>".$current['nom']."<br />";
                	echo "<b>Prénom : </b>".$current['prenom']."<br />";
                	echo "<b>Sexe : </b>".$current['sexe']."<br />";
                	$date_de_naissance = $current['dateNaissance'];                            
                	$chiffre = explode('-',$date_de_naissance);
                	$time_naissance = mktime(0,0,0,$chiffre[2],$chiffre[1],$chiffre[0]);
                	$seconde_vecu = time() - $time_naissance;
                	$seconde_par_an = (1461*24*60*60)/4;
                	$age = floor(($seconde_vecu / $seconde_par_an));
                	echo "<b>Age : </b>".$age." ans<br />";
                	$newdate = $chiffre[2]."/".$chiffre[1]."/".$chiffre[0];
                	echo "<b>Date de naissance : </b>".$newdate."<br />";
                	if($current['telephone']!='')
                  		echo "<b>Téléphone : </b>".$current['telephone']."<br />";
                	echo "<b>Origine : </b>".$this->origine($current['idPersonne'])."<br />";
                	echo "<b>Ressource(s) : </b>";
                	$this->ressource($current['idPersonne']);
                	echo "<b>Nombre d'appel(s) 115 : </b>".$this->appel115($current['idPersonne'])."<br />";
                	echo "<b>Nombre d'intervention : </b>".$this->intervention($current['idPersonne'])."<br />";
                	echo "<b>Nombre d'absence(s) au rdv : </b>".$this->interventionAbsent($current['idPersonne'])."<br />";
    			}
    		echo "</div>";
    		echo "<div class='span1'></div>";
    		echo "<div class='span5'>";
    			$sql2 = "SELECT * FROM personne WHERE idPersonne='".$conjoint."'";
    			$ressql2 = $this->db->query($sql2);
    			while($current2 = mysql_fetch_assoc($ressql2))
    			{
    				echo "<legend>Conjoint&nbsp;&nbsp;&nbsp;<a class='btn btn-small' href='usager.php?modifier=".$current2['idPersonne']."'>
                <i class='icon-pencil'></i> Modifier</a></legend>";
                	echo "<b>Nom : </b>".$current2['nom']."<br />";
                	echo "<b>Prénom : </b>".$current2['prenom']."<br />";
                  	echo "<b>Sexe : </b>".$current2['sexe']."<br />";
                  	$date_de_naissance = $current2['dateNaissance'];                            
                  	$chiffre = explode('-',$date_de_naissance);
                  	$time_naissance = mktime(0,0,0,$chiffre[2],$chiffre[1],$chiffre[0]);
                  	$seconde_vecu = time() - $time_naissance;
                  	$seconde_par_an = (1461*24*60*60)/4;
                  	$age = floor(($seconde_vecu / $seconde_par_an));
                  	echo "<b>Age : </b>".$age." ans<br />";
                  	$newdate = $chiffre[2]."/".$chiffre[1]."/".$chiffre[0];
                  	echo "<b>Date de naissance : </b>".$newdate."<br />";
                  	if($current2['telephone']!='')
                    	echo "<b>Téléphone : </b>".$current2['telephone']."<br />";
                  	echo "<b>Origine : </b>".$this->origine($current2['idPersonne'])."<br />";
                  	echo "<b>Ressource(s) : </b>";
                  	$this->ressource($current2['idPersonne']);
    			}
    		echo "</div>";
    	echo "</div>";
    	
    	echo "<br /><legend></legend>";
    	
    	if($conjoint!='')
    		$sql3 = "SELECT * FROM personne WHERE aPourResponsable1='".$idPersonne."' OR aPourResponsable2='".$idPersonne."' OR aPourResponsable1='".$conjoint."' OR aPourResponsable2='".$conjoint."'";
    	else
        	$sql3 = "SELECT * FROM personne WHERE aPourResponsable1='".$idPersonne."' OR aPourResponsable2='".$idPersonne."'";

    	$ressql3 = $this->db->query($sql3);
    	echo "<div class='row show-grid'>";
        	while($current3=mysql_fetch_assoc($ressql3))
            {
            	echo "<div class='span5'>";  	
                	echo "<legend>Enfant</legend>";
                	echo "<b>Nom : </b>".$current3['nom']."<br />";
                	echo "<b>Prénom : </b>".$current3['prenom']."<br />";
                    $date_de_naissance = $current3['dateNaissance'];                            
                    $chiffre = explode('-',$date_de_naissance);
                    $time_naissance = mktime(0,0,0,$chiffre[2],$chiffre[1],$chiffre[0]);
                    $seconde_vecu = time() - $time_naissance;
                    $seconde_par_an = (1461*24*60*60)/4;
                    $age = floor(($seconde_vecu / $seconde_par_an));
                    echo "<b>Age : </b>".$age." ans<br />";
                    $newdate = $chiffre[2]."/".$chiffre[1]."/".$chiffre[0];
                    echo "<b>Date de naissance : </b>".$newdate."<br />";
                    echo "<b>Responsable(s) légal(s) : </b>";
                    echo "<ul>";
                    	if($current3['aPourResponsable1']==$idPersonne || $current3['aPourResponsable2']==$idPersonne)
                    		echo "<li>".$this->nomReturn($idPersonne)."</li>";
                    	if($conjoint!='')
                    		if($current3['aPourResponsable1']==$conjoint || $current3['aPourResponsable2']==$conjoint)
                      			echo "<li>".$this->nomReturn($conjoint)."</li>";
                    echo "<ul>";
				echo "</div>";
				
                echo "<div class='span1'></div>";
            }
            
        echo "</div>";
        echo "<legend></legend>";
        echo "<div class='row show-grid'>";
        	echo "<div class='span5'>"; 
        ?>
        		<legend>Historique des situations <?php $this->nom($idPersonne); ?></legend>
                    <table id="table" class="table table-striped table-bordered">
              			<thead>
                			<tr>
                  				<th style="text-align:center;background-color:#d9edf7;">Date de l'écrit</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Situation</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Date de rappel</th>
                			</tr>
              			</thead>
              			<tbody>
                		<?php
                        	$situation->liste($idPersonne);
                        ?>
              			</tbody>
          			</table>
        <?php
        	echo "</div>";
				
            echo "<div class='span1'></div>";
        	if($conjoint!='') {
        	echo "<div class='span5'>"; 
        	?>
        	<legend>Historique des situations <?php $this->nom($conjoint); ?></legend>
    
                        <table id="table" class="table table-striped table-bordered">
              				<thead>
                				<tr>
                  					<th style="text-align:center;background-color:#d9edf7;">Date de l'écrit</th>
                  					<th style="text-align:center;background-color:#d9edf7;">Situation</th>
                  					<th style="text-align:center;background-color:#d9edf7;">Date de rappel</th>
                				</tr>
              				</thead>
              				<tbody>
                			<?php
                        		$situation->liste($conjoint);
                        	?>
              				</tbody>
          				</table>
        	<?php
        	echo "</div>";
        	}
        	 
        echo "</div>";
        	 echo "<legend></legend>";
    	echo "<div class='row show-grid'>";
        	echo "<div class='span5'>"; 
        ?>
        <legend>Historique des demandes <?php $this->nom($idPersonne); ?></legend>
        	<table id="table" class="table table-striped table-bordered">
              			<thead>
                			<tr>
                  				<th style="text-align:center;background-color:#d9edf7;">Date de la demande</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Initiative</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Motif</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Rupture</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Orientation</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Prestation</th>
                			</tr>
              			</thead>
              			<tbody>
                		<?php
                        	$demande->historiqueDemande($idPersonne);
                        ?>
              			</tbody>
          			</table>
    	<?php
    	
        	echo "</div>";
				
        	echo "<div class='span1'></div>";
        	if($conjoint!='') {
        	echo "<div class='span5'>"; 
        	?>
        	<legend>Historique des demandes <?php $this->nom($conjoint); ?></legend>
        	<table id="table" class="table table-striped table-bordered">
              			<thead>
                			<tr>
                  				<th style="text-align:center;background-color:#d9edf7;">Date de la demande</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Initiative</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Motif</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Rupture</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Orientation</th>
                  				<th style="text-align:center;background-color:#d9edf7;">Prestation</th>
                			</tr>
              			</thead>
              			<tbody>
                		<?php
                        	$demande->historiqueDemande($conjoint);
                        ?>
              			</tbody>
          			</table>
        	  
        	<?php
        	
        	echo "</div>";
        	}
        	 
		echo "</div>";
	}

}

?>