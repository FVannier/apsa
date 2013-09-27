<?php

class DemandePriseEnCompte {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($interventionEquipeRue,$dateDemande,$initiativeDemande,$idPersonne) {
		$sql = "INSERT INTO demandepriseencompte VALUES (NULL,'$interventionEquipeRue','$dateDemande','$initiativeDemande','$idPersonne')";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function demandepersonne($idDemandePriseEnCompte) {
		$sql = "SELECT * FROM demandepriseencompte WHERE idDemandePriseEnCompte=$idDemandePriseEnCompte";
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		
		return $current['Personne_idPersonne'];
	}
	
	public function historiqueDemande($idPersonne) {
		$sql = "SELECT * FROM demandepriseencompte WHERE Personne_idPersonne=".$idPersonne." ORDER BY dateDemande ASC";
		$ressql = $this->db->query($sql);
		
		while($current = mysql_fetch_assoc($ressql))
		{
			$sql2 = "SELECT * FROM initiativedemande WHERE initiativeDemande=".$current['InitiativeDemande_initiativeDemande'];
			$ressql2 = $this->db->query($sql2);
			$current2 = mysql_fetch_assoc($ressql2);
			
			$sql8 = "SELECT * FROM rupture_has_demandepriseencompte WHERE DemandePriseEnCompte_idDemandePriseEnCompte=".$current['idDemandePriseEnCompte'];
			$ressql8 = $this->db->query($sql8);
			while($current8 = mysql_fetch_assoc($ressql8))
			{
				$sql9 = "SELECT * FROM rupture WHERE idRupture=".$current8['Rupture_idRupture'];
				$ressql9 = $this->db->query($sql9);
				$current9 = mysql_fetch_assoc($ressql9);
			}
			
			$dateDemande = explode("-",$current['dateDemande']);
			$dateDemande2 = $dateDemande[2]."/".$dateDemande[1]."/".$dateDemande[0];
			
			echo "<tr class='warning'>";
            	echo "<td style='text-align:center;font-weight:bold;'>".$dateDemande2."</td>";
                echo "<td style='text-align:center;'>".$current2['intituleDemande']."</td>";
                
                echo "<td style='text-align:center;'>";
                $sql4 = "SELECT * FROM motif_has_demandepriseencompte WHERE DemandePriseEnCompte_idDemandePriseEnCompte=".$current['idDemandePriseEnCompte'];
				$ressql4 = $this->db->query($sql4);
				while($current4 = mysql_fetch_assoc($ressql4))
				{
					$sql5 = "SELECT * FROM motif WHERE idMotif=".$current4['Motif_idMotif'];
					$ressql5 = $this->db->query($sql5);
					while($current5 = mysql_fetch_assoc($ressql5))
						echo "*".$current5['intituleMotif']."<br />";
				}
                echo "</td>";
                
                echo "<td style='text-align:center;'>".$current9['intituleRupture'];
                if($current8['dateRupture']!=NULL)
                	echo $current8['dateRupture'];
                echo "</td>";
                
                echo "<td style='text-align:center;'>";
                $sql3 = "SELECT * FROM orientation_has_demandepriseencompte WHERE DemandePriseEnCompte_idDemandePriseEnCompte=".$current['idDemandePriseEnCompte'];
				$ressql3 = $this->db->query($sql3);
				while($current3 = mysql_fetch_assoc($ressql3))
				{
					$sql10 = "SELECT * FROM orientation WHERE idOrientation='".$current3['Orientation_idOrientation']."'";
					$ressql10 = $this->db->query($sql10);
					while($current10 = mysql_fetch_assoc($ressql10))
					{
						echo "*".$current10['intituleOrientation']."<br />";
					}
				}
                echo "</td>";
                echo "<td style='text-align:center;'>";
                $sql6 = "SELECT * FROM prestation_has_demandepriseencompte WHERE DemandePriseEnCompte_idDemandePriseEnCompte=".$current['idDemandePriseEnCompte'];
				$ressql6 = $this->db->query($sql6);
				while($current6 = mysql_fetch_assoc($ressql6))
				{
					$sql7 = "SELECT * FROM prestation WHERE idPrestation=".$current6['Prestation_idPrestation'];
					$ressql7 = $this->db->query($sql7);
					while($current7 = mysql_fetch_assoc($ressql7))
                		echo "*".$current7['typePrestation']."<br />";
				}
                echo "</td>";
            echo "</tr>";
			
		}
	}

	public function liste() {
		$date=date('Y-m-d');
		$sql = "SELECT * FROM demandepriseencompte WHERE interventionEquipeRue=1 AND dateDemande='$date'";
		$ressql = $this->db->query($sql);

		while($current = mysql_fetch_assoc($ressql))
		{
			$sql3 = "SELECT * FROM intervention WHERE demandePriseEnCompte_idDemandePriseEnCompte=".$current['idDemandePriseEnCompte'];
			$ressql3 = $this->db->query($sql3);
			$current3 = mysql_fetch_assoc($ressql3);
			
			if($current3=='')
			{
				$sql2 = "SELECT * FROM personne WHERE idPersonne=".$current['Personne_idPersonne'];
				$ressql2 = $this->db->query($sql2);
			
				while($current2 = mysql_fetch_assoc($ressql2))
				{
					echo "<label class='checkbox'>";
					
						echo "<input type='checkbox' name='demande' value='".$current['idDemandePriseEnCompte']."' />";

						echo "<b>".$current2['nom']." ".$current2['prenom']."</b> - ";
						
						$this->demande($current['idDemandePriseEnCompte']);						
										
					echo "</label>";
				}
			}
		}	
	}

	public function demande($idDemandePriseEnCompte) {
		$sql = "SELECT * FROM prestation_has_demandepriseencompte WHERE DemandePriseEnCompte_idDemandePriseEnCompte=".$idDemandePriseEnCompte;
		$ressql = $this->db->query($sql);
		
		while($current = mysql_fetch_assoc($ressql))
		{
			if($current!=''){
				$sql2 = "SELECT * FROM prestation WHERE idPrestation=".$current['Prestation_idPrestation'];
				$ressql2 = $this->db->query($sql2);
				
				while($current2 = mysql_fetch_assoc($ressql2))
				{
					echo $current2['typePrestation']."<br />";
				}
			}
		}
	}

}

?>
